<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "frontend/index/welcome";
$route['404_override'] = 'frontend/index';

//$route['product/(:num)'] = "catalog/product_lookup_by_id/$1";
//$route['products/([a-z]+)/(\d+)'] = "$1/id_$2";

//statics
$route['about'] = 'frontend/index/about';
$route['how-it-works'] = 'frontend/index/how-it-works';
$route['pricing'] = 'frontend/index/pricing';
$route['help'] = 'frontend/index/help';

//commit
$route['commit'] = 'commit/index';
$route['commit/send-email'] = 'commit/sendEmail';

//admin
$route['admin'] = 'admin/index';
$route['admin/ajax-change-password'] = 'admin/ajaxChangePassword';
$route['admin/ajax-change-banned'] = 'admin/ajaxChangeBanned';
$route['admin/ajax-change-permission'] = 'admin/ajaxChangePermission';
$route['admin/ajax-google-init'] = 'admin/ajaxGoogleInit';
$route['admin/ajax-user-delete'] = 'admin/ajaxUserDelete';
$route['admin/ajax-site-status-change'] = 'admin/ajaxSiteStatusChange';
$route['admin/ajax-add-goal'] = 'admin/ajaxAddGoal';
$route['admin/ajax-delete-goal'] = 'admin/ajaxDeleteGoal';
$route['admin/sites-user-search'] = 'admin/sitesUserSearch';
$route['admin/consults-user-search'] = 'admin/consultsUserSearch';
$route['admin/(:any)'] = 'admin/$1';

//gt
$route['gt/ajax-site-status-change'] = 'gt/ajaxSiteStatusChange';
$route['gt/ajax-set-default-site'] = 'gt/ajaxSetDefaultSite';

/* End of file routes.php */
/* Location: ./application/config/routes.php */