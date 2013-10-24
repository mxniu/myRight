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

$route['admin808'] = 'admin';
$route['admin808/(:any)'] = 'admin/$1';
//$route['login'] = 'login';
$route['function/(:any)'] = 'functioning/$1';
$route['viewajax/(:any)'] = 'viewajax/$1';

$route['(:any)/alabama'] = 'layout/$1/alabama';
$route['(:any)/alaska'] = 'layout/$1/alaska';
$route['(:any)/arizona'] = 'layout/$1/arizona';
$route['(:any)/arkansas'] = 'layout/$1/arkansas';
$route['(:any)/california'] = 'layout/$1/california';
$route['(:any)/colorado'] = 'layout/$1/colorado';
$route['(:any)/connecticut'] = 'layout/$1/connecticut';
$route['(:any)/delaware'] = 'layout/$1/delaware';
$route['(:any)/dc'] = 'layout/$1/dc';
$route['(:any)/florida'] = 'layout/$1/florida';
$route['(:any)/georgia'] = 'layout/$1/georgia';
$route['(:any)/hawaii'] = 'layout/$1/hawaii';
$route['(:any)/idaho'] = 'layout/$1/idaho';
$route['(:any)/illinois'] = 'layout/$1/illinois';
$route['(:any)/indiana'] = 'layout/$1/indiana';
$route['(:any)/iowa'] = 'layout/$1/iowa';
$route['(:any)/kansas'] = 'layout/$1/kansas';
$route['(:any)/kentucky'] = 'layout/$1/kentucky';
$route['(:any)/louisiana'] = 'layout/$1/louisiana';
$route['(:any)/maine'] = 'layout/$1/maine';
$route['(:any)/maryland'] = 'layout/$1/maryland';
$route['(:any)/massachusetts'] = 'layout/$1/massachusetts';
$route['(:any)/michigan'] = 'layout/$1/michigan';
$route['(:any)/minnesota'] = 'layout/$1/minnesota';
$route['(:any)/mississippi'] = 'layout/$1/mississippi';
$route['(:any)/missouri'] = 'layout/$1/missouri';
$route['(:any)/montana'] = 'layout/$1/montana';
$route['(:any)/nebraska'] = 'layout/$1/nebraska';
$route['(:any)/nevada'] = 'layout/$1/nevada';
$route['(:any)/new-hampshire'] = 'layout/$1/new-hampshire';
$route['(:any)/new-jersey'] = 'layout/$1/new-jersey';
$route['(:any)/new-mexico'] = 'layout/$1/new-mexico';
$route['(:any)/new-york'] = 'layout/$1/new-york';
$route['(:any)/north-carolina'] = 'layout/$1/north-carolina';
$route['(:any)/north-dakota'] = 'layout/$1/north-dakota';
$route['(:any)/ohio'] = 'layout/$1/ohio';
$route['(:any)/oklahoma'] = 'layout/$1/oklahoma';
$route['(:any)/oregon'] = 'layout/$1/oregon';
$route['(:any)/pennsylvania'] = 'layout/$1/pennsylvania';
$route['(:any)/rhode-island'] = 'layout/$1/rhode-island';
$route['(:any)/south-carolina'] = 'layout/$1/south-carolina';
$route['(:any)/south-dakota'] = 'layout/$1/south-dakota';
$route['(:any)/tennessee'] = 'layout/$1/tennessee';
$route['(:any)/texas'] = 'layout/$1/texas';
$route['(:any)/utah'] = 'layout/$1/utah';
$route['(:any)/vermont'] = 'layout/$1/vermont';
$route['(:any)/virginia'] = 'layout/$1/virginia';
$route['(:any)/washington'] = 'layout/$1/washington';
$route['(:any)/west-virginia'] = 'layout/$1/west-virginia';
$route['(:any)/wisconsin'] = 'layout/$1/wisconsin';
$route['(:any)/wyoming'] = 'layout/$1/wyoming';

$route['(:any)/(:any)'] = 'viewscreen/$2';
$route['(:any)/(:any)'] = 'viewscreen/$2';
$route['(:any)'] = 'layout/$1';
//$route['(:any)/(:any)'] = 'layout/$1/$2';
$route['default_controller'] = 'home';
$route['404_override'] = '';



/* End of file routes.php */
/* Location: ./application/config/routes.php */