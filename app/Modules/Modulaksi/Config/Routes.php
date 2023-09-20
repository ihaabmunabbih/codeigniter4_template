<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('aksimodul', ['namespace' => 'App\Modules\Modulaksi\Controllers', 'filter' => 'AuthFilter'], function($subroutes){


	/*** Route for Login ***/
	$subroutes->add('/', 'Modulaksi::index');
	$subroutes->add('add', 'Modulaksi::add');
	$subroutes->add('do_add', 'Modulaksi::do_add');
	$subroutes->add('edit/(:any)', 'Modulaksi::edit/$1');
	$subroutes->add('do_edit', 'Modulaksi::do_edit');
	$subroutes->add('delete/(:any)', 'Modulaksi::delete/$1');

});