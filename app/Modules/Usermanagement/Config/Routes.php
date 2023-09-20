<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('usermanagement', ['namespace' => 'App\Modules\Usermanagement\Controllers', 'filter' => 'AuthFilter'], function($subroutes){


	/*** Route for Login ***/
	$subroutes->add('/', 'Usermanagement::index');
	$subroutes->add('profile/(:any)', 'Usermanagement::profile/$1');
	$subroutes->add('add', 'Usermanagement::add');
	$subroutes->add('do_add', 'Usermanagement::do_add');
	$subroutes->add('edit/(:any)', 'Usermanagement::edit/$1');
	$subroutes->add('do_edit', 'Usermanagement::do_edit');
	$subroutes->add('delete/(:any)', 'Usermanagement::delete/$1');

});