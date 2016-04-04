<?php 
/**
 * File - goals.php
 *
 * PHP Version 5.4
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2015 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
 
if (!defined('BASEPATH')) { 
    exit('No direct script access allowed');
};

/**
 * Class - Gaols Class 
 * Gaols �� Ŭ����
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2015 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Goals extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table �̸��� ����
     */
    protected $_table = "Goals";
    
    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Method - getGoalsByGoalNumber
     *
     * �ش� ������ ��ǥ ������ ��ǥ��ȣ �������� �����Ͽ� �����´�.
     *
     * @param int $userId
     *
     * @return array 
     */
    public function getGoalsByGoalNumber($userId = null) {
        $this->order_by('goal_number');
        return $this->get_many_by(array('uid' => $userId));
    }
}

/* End of file sites.php */
/* Location: ./application/models/sites.php */