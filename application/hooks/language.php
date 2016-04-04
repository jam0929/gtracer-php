<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends CI_Controller
{
    var $lang_code, $country_code, $default, $accept_languages;
    
    function __construct() {
		parent::__construct();
        
        $this->load->helper('url');
        $this->load->library('user_agent');
		$this->load->library('session');
        
        $this->default = array('lang_code' => 'en', 'country_code' => 'us');
        $this->accept_languages = preg_split('/(\,|\;)/', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']));
    }
    
    public function language() {
        /******
        lang(2char)-country(2char)
        URL�� ����������
        �켱����: Userset > Session > browser
        
        URL ü��
        startupbomb.com/number
        startupbomb.com/countrycode/number
        
        �Ǵܷ���
        URL�� ���� ������ ���� ���
            ������ �ִ� ���
                ������ ����ڵ�/�����ڵ� ���
            ������ ���� ���
                ������ �ڵ� �ؼ�
                    ������ ����ڵ�/�����ڵ� ���� �� ���
        URL�� ���� ������ ���� ���
            ������ �ִ� ���
                ������ ����ڵ常 ���
            ������ ���� ���
                ������ �ڵ� �ؼ�
                    ������ ����ڵ常 ���
        ******/
        
        $path = $_SERVER['REQUEST_URI'];
        
        if($path == '/' || 
            !$this->is_support_lang(substr($path,1,2)) ||
            !$this->is_support_country(substr($path,4,2))) {
            //country setting
            if($this->session->userdata('lang_code') && $this->session->userdata('country_code')) {
                //������ ���� ��
            } else {
                //������ ���� ��
                foreach($this->accept_languages as $al) {
                    $al_split = explode('-', $al);
                    
                    //���ǿ� ���� ���� �ʾ��� ���� ����
                    if(!$this->session->userdata('lang_code') && $this->is_support_lang($al_split[0])) {
                        $this->session->set_userdata('lang_code', $al_split[0]);
                    }
                    //���ǿ� ���� ���� �ʾ��� ���� ����
                    if(!$this->session->userdata('country_code') && isset($al_split[1]) && $this->is_support_country($al_split[1])) {
                        $this->session->set_userdata('country_code', $al_split[1]);
                    }
                }
                //�ݺ��� ������ ���� ��
                if(!$this->session->userdata('lang_code')) {
                    $this->session->set_userdata('lang_code', $this->default['lang_code']);
                }
                if(!$this->session->userdata('country_code')) {
                    $this->session->set_userdata('country_code', $this->default['country_code']);
                }
            }
            redirect('/'.$this->session->userdata('lang_code').'-'.$this->session->userdata('country_code').$path);
        } else {
            //������
            $this->session->set_userdata(
                'lang_code', 
                $this->is_support_lang(substr($path,1,2)) ? substr($path,1,2) : $this->default['lang_code']
            );
            $this->session->set_userdata(
                'country_code', 
                $this->is_support_country(substr($path,4,2)) ? substr($path,4,2) : $this->default['country_code']
            );
            
            $this->config->set_item('language', $this->lang_code2lang($this->session->userdata('lang_code')));
        }
    }
    
    public function is_support_country($str) {
        if(strlen($str) != 2) return FALSE;
        
        $support_country = array(
            'us',
            'kr',
            'jp',
            'cn',
        );
        
        return in_array($str, $support_country);
    }
    
    public function is_support_lang($str) {
        if(strlen($str) != 2) return FALSE;
        
        $support_lang = array(
            'en',
            'ko',
            'jo',
            'zn',
        );
        
        return in_array($str, $support_lang);
    }
    
    public function lang_code2lang($lang_code) {
        $match = array(
            'en' => 'english',
            'ko' => 'korean',
            'jo' => 'japanese',
            'zn' => 'chinese',
        );
        return isset($match[$lang_code]) ? $match[$lang_code] : FALSE;
    }
    
    
}