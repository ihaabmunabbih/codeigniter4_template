<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('home', ['namespace' => 'App\Modules\Home\Controllers', 'filter' => 'AuthFilter'], function($subroutes){

	/*** Route for About ***/
	$subroutes->add('about', 'About::index');

	/*** Route for Home ***/
	$subroutes->add('/', 'Home::index');

});