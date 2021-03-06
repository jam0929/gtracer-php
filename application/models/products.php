<?php 
/**
 * File - products.php
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
 * Class - Products Class 
 * Products 모델 클래스
 *
 * @category  Class
 * @package   Gtracer
 * @author    Hwan Oh <hwangoon@gmail.com>
 * @author    Jae Moon Kim <jam0929@gmail.com>
 * @copyright 2013-2014 Jumping Nuts Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://jumpingnuts.com
 */
class Products extends MY_Model
{
    /**
     * Memeber functions
     *
     * @var string $_table Table 이름을 지정
     */
    protected $_table = "Products";
    
    /**
     * Method - Class Constructor
     */
    public function __construct() 
    {
        parent::__construct();
    }
}

/* End of file products.php */
/* Location: ./application/models/products.php */