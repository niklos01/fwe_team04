<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('personen', 'Home::indexPersonen');
$routes->get('personen/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('personen/pdf/(:num)', 'Home::pdf/$1');

$routes->get('umsatz/last-12-months', 'Home::last12Months');
$routes->get('umsatz/last12-months', 'Home::last12Months');
$routes->get('umsatz/current-month-comparison', 'Home::currentMonthComparison');

$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('home/generatePdfAll', 'Home::generatePdfAll');

// $routes->resource("api");
$routes->get("api/", "Api::index");                  // Different path
$routes->get("api/reqWithAuth", "Api::reqWithAuth"); // Different path

$routes->get("api2/", "Api2::index");                  // Different path
$routes->get("api2/reqWithAuth", "Api2::reqWithAuth"); // Different path
$routes->get("api2/crud", "Api2::crud"); // Different path

