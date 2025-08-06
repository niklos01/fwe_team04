<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('personen', 'Personen::index');
$routes->get('personen/getPersonenAjax', 'Personen::getPersonenAjax');
$routes->get('personen/pdf/(:num)', 'Personen::pdf/$1');



$routes->get('home/getPersonenAjax', 'Home::getPersonenAjax');