<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
<<<<<<< Updated upstream

$routes->get('personen', 'Personen::index');
$routes->get('personen/getPersonenAjax', 'Personen::getPersonenAjax');
$routes->get('personen/pdf/(:num)', 'Personen::pdf/$1');



$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
=======
$routes->get('/table', 'Home::table');
$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('generatepdf', 'Home2::generatePDF');
$routes->get('viewpdfformat', 'Home2::viewPDFFormat');
>>>>>>> Stashed changes
