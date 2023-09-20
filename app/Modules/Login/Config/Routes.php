<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('', ['filter' => 'HasAuthFilter'], function($subroutes){

	$subroutes->add('/', 'Login::index');
	$subroutes->add('login', 'Login::index');
    $subroutes->add('login/do_login', 'Login::do_login');
	
});
$routes->get('login/do_logout', 'Login::do_logout');