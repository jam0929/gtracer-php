<?php 
/**
 * File - admin.php
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
 * Class - Admin
 * 관리자 관련 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Admin extends MY_Controller
{
    /**
     * Memeber functions
     *
     * @var array $data View를 위한 data 저장
     */
    var $data;
    
    /**
     * Method - Class Constructor
     * 
     * 로그인 및 관리자 여부 확인 포함
     */
    function __construct()
    {
        parent::__construct();
        
        //사용 변수
        $this->data['limit'] = 20;
        
        //개발 버전일경우 css, js minify
        if (defined('ENVIRONMENT') && ENVIRONMENT == 'development') {
            $this->load->driver('minify');
            
            //css
            $this->minify->save_file(
                $this->minify->combine_files(
                    array(
                        'assets/css/gt-style.css', 
                    )
                ), 
                'assets/css/common.admin.min.css'
            );
            
            //js
            $this->minify->save_file(
                $this->minify->combine_files(
                    array(
                        'assets/library/modernizr/modernizr.js',
                        'assets/plugins/charts_flot/excanvas.js',
                        'assets/plugins/core_breakpoints/breakpoints.js',
                        'assets/components/core_preload/preload.pace.init.js',
                        'assets/components/admin_menus/sidebar.main.init.js',
                        'assets/components/admin_menus/sidebar.collapse.init.js',
                        'assets/plugins/forms_elements_bootstrap-select'
                        .'/js/bootstrap-select.js',
                        'assets/components/forms_elements_bootstrap-select/'
                        .'bootstrap-select.init.js',
                        'assets/components/admin_menus/sidebar.kis.init.js',
                        'assets/plugins/tables_responsive/js/footable.min.js',
                        'assets/components/tables_responsive/'
                        .'tables-responsive-footable.init.js',
                        'assets/plugins/forms_elements_bootstrap-datepicker/js/'
                        .'bootstrap-datepicker.js',
                        'assets/components/core/core.init.js',
                        'assets/js/admin.js', 
                        'assets/js/vendor/bootstrap-switch.min.js'
                    )
                ), 
                'assets/js/common.admin.min.js'
            );
        }
        
        //로그인 확인
        $this->checkLogin();

        //어드민 확인
        $this->checkAdmin();
    }

    /**
     * Method - index
     *
     * 기본 실행 Method
     * Dashboard로 바로 전달
     *
     * @return void
     */
    function index() 
    {
        redirect(base_url('admin/dashboard'));
    }

    /**
     * Method - dashboard
     *
     * 사용자 대시보드 출력
     *
     * @return void
     */
    function dashboard() 
    {
        $this->load->model('gt_users', 'users_m');
        $this->load->model('sites', 'sites_m');
        $this->data['users_count'] = $this->users_m->count_all();
        $this->data['sites_count'] = $this->sites_m->count_all();
        $this->data['paid_users_count'] = $this->users_m->countPaidUsers();
        $this->data['paid_sites_count'] = $this->sites_m->countPaidSites();
        
        
        $this->load->view('common/admin_header', $this->data);
        $this->load->view('common/admin_sidebar', $this->data);
        $this->load->view('common/admin_nav', $this->data);
        $this->load->view('admin/dashboard', $this->data);
        $this->load->view('common/admin_footer', $this->data);
    }

    /**
     * Method - users
     *
     * 사용자 목록 출력, 관리 가능
     *
     * @return void
     */
    function users($offset=0) 
    {
        $this->data['current_offset'] = $offset;
        $this->load->model('gt_users', 'users_m');
        $this->data['users'] = $this->users_m->getAllUsers();

        $this->load->library('pagination');

        $config['base_url'] = base_url('admin/users/');
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->users_m->count_all();
        $config['per_page'] = $this->data['limit']; 
        
        $config['full_tag_open'] = '<nav class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config); 
        
        $this->load->view('common/admin_header', $this->data);
        $this->load->view('common/admin_sidebar', $this->data);
        $this->load->view('common/admin_nav', $this->data);
        $this->load->view('admin/users', $this->data);
        $this->load->view('common/admin_footer', $this->data);
    }
    
    /**
     * Method - sites
     *
     * 사이트 목록 출력, 관리 가능
     *
     * @return bool
     */
    function sites($userId=0, $offset=0) 
    {
        $this->data['current_offset'] = $offset;
        $this->load->model('sites', 'sites_m');
        $this->data['sites'] = $this->sites_m->getSitesOrderByStatus($userId, $offset, $this->data['limit']);
        
        $siteIds = array();
        foreach($this->data['sites'] as $site) {
            array_push($siteIds, $site->id);
        }
        
        $this->load->model('goals');
        $this->data['goals'] = $this->goals->get_many_by(
            array('sid' => $siteIds)
        );
        
        $this->load->model('permissions');
        $this->data['permissions'] = $this->permissions->get_all();
        
        $this->load->library('pagination');

        $config['base_url'] = base_url('admin/sites/'.$userId);
        $config['uri_segment'] = 4;
        $config['total_rows'] = $userId == 0 ? $this->sites_m->count_all() : $this->sites_m->count_by(array('user_id' => $userId));
        $config['per_page'] = $this->data['limit']; 
        
        $config['full_tag_open'] = '<nav class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config); 
    
        $this->load->view('common/admin_header', $this->data);
        $this->load->view('common/admin_sidebar', $this->data);
        $this->load->view('common/admin_nav', $this->data);
        $this->load->view('admin/sites', $this->data);
        $this->load->view('common/admin_footer', $this->data);
    }
    
    /**
     * Method - permissions
     *
     * 권한 목록 출력, 관리 가능
     *
     * @return bool
     */
    function permissions($pid=1) 
    {
        $this->load->model('permissions');
        $this->data['permissions'] = $this->permissions->get_all();
        
        $this->data['permission'] = $this->permissions->get($pid);
        
        $this->load->model('menus');
        $t_menus = $this->menus->get_all();
        $menus = array();
        
        foreach($t_menus as $menu) {
            if($menu->parent == 0) {
                $submenus = array();
                foreach($t_menus as $submenu) {
                    if($menu->id == $submenu->parent) {
                        array_push($submenus, $submenu);
                    }
                }
                
                $menu->sub = $submenus;
                array_push($menus, $menu);
            }
        }
        
        $this->data['menus'] = $menus;
        
        $this->load->view('common/admin_header', $this->data);
        $this->load->view('common/admin_sidebar', $this->data);
        $this->load->view('common/admin_nav', $this->data);
        $this->load->view('admin/permissions', $this->data);
        $this->load->view('common/admin_footer', $this->data);
    }
    
    /**
     * Method - create_permissions
     *
     * 권한 생성
     *
     * @return bool
     */
    function create_permission() 
    {
        $name = $_POST['name'];
        
        if(!isset($name) || empty($name)) {
            redirect(base_url('admin/dashboard'));
        }
        
        $this->load->model('permissions');
        $insert_id = $this->permissions->insert(array(
            'name' => $name,
            'created_at' => date("Y-m-d H:i:s", time()),
            'updated_at' => date("Y-m-d H:i:s", time())
        ));
        
        redirect(base_url('admin/permissions/'.$insert_id));
    }
    
    /**
     * Method - consults
     *
     * 사이트 목록 출력, 관리 가능
     *
     * @return bool
     */
    function consults($userId=0, $offset=0) 
    {
        $this->data['current_offset'] = $offset;
        $this->load->model('sites', 'sites_m');
        $this->data['sites'] = $this->sites_m->getPaidSites($userId, $offset, $this->data['limit']);
        
        $this->load->library('pagination');

        $config['base_url'] = base_url('admin/consults/'.$userId);
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->sites_m->countPaidSites($userId);
        $config['per_page'] = $this->data['limit']; 
        
        $config['full_tag_open'] = '<nav class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config); 
    
        $this->load->view('common/admin_header', $this->data);
        $this->load->view('common/admin_sidebar', $this->data);
        $this->load->view('common/admin_nav', $this->data);
        $this->load->view('admin/consults', $this->data);
        $this->load->view('common/admin_footer', $this->data);
    }
    
    /**
     * Method - ajaxChangePassword
     *
     * AJAX 요청만 처리
     * 사용자 패스워드 변경
     *
     * @return void
     */
    function ajaxChangePassword() 
    {
        $this->checkAjaxRequest();
        
        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
    
        if (empty($uid) || empty($password)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return;
        }
        
        $hasher = new PasswordHash(
            $this->config->item('phpass_hash_strength', 'tank_auth'),
            $this->config->item('phpass_hash_portable', 'tank_auth')
        );
        $hashedPassword = $hasher->HashPassword($password);

        // Replace old password with new one
        $this->users->change_password($uid, $hashedPassword);
        
        $result['message'] = 'User password has been updated';
        
        echo json_encode($result);
    }
    
    /**
     * Method - ajaxChangeBanned
     *
     * AJAX 요청만 처리
     * 사용자 로그인 차단 상태 관리
     *
     * @return void
     */
    function ajaxChangeBanned() 
    {
        $this->checkAjaxRequest();
        
        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $reason = isset($_POST['reason']) && $_POST['reason'] !== ''
            ? $_POST['reason'] 
            : '관리자에 의해 접속이 차단되었습니다';
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
        $is_banned = isset($_POST['is_banned']) && $_POST['is_banned'] == '1' 
            ? true : false;
    
        if (empty($uid) || empty($reason)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return;
        }
        
        if ($is_banned) {
            $this->users->unban_user($uid);
        } else {
            $this->users->ban_user($uid, $reason);
        }
        
        $result['message'] = 'User '.($is_banned ? 'unbanned' : 'banned');
        
        echo json_encode($result);
    }
    
    /**
     * Method - ajaxChangePermission
     *
     * AJAX 요청만 처리
     * 사용자 권한 관리
     *
     * @return void
     */
    function ajaxChangePermission() 
    {
        $this->checkAjaxRequest();
        
        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
        $isAdmin = isset($_POST['isAdmin']) ? $_POST['isAdmin'] : null;
        
        if(!isset($isAdmin) || empty($uid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            $result['isAdmin'] = $isAdmin;
            $result['uid'] = $uid;
            
            echo json_encode($result);
            return;
        }
        
        $this->load->model('user_profiles');
        $this->user_profiles->setIsAdmin($uid, $isAdmin);
        
        $result['response'] = 200;
        $result['message'] = 'success';
        $result['isAdmin'] = $isAdmin;
        
        echo json_encode($result);
    }
    
    /**
     * Method - ajaxSiteStatusChange
     *
     * AJAX 요청만 처리
     * 사이트의 status를 변경
     *
     * @return void
     */
    function ajaxSiteStatusChange() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $sid = isset($_POST['sid']) ? $_POST['sid'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $activateDate 
            = isset($_POST['activate-date']) 
                ? $_POST['activate-date']." 23:59:59" 
                : "0000-00-00 00:00:00";
        
        if (!isset($sid) || !isset($status)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('sites', 'sites_m');
        $this->sites_m->setSiteStatus($sid, $status, $activateDate);
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxGoogleInit
     *
     * AJAX 요청만 처리
     * 연결되어 있는 구글 계정 초기화
     *
     * @return void
     */
    function ajaxGoogleInit() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
        
        if (!isset($uid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('user_profiles');
        $this->user_profiles->initGoogleAccount($uid);
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxUserDelete
     *
     * AJAX 요청만 처리
     * User 삭제
     *
     * @return void
     */
    function ajaxUserDelete() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
        
        if (!isset($uid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('user_profiles');
        $this->user_profiles->deleteUserProfile($uid);
        
        $this->load->model('gt_users', 'users_m');
        $this->users_m->deleteUser($uid);
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxAddGoal
     *
     * AJAX 요청만 처리
     * Goal 추가
     *
     * @return void
     */
    function ajaxAddGoal() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
        $sid = isset($_POST['sid']) ? $_POST['sid'] : null;
        $goalName = isset($_POST['goal_name']) ? $_POST['goal_name'] : null;
        $goalNum = isset($_POST['goal_num']) ? $_POST['goal_num'] : null;
        
        if (!isset($uid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $goal = array(
            'uid' => $uid,
            'sid' => $sid,
            'goal_name' => $goalName,
            'goal_number' => $goalNum,
            'created' => date("Y-m-d H:i:s", time()),
            'updated' => date("Y-m-d H:i:s", time())
        );

        $this->load->model('goals');
        $result['goalId'] = $this->goals->insert($goal);
                
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxDeleteGoal
     *
     * AJAX 요청만 처리
     * Goal 제거
     *
     * @return void
     */
    function ajaxDeleteGoal() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
    
        $gid = isset($_POST['gid']) ? $_POST['gid'] : null;
        
        if (!isset($gid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }

        $this->load->model('goals');
        $this->goals->delete($gid);
                
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxUpdatePermission
     *
     * AJAX 요청만 처리
     * Permission 수정
     *
     * @return void
     */
    function ajaxUpdatePermission() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
        
        $pemIds = isset($_POST['pem_ids']) ? $_POST['pem_ids'] : '';
        $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
        
        if(empty($pid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('permissions');
        $this->permissions->update($pid, array(
            'menu_ids' => $pemIds,
            'updated_at' => date("Y-m-d H:i:s", time())
        ));
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxDeletePermission
     *
     * AJAX 요청만 처리
     * Permission 수정
     *
     * @return void
     */
    function ajaxDeletePermission() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
        
        $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
        
        if(empty($pid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('permissions');
        $this->permissions->delete($pid);
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxSitePermissionChange
     *
     * AJAX 요청만 처리
     * site의 권한 수정
     *
     * @return void
     */
    function ajaxSitePermissionChange() 
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );
        
        $pid = isset($_POST['pid']) ? $_POST['pid'] : '';
        $sid = isset($_POST['sid']) ? $_POST['sid'] : '';
        
        if(empty($pid) || empty($sid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';
            
            echo json_encode($result);
            return false;
        }
        
        $this->load->model('sites', 'sites_m');
        $this->sites_m->update($sid, array(
            'permission' => $pid,
            'updated' => date("Y-m-d H:i:s", time())
        ));
        
        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - sitesUserSearch
     *
     * 유저의 사이트를 검색
     *
     * @return void
     */
    function sitesUserSearch() 
    {
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $value = isset($_POST['value']) ? $_POST['value'] : null;
        
        if ($type == null || $value == null) {
            redirect(base_url('admin/sites'));
        }
        
        $this->load->model('gt_users', 'users_m');
        
        if($type == 'username') {
            $user = $this->users_m->getUserByUsername($value);
        } else if($type == 'email') {
            $user = $this->users_m->getUserByEmail($value);
        } else {
            redirect(base_url('admin/sites'));
        }
        
        if(!isset($user)) {
            redirect(base_url('admin/sites'));
        }
        
        redirect(base_url('admin/sites/'.$user->id));
    }
    
    /**
     * Method - consultsUserSearch
     *
     * 유저의 사이트를 검색
     *
     * @return void
     */
    function consultsUserSearch() 
    {
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $value = isset($_POST['value']) ? $_POST['value'] : null;
        
        if ($type == null || $value == null) {
            redirect(base_url('admin/consults'));
        }
        
        $this->load->model('gt_users', 'users_m');
        
        if($type == 'username') {
            $user = $this->users_m->getUserByUsername($value);
        } else if($type == 'email') {
            $user = $this->users_m->getUserByEmail($value);
        } else {
            redirect(base_url('admin/consults'));
        }
        
        if(!isset($user)) {
            redirect(base_url('admin/consults'));
        }
        
        redirect(base_url('admin/consults/'.$user->id));
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */