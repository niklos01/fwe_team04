<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('personen', 'Home::indexPersonen');
$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('home/pdf/(:num)', 'Home::pdf/$1');

$routes->get('home/last-12-months', 'Home::last12Months');
$routes->get('home/last12-months', 'Home::last12Months');
$routes->get('home/current-month-comparison', 'Home::currentMonthComparison');

$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');
$routes->get('home/generatePdfAll', 'Home::generatePdfAll');

$routes->get("api/", "Api::index");
$routes->get("api/weather", "Api::weather");
$routes->post("api/chat", "Api::chat");

// CRUD Routes für Personen
$routes->get('api/crud/(:num)', 'Api::crud/$1');
$routes->get('api/crud', 'Api::crud');
$routes->post('api/crud', 'Api::crud');
$routes->put('api/crud/(:num)', 'Api::crud/$1');
$routes->delete('api/crud/(:num)', 'Api::crud/$1');
