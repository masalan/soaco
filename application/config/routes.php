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

$route['default_controller'] = "cities";
$route['404_override'] = 'error';
$route['admin'] = 'cities';
$route['soaco'] = 'cities';  /*************************************************************** SOACO ******************************************************/

$route['commune'] = 'cities';
$route['departement'] = 'cities';

$route['creer/commune'] = 'cities/create';
$route['commune/nonvalide'] = 'cities/approval';
$route['apropos'] = 'abouts';


$route['login'] = 'login_station/login';



$route['logout'] = 'login_station/logout';
$route['profile'] = 'dashboard/profile';

/********* RESET ********/

$route['reset/(:any)'] = 'login_station/reset/$1';

$route['forgot'] = 'login_station/forgot';
$route['soaco_pwd'] = 'login_station/forgot';
$route['soaco_modif_passse'] = 'login_station/forgot';

$route['backup'] = 'dashboard/backup';

$route['com'] = 'com/list';
$route['gerants'] = 'feeds';
$route['gerants/add'] = 'feeds/add';
$route['index.php/gerants'] = 'index.php/feeds';
$route['gerant/modifier/(:any)'] = 'feeds/edit/$1';
$route['resultat/recherche'] = 'feeds/search';
$route['modifier/station/(:any)'] = 'items/edit/$1';
$route['ajoute/station'] = 'items/add';
$route['recherche/station'] = 'items/search';
$route['modifier/commune/(:any)'] = 'cities/edit/$1';


$route['manager/(:any)'] = 'dashboard/index/$1';
$route['manager/'] = 'dashboard/index';
$route['manager'] = 'dashboard/index';


$route['gestion/(:any)'] = 'stationdesk/index/$1';
$route['gestion'] = 'stationdesk/index';
$route['responsable/(:any)'] = 'users/edit/$1';

$route['pay_essence/(:any)'] = 'desk/add/$1';
$route['fixer/(:any)'] = 'reglage/index/$1';
$route['fixer/'] = 'reglage/index';
$route['fixer'] = 'reglage/index';
$route['fixer/(:any)'] = 'reglage/index';

$route['stations_services'] = 'items';

$route['modifier/societe/(:any)'] = 'societe/edit/$1';
$route['supprime/societe/(:any)'] = 'societe/delete_company/$1';

/********* STATION ********/
$route['station'] = 'login_station/login';  // Page de connexion de Station
$route['station/'] = 'login_station/login';  // Page de connexion de Station
$route['bienvenue_SOACO_E_station/'] = 'login_station/login';
$route['bienvenue_SOACO_e_station'] = 'login_station/login';

$route['station_exit'] = 'login_station/logout';
$route['exit'] = 'login_station/logout';


/********* STATION  ********/

$route['desk/(:any)'] = 'desk/index/$1';
$route['soaco_e-Station'] = 'desk/index';
$route['soaco_e-Station/(:any)'] = 'desk/index/$1';
$route['sent_notes/(:any)'] = 'desk/sent_notes/$1';

$route['desk'] = 'desk/index';  /*************************************************************** DESK ******************************************************/


/********* MSG ********/
$route['soaco_liste_msg'] = 'inquiries';
$route['soaco_Liste_msg'] = 'inquiries';
$route['soaco_list_msg'] = 'inquiries';
$route['soaco_msg_vue/(:any)'] = 'inquiries/detail/$1';

/********* Facture ********/
$route['soaco_e-facture/(:any)'] = 'invoice/index/$1';
$route['soaco_e-facture/'] = 'invoice/index';
$route['soaco_e-facture'] = 'invoice/index';

/********* Statistques ********/
$route['statistiques/(:any)'] = 'statistiques/index/$1';
$route['statistiques/'] = 'statistiques/index';
$route['statistiques'] = 'statistiques/index';

/********* Ravitaillement Step 0********/
$route['stock/(:any)'] = 'ravit/index/$1';
$route['stock/'] = 'ravit/index';
$route['stock'] = 'ravit/index';

/********* Ravitaillement Step 1********/
$route['produit/(:any)'] = 'ravit/step1/$1';
$route['produit/'] = 'ravit/step1';
$route['produit'] = 'ravit/step1';


/********* Ravitaillement Step 2********/
$route['code/(:any)'] = 'ravit/step2/$1';
$route['code/'] = 'ravit/step2';
$route['code'] = 'ravit/step2';

/********* Ravitaillement Step 2********/
$route['fini/(:any)'] = 'ravit/step3/$1';
$route['fini/'] = 'ravit/step3';
$route['fini'] = 'ravit/step3';


/********* Done ********/
$route['felicitation/(:any)'] = 'ravit/step4/$1';
$route['felicitation/'] = 'ravit/step4';
$route['felicitation'] = 'ravit/step4';



$route['soaco_e-data_store'] = 'ravit/validate_data';
$route['soaco_e-check_code'] = 'ravit/check_code';


/********* Ensemble ********/
$route['ensemble/(:any)'] = 'ensemble/index/$1';
$route['ensemble/'] = 'ensemble/index';
$route['ensemble'] = 'ensemble/index';

/********* MSG ********/
$route['messages/(:any)'] = 'mail/index/$1';
$route['messages/'] = 'mail/index';
$route['messages'] = 'mail/index';
$route['soaco_e-Station/messages/'] = 'mail/index';

/********* MENU ********/
$route['zones'] = 'categories';


/********* Company ********/
$route['company/(:any)'] = 'company/index/$1';
$route['company/'] = 'company/index';
$route['company'] = 'company/index';
$route['soaco_e-company/'] = 'company/index';



$route['company/zones'] = 'overview/index';
$route['zones'] = 'overview/index';
$route['zones/(:any)'] = 'overview/index/$1';

/********* Company| Zone ********/

$route['zone_details'] = 'socle/index';
$route['zone_details'] = 'socle/index';
$route['zone_details/(:any)'] = 'socle/index/$1';

/********* Coupon ********/



$route['check_code/(:any)'] = 'coupons/check_code/$1';
$route['check_code/'] = 'coupons/check_code';
$route['check_code'] = 'coupons/check_code';


$route['check/(:any)'] = 'coupons/check/$1';
$route['check/'] = 'coupons/check';
$route['check'] = 'coupons/check';


$route['check_done/(:any)'] = 'coupons/check_done/$1';
$route['check_done/'] = 'coupons/check_done';
$route['check_done'] = 'coupons/check_done';


$route['code_card/(:any)'] = 'coupons/check_enter_code/$1';
$route['code_card/'] = 'coupons/check_enter_code';
$route['code_card'] = 'coupons/check_enter_code';

// /ravit/index
/* End of file routes.php */
/* Location: ./application/config/routes.php */