<?php 
/**
 * File - frontend.php
 *
 * PHP Version 5.4
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
 
if (!defined('BASEPATH')) { 
    exit('No direct script access allowed');
};

/**
 * Class - Frontend 
 * Static 페이지 출력 관련 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Frontend extends CI_Controller
{
    /**
     * Memeber functions
     *
     * @var array $data View를 위한 data 저장
     */
    var $data;  //data for view
    
    /**
     * Method - Class Constructor
     * 
     * 특이사항 없음
     */
    function __construct()
    {
        parent::__construct();
        
        $this->lang->load('common', $this->config->item('language'));
        $this->data['is_login'] = $this->tank_auth->is_logged_in();
        $this->data['is_admin'] = $this->tank_auth->is_admin();
        
        $this->data['title'] = "G-Tracer";
        
        //개발 버전일경우 css, js minify
        if (defined('ENVIRONMENT') && ENVIRONMENT == 'development') {
            $this->load->driver('minify');
            
            //css
            $this->minify->save_file(
                $this->minify->combine_files(
                    array(
                        'assets/css/vendor/bootstrap.min.css', 
                        'assets/css/flat-ui.css', 
                        'assets/css/ui-kit-styles.css', 
                        'assets/css/style.css',
                    )
                ), 
                'assets/css/common.min.css'
            );
            
            //js
            $this->minify->save_file(
                $this->minify->combine_files(
                    array(
                        'assets/js/startup-kit.js', 
                    )
                ), 
                'assets/js/common.min.js'
            );
        }
    }

    /**
     * Method - index
     *
     * 기본 실행 Method
     * 페이지 타입을 전달받고 해당 view를 호출하여 출력
     *
     * @param string $type 페이지 타입 설정
     *
     * @return bool
     */
    function index($type=null)
    {
        $this->load->view('common/header', $this->data);
        $this->load->view('common/nav', $this->data);
        $this->load->view(
            ($type == null) ? 'common/404' : 'frontend/'.$type, $this->data
        );
        $this->load->view('common/footer', $this->data);
        
        return true;
    }
}

/* End of file frontend.php */
/* Location: ./application/controllers/frontend.php */