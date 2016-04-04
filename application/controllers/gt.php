<?php
/**
 * File - gt.php
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
 * Class - Gt Class
 * G-Tracer 관련 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Gt extends MY_Controller
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
     * 로그인 처리 포함
     */
    function __construct()
    {
        parent::__construct();

        //개발 버전일경우 css, js minify
        if (defined('ENVIRONMENT') && ENVIRONMENT == 'development') {
            $this->load->driver('minify');

            //css
            $this->minify->save_file(
                $this->minify->combine_files(
                    array(
                        'assets/css/gt-style.css',
                        'assets/plugins/forms_elements_bootstrap-switch/'
                        .'bootstrap-switch.css',
                    )
                ),
                'assets/css/common.gt.min.css'
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
                        'assets/plugins/forms_elements_bootstrap-select/js/'
                        .'bootstrap-select.js',
                        'assets/components/forms_elements_bootstrap-select/'
                        .'bootstrap-select.init.js',
                        'assets/components/admin_menus/sidebar.kis.init.js',
                        'assets/plugins/forms_elements_bootstrap-switch/'
                        .'js/bootstrap-switch.js',
                        'assets/plugins/charts_sparkline/jquery.sparkline.min.js',
                        'assets/plugins/forms_elements_bootstrap-datepicker/js/'
                        .'bootstrap-datepicker.js',
                        'assets/components/charts_sparkline/sparkline.init.js',
                        'assets/components/core/core.init.js',
                        'assets/library/excel/jquery.base64.js',
                        'assets/library/excel/tableExport.js',
                        'assets/js/gt/jn_gapi.js',
                        'assets/js/gt/view.js',
                        'assets/js/gt/core.js',
                        'assets/js/gt/constants.js',
                        'assets/js/gt/chart.js',
                        'assets/js/gt/string.js',
                        'assets/js/gt/sites.js',
                        'assets/js/gt/common.js',
                        'assets/js/jnutil.js',
                    )
                ),
                'assets/js/common.gt.min.js'
            );
        }

        $this->checkLogin();

        $this->data['activatedSites'] = array();

        $this->load->model('sites', 'sites_m');
        $this->data['sites']
            = $this->sites_m->getSitesOrderByStatus($this->tank_auth->get_user_id());

        $this->load->model('goals');
        $this->data['goals'] = $this->goals->getGoalsByGoalNumber(
            array("uid" => $this->tank_auth->get_user_id())
        );
        
        $this->load->model('menus');
        $this->data['menus'] = $this->menus->get_menus_by_type('gt');
        
        $this->load->model('permissions');
        $this->data['permissions'] = $this->permissions->get_all();

        foreach ($this->data['sites'] as $site) {
            if ($site->status == 'ACTIVATED') {
                array_push($this->data['activatedSites'], $site);
            }
        }

        $this->load->model('user_profiles');
        $this->data['myGoogleAccout'] =
            $this->user_profiles->getGoogleAccout(
                $this->tank_auth->get_user_id()
            );
            
        $selectedSites = null;
        $selectedPermission = null;

        if(isset($_GET['select'])) {
            foreach($this->data['activatedSites'] as $site) {
                if($_GET['select'] == 'ga:'.$site->profile_id) {
                    $selectedSites = $site;
                    break;
                }
            }
        } else {
            $selectedSites = $this->data['activatedSites'][0];
        }
        
        foreach($this->data['permissions'] as $permission) {
            if($selectedSites->permission == $permission->id) {
                $selectedPermission = $permission;
                break;
            }
        }
        
        $this->data['pem_ids'] = explode(',', $selectedPermission->menu_ids);
        
        $this->load->model('products');
        $this->data['products'] = $this->products->get_many_by(array(
            'sid' => $selectedSites->id
        ));
        $this->data['sid'] = $selectedSites->id;
    }

    /**
     * Method - index
     *
     * 기본 실행 Method
     * 사이트 존재 여부에 따라 dashboard 혹은 sites 호출
     *
     * @return void
     */
    function index()
    {
        if(empty($this->data['activatedSites'])) {
            redirect('/gt/sites');
        } else {
            redirect('/gt/dashboard');
        }
    }

    /**
     * Method - dashboard
     *
     * 특별한 처리 없이 view 호출
     *
     * @return void
     */
    function dashboard()
    {
        if(empty($this->data['activatedSites'])) {
            redirect('/gt/sites');
        }
        
        $pem_chk = false;
        $menuId = 0;
        
        foreach($this->data['menus'] as $menu) {
            if($menu->eng_name == 'dashboard') {
                $menuId = $menu->id;
                break;
            }
        }
        
        foreach($this->data['pem_ids'] as $pemId) {
            if($menuId == $pemId) {
                $pem_chk = true;
                break;
            }
        }

        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        if($pem_chk) {
            $this->load->view('gt/dashboard', $this->data);
        } else {
            $this->load->view('gt/permission', $this->data);
        }
        $this->load->view('common/gt_footer', $this->data);
    }

    /**
     * Method - report
     *
     * 개발 중
     *
     * @param int $user_id   사용자 아이디
     * @param int $site_id   사이트 아이디
     * @param int $report_id 리포트 아이디
     *
     * @return void
     */
    function report($report)
    {
        if(empty($this->data['activatedSites'])) {
            redirect('/gt/sites');
        }
        
        $pem_chk = false;
        $menuId = 0;
        
        foreach($this->data['menus'] as $menu) {
            if(!empty($menu->subMenus)) {
                foreach($menu->subMenus as $sub) {
                    if($sub->eng_name == $report) {
                        $menuId = $sub->id;
                        break;
                    }
                }
            } else {
                if($menu->eng_name == $report) {
                    $menuId = $menu->id;
                    break;
                }
            }
            
            if($menuId != 0) break;
        }
        
        foreach($this->data['pem_ids'] as $pemId) {
            if($menuId == $pemId) {
                $pem_chk = true;
                break;
            }
        }
        
        $this->data['report'] = $report;

        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        if($pem_chk) {
            $this->load->view('gt/report/'.$report, $this->data);
        } else {
            $this->load->view('gt/permission', $this->data);
        }
        $this->load->view('common/gt_footer', $this->data);
    }
    
    /**
     * Method - goal
     *
     * 개발 중
     *
     * @param int $user_id   사용자 아이디
     * @param int $site_id   사이트 아이디
     * @param int $report_id 리포트 아이디
     *
     * @return void
     */
    function goal($goalId)
    {
        if(empty($goalId)) {
            redirect('/gt/dashboard');
        }
        
        $this->load->model('goals');
        $this->data['goal'] = $this->goals->get($goalId);

        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        $this->load->view('gt/report/goal', $this->data);
        $this->load->view('common/gt_footer', $this->data);
    }

    /**
     * Method - settings
     *
     * 사용자 정보 변경 및 저장
     *
     * @return void
     */
    function settings()
    {
        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        $this->load->view('gt/settings', $this->data);
        $this->load->view('common/gt_footer', $this->data);
    }

    /**
     * Method - sites
     *
     * 사이트 정보 출력
     *
     * @return void
     */
    function sites()
    {
        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        $this->load->view('gt/sites', $this->data);
        $this->load->view('common/gt_footer', $this->data);
    }

    /**
     * Method - consults
     *
     * 사이트 정보 출력
     *
     * @return void
     */
    function consults()
    {
        $this->load->view('common/gt_header', $this->data);
        $this->load->view('common/gt_sidebar', $this->data);
        $this->load->view('common/gt_nav', $this->data);
        $this->load->view('gt/consults', $this->data);
        $this->load->view('common/gt_footer', $this->data);
    }

    /**
     * Method - download
     *
     * 파일 다운로드
     *
     * @return void
     */
    function download($filename)
    {
        $this->load->helper('download');

        // Read the file's contents
        $data = file_get_contents(
            "/home/hosting_users/gtracer/www/jam0929/assets/excel/excel.xlsx"
        );

        force_download($filename, $data);
    }

    /**
     * Method - ajaxCreateSites(작업 필요)
     *
     * AJAX 요청만 처리
     * 사이트 정보 신규 등록 및 업데이트
     *
     * @return void
     */
    function ajaxCreateSites()
    {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $sites = isset($_POST['sites']) ? json_decode($_POST['sites']) : null;
        
        if (empty($sites)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return;
        }

        //새로운 데이터 입력
        $insert_data = array();

        foreach ($sites as $accountKey => $account) {
            $accountId = $account->id;
            $accountName = $account->name;

            foreach ($account->properties as $propertyKey => $property) {
                $propertyId = $property->id;
                $propertyName = $property->name;

                foreach ($property->profiles as $profileKey => $profile) {
                    $profileId = $profile->id;
                    $profileName = $profile->name;

                    $site = array(
                        'updated' => date("Y-m-d H:i:s", time()),
                        'created' => date("Y-m-d H:i:s", time()),
                        'account_id' => $accountId,
                        'account_name' => $accountName,
                        'property_id' => $propertyId,
                        'property_name' => $propertyName,
                        'profile_id' => $profileId,
                        'profile_name' => $profileName,
                        'user_id' => $this->tank_auth->get_user_id()
                    );

                    array_push($insert_data, $site);
                }
            }
        }

        $this->sites_m->updateSites($insert_data);

        echo json_encode($result);
    }

    /**
     * Method - ajaxSiteStatusChange
     *
     * AJAX 요청만 처리
     * 사이트 Status 변경
     *
     *
     * @return void
     */
    function ajaxSiteStatusChange() {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $sid = isset($_POST['sid']) ? $_POST['sid'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        if (empty($sid) || empty($status)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }

        $this->sites_m->setSiteStatus($sid, $status);

        echo json_encode($result);
        return true;
    }

    /**
     * Method - ajaxCheckGoogleAccount
     *
     * AJAX 요청만 처리
     * 유저의 구글 계정 체크
     * 있다면 비교, 없다면 삽입
     *
     *
     * @return void
     */
    function ajaxCheckGoogleAccount() {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $googleAccount
            = isset($_GET['googleAccount']) ? $_GET['googleAccount'] : null;

        if (empty($googleAccount)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }

        $this->load->model('user_profiles');

        if($this->user_profiles->checkUserGoogleAccount(
            $this->tank_auth->get_user_id(), $googleAccount
        )) {
            echo json_encode($result);
            return true;
        } else {
            $result['response'] = 400;
            $result['message'] = 'not matched google account';

            echo json_encode($result);
            return false;
        }
    }

    /**
     * Method - ajaxSetDefaultSite
     *
     * AJAX 요청만 처리
     * 기본 사이트로 세팅
     *
     *
     * @return void
     */
    function ajaxSetDefaultSite() {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $siteId = isset($_POST['sid']) ? $_POST['sid'] : null;
        $isDefault = isset($_POST['isDefault']) ? $_POST['isDefault'] : null;

        if (empty($siteId) || empty($isDefault) || $isDefault != 1) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }

        $this->load->model('sites', 'sites_m');
        $this->sites_m->setSiteIsDefault(
            $siteId,
            1,
            $this->tank_auth->get_user_id()
        );

        echo json_encode($result);
        return true;
    }

    /**
     * Method - ajaxExcelDownload
     *
     * AJAX 요청만 처리
     * 전송받은 데이터를 엑셀로 출력
     *
     *
     * @return excel file
     */
    function ajaxExcelDownload() {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $filename = isset($_POST['filename']) ? $_POST['filename'] : null;
        $data = isset($_POST['data']) ? json_decode($_POST['data']) : null;

        if (empty($filename) || empty($data)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }

        // PHPExcel 라이브러리 로드
        $this->load->library('excel');

        // 워크시트에서 1번째는 활성화
        $this->excel->setActiveSheetIndex(0);

        // 워크시트 이름 지정
        $this->excel->getActiveSheet()->setTitle($filename);

        //글꼴 변경
        $this->excel->getDefaultStyle()->getFont()
            ->setName('맑은 고딕')->setSize(10);

        $rowNum = 1;
        foreach ($data as $row) {
            $colNum = 'A';

            foreach($row as $col) {
                $this->excel->getActiveSheet()->setCellValue($colNum.$rowNum, $col);
                $colNum++;
            }
            $rowNum++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        // 서버에 파일을 저장합니다.
        $objWriter->save(
            '/home/hosting_users/gtracer/www/jam0929/assets/excel/excel.xlsx'
        );

        $result['response'] = 200;
        $result['url'] = base_url('gt/download/'.$filename.'-'.time().'.xlsx');

        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxSetProductList
     *
     * AJAX 요청만 처리
     * 상품목록 업데이트
     *
     *
     * @return void
     */
    function ajaxSetProductList() {
        $this->checkAjaxRequest();

        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $productList = isset($_POST['productList']) 
            ? json_decode($_POST['productList']) : null;
        $sid = isset($_POST['sid']) ? $_POST['sid'] : null;

        if (empty($productList) || empty($sid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }
        
        $this->load->model('products');
        
        $pCount = $this->products->count_by(array(
            'sid' => $sid
        ));
        
        if($pCount > 0) {
            $this->products->delete_by(array(
                'sid' => $sid
            ));
        }
        
        $insertProducts = array();
        
        for($i=0; $i<count($productList); $i++) {
            $product = array(
                'name' => $productList[$i]->name,
                'roi' => $productList[$i]->roi,
                'sid' => $sid,
                'created' => date("Y-m-d H:i:s", time()),
                'updated' => date("Y-m-d H:i:s", time())
            );
            
            array_push($insertProducts, $product);
        }
        
        $this->products->insert_many($insertProducts);

        echo json_encode($result);
        return true;
    }
    
    /**
     * Method - ajaxProductUploadByExcel
     *
     * AJAX 요청만 처리
     * 상품목록 업데이트 by Excel
     *
     *
     * @return void
     */
    function ajaxProductUploadByExcel() {
        $this->config->set_item('compress_output', false);
        
        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $file = isset($_FILES['product']) ? $_FILES['product'] : null;
        $sid = isset($_POST['sid']) ? $_POST['sid'] : null;
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : null;

        if (empty($file) || empty($sid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }
        
        $filename = $file['name'];
        $filepath = pathinfo($filename);
        $fileExt = strtolower($filepath['extension']);
        
        if($fileExt != 'xlsx') {
            $result['response'] = 400;
            $result['message'] = 'not xlsx';

            echo json_encode($result);
            return false;
        }
        
        $this->load->library('excel');
        
        $objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
        $productList = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        if($productList[1]['A'] != '상품명' || $productList[1]['B'] != '원가') {
            $result['response'] = 400;
            $result['message'] = 'not matched format';

            echo json_encode($result);
            return false;
        }
        
        $this->load->model('products');
        
        $pCount = $this->products->count_by(array(
            'sid' => $sid
        ));
        
        if($pCount > 0) {
            $this->products->delete_by(array(
                'sid' => $sid
            ));
        }
        
        $insertProducts = array();
        
        for($i=2; $i<count($productList); $i++) {
            $product = array(
                'name' => $productList[$i]['A'],
                'roi' => $productList[$i]['B'] ? $productList[$i]['B'] : 0,
                'sid' => $sid,
                'created' => date("Y-m-d H:i:s", time()),
                'updated' => date("Y-m-d H:i:s", time())
            );
            
            array_push($insertProducts, $product);
        }
        
        $this->products->insert_many($insertProducts);

        redirect($redirect);
    }
    
    /**
     * Method - ajaxGetProducts
     *
     * AJAX 요청만 처리
     * 상품목록 
     *
     *
     * @return void
     */
    function ajaxGetProducts() {
        $this->checkAjaxRequest();
        
        $result = array(
            'response' => 200,
            'message' => 'success'
        );

        $sid = isset($_GET['sid']) ? $_GET['sid'] : null;

        if (empty($sid)) {
            $result['response'] = 400;
            $result['message'] = 'not enough parameter';

            echo json_encode($result);
            return false;
        }
        
        $this->load->model('products');
        $result['products'] = $this->products->get_many_by(
            array('sid' => $sid)
        );
        
        echo json_encode($result);
        return true;
    }
}

/* End of file gt.php */
/* Location: ./application/controllers/gt.php */