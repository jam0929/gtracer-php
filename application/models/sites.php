<?php 
/**
 * File - sites.php
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
 * Class - Sites Class 
 * Sites 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Sites extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table 이름을 지정
     */
    protected $_table = "Sites";
    private $_user_table_name    = 'Users';    // users
    
    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Method - updateSites
     *
     * 해당 유저의 사이트 정보를 갱신한다.
     *
     * @param int $sites
     *
     * @return void
     */
    public function updateSites($sites) {
        foreach($sites as $site) {
            $before = $this->get_by(array(
                'account_id' => $site['account_id'],
                'property_id' => $site['property_id'],
                'profile_id' => $site['profile_id'],
                'user_id' => $site['user_id']
            ));
            
            if(empty($before)) {
                $this->insert($site);
            } else {
                $this->update($before->id, $site);
            }
        }
    }
    
    /**
     * Method - getSitesOrderByStatus
     *
     * 해당 유저의 사이트 정보를 status 기준으로 정렬하여 가져온다.
     *
     * @param int $userId
     *
     * @return array 
     */
    public function getSitesOrderByStatus($userId = null, $offset=0, $limit=200) {
        
        $this->db->select($this->_table.'.*');
        $this->db->select($this->_user_table_name.'.username');
        $this->db->join(
            $this->_user_table_name, 
            $this->_user_table_name.'.id = '.$this->_table.'.user_id'
        );
        $this->db->limit($limit, $offset);
        $this->db->limit($limit);
        $this->order_by($this->_table.'.status', 'DESC');
        
        if($userId) {
            return $this->get_many_by(array('user_id' => $userId));
        } else {
            return $this->get_all();
        }
    }
    
    /**
     * Method - getPaidSites
     *
     * 해당 유저의 사이트 정보를 status 기준으로 정렬하여 가져온다.
     *
     * @param int $userId
     *
     * @return array 
     */
    public function getPaidSites($userId = null, $offset=0, $limit=20) {
        
        $this->db->select($this->_table.'.*');
        $this->db->select($this->_user_table_name.'.username');
        $this->db->join(
            $this->_user_table_name, 
            $this->_user_table_name.'.id = '.$this->_table.'.user_id'
        );
        $this->db->limit($limit, $offset);
        $this->db->limit($limit);
        $this->order_by($this->_table.'.status', 'DESC');
        $this->db->where_in($this->_table.'.status', array('ACTIVATED', 'ACTIVATED PENDING'));
        
        if($userId) {
            $this->db->where($this->_table.'.user_id', $userId);
        }
        
        return $this->get_all();
        
    }
    
    /**
     * Method - setSiteStatus
     *
     * 사이트의 status를 변경
     *
     * @param int $siteId
     * @param string $status
     * @param string $activateDate
     * @param string $isDefault
     *
     * @return void
     */
    public function setSiteStatus(
        $siteId, 
        $status="NOT ACTIVATED",
        $activateDate="0000-00-00 00:00:00"
    ) {
        $data = array(
            "status" => $status,
            "updated" => date("Y-m-d H:i:s", time())
        );
        
        if($status == "NOT ACTIVATED" || $status == "PENDING") {
            $data['activate_date'] = "0000-00-00 00:00:00";
            $data['is_default'] = 0;
        } else if($status == "ACTIVATED") {
            $data['activate_date'] = $activateDate;
            
            if($this->_checkDefault($siteId)) {
                $this->setSiteIsDefault($siteId, 1);
            }
        }
        
        $this->update($siteId, $data);
    }
    
    /**
     * Method - setSiteIsDefault
     *
     * 사이트의 is_default 값을 변경
     *
     * @param int $siteId
     *
     * @return void
     */
    public function setSiteIsDefault($siteId, $isDefault=0, $userId=0) {
        if($userId != 0) {
            $this->update_by(
                array(
                    'user_id' => $userId
                ),
                array(
                    'is_default' => 0
                )
            );
        }
        
        $data = array(
            "is_default" => $isDefault,
            "updated" => date("Y-m-d H:i:s", time())
        );
        
        $this->update($siteId, $data);
    }
    
    /**
     * Method - _checkDefault
     *
     * 사이트의 is_default 값을 체크하여 한개가 있으면 false, 한개도 없으면 true
     *
     * @param int $siteId
     *
     * @return boolean
     */
    public function _checkDefault($siteId) {
        $data = array(
            "id" => $siteId,
            "is_default" => 1
        );
        
        if($this->count_by($data) > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /**
     * Method - countPaidSites
     *
     * 결제 사용자 수
     *
     * @param string $email
     *
     * @return object
     */
    function countPaidSites($userId=null) 
    {
            /*
        $this->db->where(array('status' => 'ACTIVATED'))->or_where(array('status' => 'ACTIVATED PENDING'));
        
        return $this->get_all();
        */
        if($userId) {
            return $this->count_by(array('status'=>array('ACTIVATED', 'ACTIVATED PENDING'), 'user_id' => $userId));
        } else {
            return $this->count_by(array('status'=>array('ACTIVATED', 'ACTIVATED PENDING')));
        }
    }
}

/* End of file sites.php */
/* Location: ./application/models/sites.php */