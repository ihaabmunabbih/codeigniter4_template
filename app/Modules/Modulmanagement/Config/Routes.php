<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('managementmodul', ['namespace' => 'App\Modules\Modulmanagement\Controllers', 'filter' => 'AuthFilter'], function($subroutes){


	/*** Route for Login ***/
	$subroutes->add('/', 'Modulmanagement::index');
	$subroutes->add('add', 'Modulmanagement::add');
	$subroutes->add('do_add', 'Modulmanagement::do_add');
	$subroutes->add('edit', 'Modulmanagement::edit');
	$subroutes->add('do_edit', 'Modulmanagement::do_edit');
	$subroutes->add('delete', 'Modulmanagement::delete');

});