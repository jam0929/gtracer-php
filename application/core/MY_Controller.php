<?php 
/**
 * File - MY_Controller.php
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
 * Class - MY_Controller Class 
 * Controller 공용 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
 class MY_Controller extends CI_Controller
 {
    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the model, tie into the CodeIgniter superobject and
     * try our best to guess the table name.
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('common', $this->config->item('language'));
        $this->data['is_login'] = $this->tank_auth->is_logged_in();
        $this->data['is_admin'] = $this->tank_auth->is_admin();

        $this->data['title'] = "G-Tracer";
    }
    
    /**
     * Method - checkLogin
     *
     * 로그인이 되어있는지 체크
     *
     * @return void
     */
    public function checkLogin() 
    {
        if ($this->tank_auth->is_logged_in() == false) {
            redirect(base_url('auth/login?redirect_to='.urlencode(uri_string())));
            return false;
        }
    }
    
    /**
     * Method - checkAdmin
     *
     * 어드민 유저인지 체크
     *
     * @return void
     */
    public function checkAdmin() 
    {
        if ($this->tank_auth->is_admin() == false) {
            redirect(base_url());
            return false;
        }
    }
    
    /**
     * Method - checkAjaxRequest
     *
     * Ajax Request 체크
     * 해당 요청이 Ajax를 통해 온 요청인지를 확인
     *
     * @return void
     */
    public function checkAjaxRequest() 
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        
        $this->config->set_item('compress_output', false);
    }
 }