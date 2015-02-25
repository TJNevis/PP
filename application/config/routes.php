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

$route['default_controller'] = "index";
$route['404_override'] = '';

//$route['pet-tales/playlist/(:any)'] = "pet_tales/playlist";
//$route['pet-tales/(:num)'] = "pet_tales/index";
//$route['pet-tales'] = 'pet_tales';
//$route['pet-tales/(:any)'] = 'pet_tales/$1';

$route['pet-tales/playlist/(:any)'] = "pet_tales/playlist";
$route['pet-tales/ajax_get_tales/(:any)'] = "pet_tales/ajax_get_tales";
$route['pet-tales/unsubscribe/(:any)'] = "pet_tales/unsubscribe";
$route['pet-tales/(:num)'] = "pet_tales/index";
$route['pet-tales'] = 'pet_tales';
$route['pet-tales/previewemail'] = 'pet_tales/previewemail';
$route['pet-tales/(:any)'] = 'pet_tales/$1';

$route['locations'] = 'locations';
$route['locations/(:any)'] = 'locations/$1';

$route['admin/pet-tales'] = "admin/pet_tales";
$route['admin/pet-tales/(:any)'] = "admin/pet_tales/$1";
$route['admin/content'] = "admin/content";
$route['admin/content/(:any)'] = "admin/content/$1";
$route['admin/noaccess'] = "admin/noaccess";
$route['admin/noaccess/(:any)'] = "admin/noaccess/$1";
$route['admin/users'] = "admin/users";
$route['admin/users/(:any)'] = "admin/users/$1";
$route['admin/owner'] = "admin/owner";
$route['admin/owner/(:any)'] = "admin/owner/$1";
$route['admin/sites'] = "admin/sites";
$route['admin/sites/(:any)'] = "admin/sites/$1";
$route['admin/locations'] = "admin/locations";
$route['admin/locations/(:any)'] = "admin/locations/$1";
$route['admin/webhook'] = "admin/webhook";
$route['admin/webhook/(:any)'] = "admin/webhook/$1";
$route['admin'] = 'admin/index';
//$route['admin/auth/(:any)'] = 'admin/index/auth';
$route['admin/(:any)'] = 'admin/index/$1';

//pet owner login
$route['owner/pet-tales'] = "owner/pet_tales";
$route['owner/pdf/(:any)'] = "owner/pdf/$1";
$route['owner/pet-tales/edit'] = "owner/pet_tales/edit";
$route['owner/pet-tales/edit(:any)'] = "owner/pet_tales/edit/$1";
$route['owner/account'] = "owner/account";
$route['owner/account/(:any)'] = "owner/account/$1";
$route['owner/indexn'] = "owner/indexn";
$route['owner/indexn/(:any)'] = "owner/indexn/$1";
$route['owner/pet'] = "owner/pet";
$route['owner/pet/all'] = "owner/pet/all";
$route['owner/payment'] = "owner/payment";
$route['owner/payment/(:any)'] = "owner/payment/index/$1";
$route['owner/pet/(:any)'] = "owner/pet/index/$1";
$route['owner/noaccess'] = "owner/noaccess";
$route['owner/noaccess/(:any)'] = "owner/noaccess/$1";
$route['owner'] = 'owner/index';
$route['owner/(:any)'] = 'owner/index/$1';

$route['contact'] = "index/contact";
$route['test'] = "index/test";

$route[':any'] = "index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */