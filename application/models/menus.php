<?php 
/**
 * File - menus.php
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
 * Class - Models Class 
 * Models 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2015 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Menus extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table 이름을 지정
     */
    protected $_table = "Menus";
    
    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_menus_by_type($type) {
        $this->order_by('order');
        $rootMenus = $this->get_many_by(array('type' => $type, 'parent' => 0));
        
        for($i=0; $i<count($rootMenus); $i++) {
            $this->order_by('order');
            $rootMenus[$i]->subMenus = $this->get_many_by(
                array(
                    'type' => $type, 
                    'parent' => $rootMenus[$i]->id
                )
            );
        }
        
        return $rootMenus;
    }
}

/* End of file sites.php */
/* Location: ./application/models/sites.php */