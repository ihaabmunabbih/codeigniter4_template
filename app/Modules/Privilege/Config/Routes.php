<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('privilege', ['namespace' => 'App\Modules\Privilege\Controllers', 'filter' => 'AuthFilter'], function($subroutes){


	/*** Route for Login ***/
	$subroutes->add('/', 'Privilege::index');
	$subroutes->add('add', 'Privilege::add');
	$subroutes->add('do_action', 'Privilege::do_action');
	$subroutes->add('do_add', 'Privilege::do_add');
	$subroutes->add('edit', 'Privilege::edit');
	$subroutes->add('do_edit', 'Privilege::do_edit');
	$subroutes->add('delete', 'Privilege::delete');

});