<?php 
/**
 * File - consults.php
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
 * Class - Consults Class 
 * Consults �� Ŭ����
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Consults extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table �̸��� ����
     */
    protected $_table = "Consults";
    
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
     * �ش� ������ ����Ʈ ������ �����Ѵ�.
     *
     * @param int $sites
     *
     * @return void
     */
    public function updateConsults($sites) {
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
     * �ش� ������ ����Ʈ ������ status �������� �����Ͽ� �����´�.
     *
     * @param int $userId
     *
     * @return array 
     */
    public function getSitesOrderByStatus($userId) {
        $this->order_by('status', 'DESC');
        
        return $this->get_many_by(array('user_id' => $userId));
    }
    
    /**
     * Method - setSiteStatus
     *
     * ����Ʈ�� status�� ����
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
     * ����Ʈ�� is_default ���� ����
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
     * ����Ʈ�� is_default ���� üũ�Ͽ� �Ѱ��� ������ false, �Ѱ��� ������ true
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
}

/* End of file sites.php */
/* Location: ./application/models/sites.php */