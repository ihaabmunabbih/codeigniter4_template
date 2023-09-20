<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('groupmanagement', ['namespace' => 'App\Modules\Groupmanagement\Controllers', 'filter' => 'AuthFilter'], function($subroutes){


	/*** Route for Login ***/
	$subroutes->add('/', 'Groupmanagement::index');
	$subroutes->add('add', 'Groupmanagement::add');
	$subroutes->add('do_add', 'Groupmanagement::do_add');
	$subroutes->add('edit/(:any)', 'Groupmanagement::edit/$1');
	$subroutes->add('do_edit', 'Groupmanagement::do_edit');
	$subroutes->add('delete/(:any)', 'Groupmanagement::delete/$1');

});