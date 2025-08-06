<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('personen', 'Personen::index');
$routes->get('personen/getPersonenAjax', 'Personen::getPersonenAjax');
$routes->get('personen/pdf/(:num)', 'Personen::pdf/$1');


$routes->get('umsatz/last-12-months', 'Umsatz::last12Months');
$routes->get('umsatz/last12-months', 'Umsatz::last12Months');
$routes->get('umsatz/current-month-comparison', 'Umsatz::currentMonthComparison');


$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('generatepdf', 'Home2::generatePDF');
$routes->get('viewpdfformat', 'Home2::viewPDFFormat');
