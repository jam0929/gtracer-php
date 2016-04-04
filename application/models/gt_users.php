<?php 
/**
 * File - gt_users.php
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
 * Class - Gt_users Class 
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
class Gt_users extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table 이름을 지정
     * @var string $_profile_table_name 사용자 프로필 table 이름을 지정
     */
    protected $_table = "Users";
    private $_profile_table_name    = 'User_profiles';    // user profiles

    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Method - getAllUsers
     *
     * 전체 사용자 가져오기
     *
     * @param int $limit  limit
     * @param int $offset offset
     *
     * @return object
     */
    function getAllUsers() 
    {
        $this->db->select($this->_table.'.id');
        $this->db->select($this->_table.'.username');
        $this->db->select($this->_table.'.email');
        $this->db->select($this->_table.'.banned');
        $this->db->select($this->_table.'.created');
        $this->db->select($this->_table.'.modified');
        $this->db->select($this->_profile_table_name.'.is_admin');
        $this->db->from($this->_table);
        $this->db->join(
            $this->_profile_table_name, 
            $this->_profile_table_name.'.user_id = '.$this->_table.'.id'
        );
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }
    
    /**
     * Method - getUserByUsername
     *
     * 유저명으로 유저 검색
     *
     * @param string $username
     *
     * @return object
     */
    function getUserByUsername($username) 
    {
        return $this->get_by(array("username" => $username));
    }
    
    /**
     * Method - getUserByEmail
     *
     * 이메일로 유저 검색
     *
     * @param string $email
     *
     * @return object
     */
    function getUserByEmail($email) 
    {
        return $this->get_by(array("email" => $email));
    }
    
    /**
     * Method - deleteUser
     *
     * 유저명으로 유저 검색
     *
     * @param string $uid
     *
     * @return object
     */
    function deleteUser($uid) 
    {
        return $this->delete($uid);
    }
    
    /**
     * Method - countPaidUsers
     *
     * 결제 사용자 수
     *
     * @param string $email
     *
     * @return object
     */
    function countPaidUsers() 
    {
        
        $this->db->select('count(distinct(`'.$this->_table.'`.username)) AS count');
        $this->db->join(
            'Sites', 
            'Sites.user_id = '.$this->_table.'.id'
        );
        $this->db->where(array('Sites.status' => 'ACTIVATED'))->or_where(array('Sites.status' => 'ACTIVATED PENDING'));
        
        $res = $this->get_all();
        
        return $res[0]->count;
    }
}

/* End of file gt_users.php */
/* Location: ./application/models/gt_users.php */