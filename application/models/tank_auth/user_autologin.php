<?php 
/**
 * File - user_autologin.php
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
 * Class - User_Autologin Class 
 * User_autologin 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class User_Autologin extends CI_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table_name Table 이름을 지정
     * @var string $_users_table_name 사용자 table 이름을 지정
     * @var string $_profile_table_name 사용자 프로필 table 이름을 지정
     */
    private $_table_name            = 'User_autologin';
    private $_users_table_name    = 'Users';

    // 141126
    // user profile table added by jm
    private $_profile_table_name    = 'User_profiles';

    /**
     * Method - Class Constructor
     *
     * CI 객체 생성, table prefix가 있다면 table 이름 변경
     */
    function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $this->_table_name            
            = $ci->config->item('db_table_prefix', 'tank_auth').$this->_table_name;
        $this->_users_table_name 
            = $ci->config->item('db_table_prefix', 'tank_auth')
                .$this->_users_table_name;

        // 141126
        // user profile table added by jm
        $this->_profile_table_name 
            = $ci->config->item('db_table_prefix', 'tank_auth')
                .$this->_profile_table_name;
    }

    /**
     * Get user data for auto-logged in user.
     * Return null if given key or user ID is invalid.
     *
     * @param int    $user_id user id
     * @param string $key     key
     *
     * @return object
     */
     /*
    function get($user_id, $key)
    {
        $this->db->select($this->_users_table_name.'.id');
        $this->db->select($this->_users_table_name.'.username');
        $this->db->from($this->_users_table_name);
        $this->db->join(
            $this->_table_name, 
            $this->_table_name.'.user_id = '.$this->_users_table_name.'.id'
        );
        $this->db->where($this->_table_name.'.user_id', $user_id);
        $this->db->where($this->_table_name.'.key_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row();
        return null;
    }
    */
    
    //141126 get is_admin from User_profiles table by jm
    /**
     * Get user data for auto-logged in user.
     * Return null if given key or user ID is invalid.
     *
     * @param int    $user_id user id
     * @param string $key     key
     *
     * @return object
     */
    function get($user_id, $key)
    {
        $this->db->select($this->_users_table_name.'.id');
        $this->db->select($this->_users_table_name.'.username');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_users_table_name);
        $this->db->join(
            $this->_table_name, 
            $this->_table_name.'.user_id = '.$this->_users_table_name.'.id'
        );
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_users_table_name.'.id'
        );
        $this->db->where($this->_table_name.'.user_id', $user_id);
        $this->db->where($this->_table_name.'.key_id', $key);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return null;
    }

    /**
     * Save data for user's autologin
     *
     * @param int    $user_id user id
     * @param string $key     key
     *
     * @return bool
     */
    function set($user_id, $key)
    {
        return $this->db->insert(
            $this->_table_name, 
            array(
                'user_id'       => $user_id,
                'key_id'        => $key,
                'user_agent'    => substr($this->input->user_agent(), 0, 149),
                'last_ip'       => $this->input->ip_address(),
            )
        );
    }

    /**
     * Delete user's autologin data
     *
     * @param int    $user_id user id
     * @param string $key     key
     *
     * @return void
     */
    function delete($user_id, $key)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('key_id', $key);
        $this->db->delete($this->_table_name);
    }

    /**
     * Delete all autologin data for given user
     *
     * @param int $user_id user id
     *
     * @return void
     */
    function clear($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->_table_name);
    }

    /**
     * Purge autologin data for given user and login conditions
     *
     * @param int $user_id user id
     *
     * @return void
     */
    function purge($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
        $this->db->where('last_ip', $this->input->ip_address());
        $this->db->delete($this->_table_name);
    }
}

/* End of file user_autologin.php */
/* Location: ./application/models/auth/user_autologin.php */