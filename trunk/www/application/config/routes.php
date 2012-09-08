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

$route['default_controller']				= "home";
$route['404_override']				= '';
$route['user/:any']					= 'user/member/$2';
$route['user/settings']					= 'user/settings';
$route['user/addwish']				= 'user/addWish';
$route['user/addWishAjax']				= 'user/addWishAjax';
$route['user/searchWishAjax']			= 'user/searchWishAjax';
$route['user/addWishURLAjax']			= 'user/addWishURLAjax';
$route['user/update']					= 'user/update';
$route['user/save_package_name']		= 'user/save_package_name';
$route['user/save_package_data']		= 'user/save_package_data';
$route['user/current']					= 'user/current';
$route['user/scrapeWishFromURLRobert']	= 'user/scrapeWishFromURLRobert';
$route['user/getUserWishList']			= 'user/getUserWishList';
$route['user/linkAccountRequest']		= 'user/linkAccountRequest';
$route['user/manage_xp']				= 'user/manage_xp';
$route['user/linkAccount']				= 'user/linkAccount';


/* End of file routes.php */
/* Location: ./application/config/routes.php */