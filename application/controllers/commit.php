<?php 
/**
 * File - commit.php
 * 커밋 메세지를 DB에 저장하고 이메일로 보내는 스크립트
 *
 * PHP Version 5.4
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
 
if (!defined('BASEPATH')) { 
    exit('No direct script access allowed');
};

/**
 * Class - Commit
 * 작업 내역 보고 관련 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */

class Commit extends CI_Controller
{
    /**
     * Method - Class Constructor
     * 
     * 특이사항 없음
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('commits');
    }
    
    /**
     * Method - index
     *
     * 기본 실행 Method
     * Bitbucket의 hook으로 동작, DB에 Commit 기록
     *
     * @return bool
     */
    function index() 
    {
        $headers = $this->input->request_headers();
        $posts = $this->input->post(null, true);
        
        if ($headers['Content-type'] != 'application/x-www-form-urlencoded' 
            AND isset($posts['payload'])
        ) {
            echo "잘못된 접근";
            return false;
        }
        
        $data = json_decode($posts['payload'], true);
        
        foreach ($data['commits'] AS $c) {
            $author = $c['author'];
            $branch = $c['branch'];
            $message = $c['message'];
            
            if ($branch == 'master' && strpos($message, 'Merge') !== false) {
                $message = "테스트 서버 반영";
            }
            
            $matches = null;
            preg_match('/([0-9]+)\%/', $res[0]->message, $matches);
            
            $this->commits->insert(
                array(
                    'id' => null, 
                    'author' => $author,
                    'branch' => $branch,
                    'message' => $message,
                    'percent' => isset($matches[1]) ? $matches[1] : '0',
                    'created' => date('Y-m-d H:i:s')
                )
            );
        }
        
        return true;
    }

    /**
     * Method - sendEmail
     *
     * Cronjob에 동록되어 이메일 전송
     *
     * @return bool
     */
    function sendEmail()
    {
        if (!$this->input->is_cli_request()) {
            echo "잘못된 접속";
            return false;
        }
        
        $this->commits->order_by('percent', 'DESC');
        $this->commits->limit(1);
        $res = $this->commits->get_all();
        
        $percent = $res[0]->percent;
        
        
        $today = date('Y-m-d H:i:s');
        $dayago = date('Y-m-d H:i:s', strtotime('-1 days'));
        $this->commits->order_by('created', 'ASC');
        $res = $this->commits->get_many_by(
            array('created <=' => $today, 'created >' => $dayago)
        );
        
        $worked = [];
        $issues = [];
        $working = [];
        
        foreach ($res AS $r) {
            if ($r->author == 'hwangoon') {
                $r->author = '오환';
            } else if ($r->author == 'jam0929') {
                $r->author = '김재문';
            }
            
            if (strpos($r->message, '이슈') !== false) {
                array_push($issues, $r);
            } else if (strpos($r->message, '작업중') !== false) {
                array_push($working, $r);
            } else {
                array_push($worked, $r);
            }
        }
        
        $html = "
            안녕하세요. 점핑너츠입니다. <br />
            <br />
            금일(".date('Y년 m월 d일').")의 작업내역입니다.<br />
            <br />
            <hr /><br />
            1. 일간 진행 업무 보고<br />
            - 하루동안 진행된 사안:<br /> 
            <ul>
            ";
        if ($worked == []) {
            $html .= '<li>내역 없음</li>';
        }
            
        foreach ($worked AS $w) {
            $html .= '<li>작업자: '.$w->author.', '
                .'작업내역: <b>'.$w->message.'</b> - '
                .$w->created."</li>";
        }
        
        $html .= "
            </ul>
            - 금일 미처리 업무:<br />
            <ul>
        ";
        if ($working == []) {
            $html .= '<li>내역 없음</li>';
        }
            
        foreach ($working AS $w) {
            $html .= '<li>작업자: '.$w->author.', '
                .'작업내역: <b>'.$w->message.'</b> - '
                .$w->created."</li>";
        }
        
        $html .= "
            </ul>
            2. 전체 진행 과정(예상): ".$percent."%<br />
            3. 업무 관련 이슈 사안:
            <ul>
            ";
        
        if ($issues == []) {
            $html .= '<li>내역 없음</li>';
        }
        foreach ($issues AS $i) {
            $html .= '<li>작업자: '.$w->author.', '
                .'작업내역: <b>'.$i->message.'</b> - '
                .$w->created.'</li>';
        }
        
        $html .= "
            </ul><br />
            <hr /><br />
            
            감사합니다.
        ";
        
        //echo $html;
        
        $this->load->library('awslib');
        $client = $this->awslib->aws->get('Ses');
        
        $msg = array();
        $msg['Source'] = '"Jumping Nuts Inc." <nuts@jumpingnuts.com>';
        //ToAddresses must be an array
        $msg['Destination']['ToAddresses'][] 
            = '"Jumping Nuts Inc." <nuts@jumpingnuts.com>';
        $msg['Destination']['ToAddresses'][]
            = '"Jiwoo Song" <jiwoorun@lab543.com>';
        $msg['Destination']['ToAddresses'][]
            = '"Hyojeong Lee" <hyojlee@lab543.com>';

        $msg['Message']['Subject']['Data'] 
            = "점핑너츠 - ".date('Y년 m월 d일')." 일일보고";
        $msg['Message']['Subject']['Charset'] = "UTF-8";

        /*
        $msg['Message']['Body']['Text']['Data'] 
            = $this->load->view('email/'.$type.'-txt', $data, true);
        $msg['Message']['Body']['Text']['Charset'] = "UTF-8";
        */
        $msg['Message']['Body']['Html']['Data'] = $html;
        $msg['Message']['Body']['Html']['Charset'] = "UTF-8";
        
        $client->sendEmail($msg);
    }
}

/* End of file commit.php */
/* Location: ./application/controllers/commit.php */