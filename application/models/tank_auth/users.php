<?php 
/**
 * File - users.php
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
 * Class - Users Class 
 * Users 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Users extends CI_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table_name Table 이름을 지정
     * @var string $_profile_table_name 사용자 프로필 table 이름을 지정
     */
    private $_table_name            = 'Users';            // user accounts
    private $_profile_table_name    = 'User_profiles';    // user profiles

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
            = $ci->config->item('db_table_prefix', 'tank_auth')
            .$this->_table_name;
        $this->_profile_table_name 
            = $ci->config->item('db_table_prefix', 'tank_auth')
            .$this->_profile_table_name;
    }

    /**
     * Method - get_user_by_id
     * 
     * Get user record by Id
     *
     * @param int  $user_id   user id
     * @param bool $activated activated
     *
     * @return object
     */
    function get_user_by_id($user_id, $activated)
    {
        /*
        $this->db->where('id', $user_id);
        $this->db->where('activated', $activated ? 1 : 0);
        
        $query = $this->db->get($this->_table_name);
        */
        
        //141126 get is_admin from User_profiles table by jm
        $this->db->select($this->_table_name.'.*');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_table_name);
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_table_name.'.id'
        );
        $this->db->where($this->_table_name.'.id', $user_id);
        $this->db->where($this->_table_name.'.activated', $activated ? 1 : 0);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }
    
    /**
     * Method - get_user_by_login
     * 
     * Get user record by login (username or email)
     *
     * @param string $login login
     *
     * @return object
     */
    function get_user_by_login($login)
    {
        /*
        $this->db->where('LOWER(username)=', strtolower($login));
        $this->db->or_where('LOWER(email)=', strtolower($login));
        
        $query = $this->db->get($this->_table_name);
        */
        
        //141126 get is_admin from User_profiles table by jm
        $this->db->select($this->_table_name.'.*');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_table_name);
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_table_name.'.id'
        );
        $this->db->where(
            'LOWER('.$this->_table_name.'.username'.')=', strtolower($login)
        );
        $this->db->or_where(
            'LOWER('.$this->_table_name.'.email'.')=', strtolower($login)
        );
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }
    
    /**
     * Method - get_user_by_username
     * 
     * Get user record by username
     *
     * @param string $username username
     *
     * @return object
     */
    function get_user_by_username($username)
    {
        /*
        $this->db->where('LOWER(username)=', strtolower($username));

        $query = $this->db->get($this->_table_name);
        */
        
        //141126 get is_admin from User_profiles table by jm
        $this->db->select($this->_table_name.'.*');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_table_name);
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_table_name.'.id'
        );
        $this->db->where(
            'LOWER('.$this->_table_name.'.username'.')=', strtolower($username)
        );
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Method - get_user_by_email
     * 
     * Get user record by email
     *
     * @param string $email email
     *
     * @return object
     */
    function get_user_by_email($email)
    {
        /*
        $this->db->where('LOWER(email)=', strtolower($email));

        $query = $this->db->get($this->_table_name);
        */
        
        //141126 get is_admin from User_profiles table by jm
        $this->db->select($this->_table_name.'.*');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_table_name);
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_table_name.'.id'
        );
        $this->db->where(
            'LOWER('.$this->_table_name.'.email'.')=', strtolower($email)
        );
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Method - is_username_available
     * 
     * Check if username available for registering
     *
     * @param string $username username
     *
     * @return bool
     */
    function is_username_available($username)
    {
        $this->db->select('1', false);
        $this->db->where('LOWER(username)=', strtolower($username));

        $query = $this->db->get($this->_table_name);
        return $query->num_rows() == 0;
    }

    /**
     * Method - is_email_available
     * 
     * Check if email available for registering
     *
     * @param string $email email
     *
     * @return bool
     */
    function is_email_available($email)
    {
        $this->db->select('1', false);
        $this->db->where('LOWER(email)=', strtolower($email));
        $this->db->or_where('LOWER(new_email)=', strtolower($email));

        $query = $this->db->get($this->_table_name);
        return $query->num_rows() == 0;
    }

    /**
     * Create new user record
     *
     * @param array $data      data
     * @param bool  $activated activated
     *
     * @return array
     */
    function create_user($data, $activated = true)
    {
        $data['created'] = date('Y-m-d H:i:s');
        $data['activated'] = $activated ? 1 : 0;

        if ($this->db->insert($this->_table_name, $data)) {
            $user_id = $this->db->insert_id();
            if ($activated) {
                $this->create_profile($user_id);
            }
            return array('user_id' => $user_id);
        }
        return null;
    }

    /**
     * Activate user if activation key is valid.
     * Can be called for not activated users only.
     *
     * @param int    $user_id           user id
     * @param string $activation_key    activation key
     * @param bool   $activate_by_email activate by email
     *
     * @return bool
     */
    function activate_user($user_id, $activation_key, $activate_by_email)
    {
        $this->db->select('1', false);
        $this->db->where('id', $user_id);
        if ($activate_by_email) {
            $this->db->where('new_email_key', $activation_key);
        } else {
            $this->db->where('new_password_key', $activation_key);
        }
        $this->db->where('activated', 0);
        $query = $this->db->get($this->_table_name);

        if ($query->num_rows() == 1) {

            $this->db->set('activated', 1);
            $this->db->set('new_email_key', null);
            $this->db->where('id', $user_id);
            $this->db->update($this->_table_name);

            $this->create_profile($user_id);
            return true;
        }
        return false;
    }

    /**
     * Purge table of non-activated users
     *
     * @param int $expire_period expire period
     *
     * @return void
     */
    function purge_na($expire_period = 172800)
    {
        $this->db->where('activated', 0);
        $this->db->where('UNIX_TIMESTAMP(created) <', time() - $expire_period);
        $this->db->delete($this->_table_name);
    }

    /**
     * Delete user record
     *
     * @param int $user_id user id
     *
     * @return bool
     */
    function delete_user($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->delete($this->_table_name);
        if ($this->db->affected_rows() > 0) {
            $this->delete_profile($user_id);
            return true;
        }
        return false;
    }

    /**
     * Set new password key for user.
     * This key can be used for authentication when resetting user's password.
     *
     * @param int    $user_id      user id
     * @param string $new_pass_key new pass key
     *
     * @return bool
     */
    function set_password_key($user_id, $new_pass_key)
    {
        $this->db->set('new_password_key', $new_pass_key);
        $this->db->set('new_password_requested', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);

        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Check if given password key is valid and user is authenticated.
     *
     * @param int    $user_id       user id
     * @param string $new_pass_key  new pass key
     * @param int    $expire_period expire period
     *
     * @return void
     */
    function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
    {
        $this->db->select('1', false);
        $this->db->where('id', $user_id);
        $this->db->where('new_password_key', $new_pass_key);
        $this->db->where(
            'UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period
        );

        $query = $this->db->get($this->_table_name);
        return $query->num_rows() == 1;
    }

    /**
     * Change user password if password key is valid and user is authenticated.
     *
     * @param int    $user_id       user id
     * @param string $new_pass      new pass
     * @param string $new_pass_key  new pass key
     * @param int    $expire_period expire period
     *
     * @return bool
     */
    function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
    {
        $this->db->set('password', $new_pass);
        $this->db->set('new_password_key', null);
        $this->db->set('new_password_requested', null);
        $this->db->where('id', $user_id);
        $this->db->where('new_password_key', $new_pass_key);
        $this->db->where(
            'UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period
        );

        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Change user password
     *
     * @param int    $user_id  user id
     * @param string $new_pass new pass
     *
     * @return bool
     */
    function change_password($user_id, $new_pass)
    {
        $this->db->set('password', $new_pass);
        $this->db->where('id', $user_id);

        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Set new email for user (may be activated or not).
     * The new email cannot be used for 
     *login or notification before it is activated.
     *
     * @param int    $user_id       user id
     * @param string $new_email     new email
     * @param string $new_email_key new email key
     * @param bool   $activated     activated
     *
     * @return bool
     */
    function set_new_email($user_id, $new_email, $new_email_key, $activated)
    {
        $this->db->set($activated ? 'new_email' : 'email', $new_email);
        $this->db->set('new_email_key', $new_email_key);
        $this->db->where('id', $user_id);
        $this->db->where('activated', $activated ? 1 : 0);

        $this->db->update($this->_table_name);
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * Activate new email (replace old email with new one) 
     * if activation key is valid.
     *
     * @param int    $user_id       user id
     * @param string $new_email_key new email key
     *
     * @return bool
     */
    function activate_new_email($user_id, $new_email_key)
    {
        $this->db->set('email', 'new_email', false);
        $this->db->set('new_email', null);
        $this->db->set('new_email_key', null);
        $this->db->where('id', $user_id);
        $this->db->where('new_email_key', $new_email_key);

        $this->db->update($this->_table_name);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Update user login info, such as IP-address or login time, and
     * clear previously generated (but not activated) passwords.
     *
     * @param int  $user_id     user id
     * @param bool $record_ip   record ip
     * @param bool $record_time record time
     *
     * @return void
     */
    function update_login_info($user_id, $record_ip, $record_time)
    {
        $this->db->set('new_password_key', null);
        $this->db->set('new_password_requested', null);

        if ($record_ip) {
            $this->db->set('last_ip', $this->input->ip_address());
        }
        if ($record_time) {
            $this->db->set('last_login', date('Y-m-d H:i:s'));
        }

        $this->db->where('id', $user_id);
        $this->db->update($this->_table_name);
    }

    /**
     * Ban user
     *
     * @param int    $user_id user id
     * @param string $reason  reason
     *
     * @return void
     */
    function ban_user($user_id, $reason = null)
    {
        $this->db->where('id', $user_id);
        $this->db->update(
            $this->_table_name, 
            array(
                'banned'        => 1,
                'ban_reason'    => $reason,
            )
        );
    }

    /**
     * Unban user
     *
     * @param int $user_id user id
     *
     * @return void
     */
    function unban_user($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->update(
            $this->_table_name, 
            array(
                'banned'        => 0,
                'ban_reason'    => null,
            )
        );
    }

    /**
     * Create an empty profile for a new user
     *
     * @param int $user_id user id
     *
     * @return bool
     */
    private function create_profile($user_id)
    {
        $this->db->set('user_id', $user_id);
        return $this->db->insert($this->_profile_table_name);
    }

    /**
     * Delete user profile
     *
     * @param int $user_id user id
     *
     * @return void
     */
    private function delete_profile($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->_profile_table_name);
    }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */