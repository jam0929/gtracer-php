<?php 
/**
 * File - user_profiles.php
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
 * Class - User_profiles Class 
 * User_profiles 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class User_profiles extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table 이름을 지정
     */
    protected $_table = "User_profiles";
    
    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Method - setIsAdmin
     *
     * is_admin 값 변경
     *
     * @param string $userId
     * @param string $isAdmin
     *
     * @return void
     */
    function setIsAdmin($userId, $isAdmin=0) 
    {
        $this->update_by(
            array('user_id' => $userId), array('is_admin' => $isAdmin)
        );
    }
    
    /**
     * Method - getGoogleAccout
     *
     * is_admin 값 변경
     *
     * @param string $userId
     *
     * @return string
     */
    function getGoogleAccout($userId) {
        $user = $this->get_by(array('user_id' => $userId));
        
        return $user->google_account;
    }
    
    /**
     * Method - checkUserGoogleAccount
     *
     * 유저의 Google Account 값 비교.
     * 있으면 비교, 없으면 삽입
     * 같거나 삽입하면 true
     * 다르다면 false
     *
     * @param string $userId
     * @param string $email
     *
     * @return boolean
     */
    function checkUserGoogleAccount($userId, $googleAccount) 
    {
        $myGoogleAccout = $this->getGoogleAccout($userId);
        
        if(empty($myGoogleAccout)) {
            $this->update_by(
                array('user_id' => $userId), 
                array('google_account' => $googleAccount)
            );
            return true;
        } else if($myGoogleAccout == $googleAccount) {
            return true;
        } else if($myGoogleAccout != $googleAccount) {
            return false;
        }
        
        return false;
    }
    
    /**
     * Method - initGoogleAccount
     *
     * 유저의 Google Account 값 초기화.
     *
     * @param string $userId
     *
     * @return void
     */
    function initGoogleAccount($userId) 
    {
        $this->update_by(
            array('user_id' => $userId), 
            array('google_account' => '')
        );
    }
    
    /**
     * Method - deleteUserProfile
     *
     * 유저 Profile 삭제
     *
     * @param string $userId
     *
     * @return void
     */
    function deleteUserProfile($userId) 
    {
        $this->delete_by(
            array('user_id' => $userId)
        );
    }
}

/* End of file user_profile.php */
/* Location: ./application/models/user_profile.php */