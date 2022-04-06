<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['mesas']['get'] = 'mesas/index';
$route['usuarios/(:num)']['get'] = 'usuarios/index/$1';
$route['pedidos/(:num)']['get'] = 'pedidos/index/$1';
$route['pedidos/cierre/(:num)']['post'] = 'pedidos/cierre/$1';
$route['articulos']['get'] = 'articulos/index';
$route['token']['post']='Api/Auth/index';
// $route['productos']['get'] = 'productos/index';
// $route['establecimientos']['get'] = 'establecimientos/index';
// $route['establecimientos-tipos/(:num)']['get'] = 'EstablecimientosTipos/index/$1';





/*$route['businesses']['get'] = 'businesses/index';
$route['businesses/(:any)']['get'] = 'businesses/index/$1';

//PROGRAMS
$route['programs']['get'] = 'programs/index';
$route['programs/(:any)']['get'] = 'programs/index/$1';
$route['programs/itinerary/(:any)']['get'] = 'programs/byItinerary/$1';

//TYPES OF PROGRAMS
$route['types-of-programs/(:any)']['get'] = 'typesOfPrograms/index/$1';

//ITINERARIES
$route['itineraries/program/(:any)']['get'] = 'itineraries/byProgram/$1';

//ORIGINS
$route['origins/(:any)']['get'] = 'origins/index/$1';

//PRICES
$route['prices/itinerary/(:any)']['get'] = 'prices/byItinerary/$1';

//IMAGES
$route['images/itinerary/(:any)']['get'] = 'images/byItinerary/$1';

//DAYS 
$route['days/itinerary/(:any)']['get'] = 'itineraryDays/byItinerary/$1';

//DETAILS
$route['details/day/(:any)']['get'] = 'itineraryDayDetails/byDay/$1';

//INCLUDED
$route['included/day/(:any)']['get'] = 'itineraryDayIncluded/byDay/$1';
$route['not-included/day/(:any)']['get'] = 'itineraryDayNotIncluded/byDay/$1';

//DESTINATIONS
$route['destinations/day/(:any)']['get'] = 'destinations/byDay/$1';

//RESPONSIBLES
$route['responsibles']['get'] = 'responsibles/index';
$route['responsibles/user/(:any)']['get'] = 'responsibles/byUser/$1';
$route['responsibles']['post'] = 'responsibles/index';

//PERSONS
$route['persons']['post'] = 'persons/index';

//CELLPHONES
$route['cellphones']['post'] = 'cellphones/index';
*/