<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');

class Minify_cs_js extends CI_Controller {
    function __construct() {
		parent::__construct();
        /*
        
        $this->load->helper('url');
        $this->load->library('user_agent');
		$this->load->library('session');
        
        $this->default = array('lang_code' => 'en', 'country_code' => 'us');
        $this->accept_languages = preg_split('/(\,|\;)/', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']));
        */
        $this->load->helper('url');
        $this->load->driver('minify');
    }
    
    public function index() {
        $this->css();
        $this->js();
    }
    
    public function css() {
        $files = array(
            'assets/css/vendor/bootstrap.min.css', 
            'assets/css/flat-ui.css', 
            'assets/css/ui-kit-styles.css', 
            'assets/css/style.css',
        );
        $contents = $this->minify->combine_files($files);
        $this->minify->save_file($contents, 'assets/css/common.min.css');
    }
    
    public function js() {
        $files = array(
            'assets/js/startup-kit.js', 
        );
        $contents = $this->minify->combine_files($files);
        $this->minify->save_file($contents, 'assets/js/common.min.js');
    }
    
}