<?php

// create $routes associative array to map url to controller
// $routes = [
//   '/themobilehour/' => 'App/Controllers/HomeController.php',
//   '/themobilehour/home' => 'App/Controllers/HomeController.php',
//   '/themobilehour/products' => 'App/Controllers/ProductsController.php',
//   '/themobilehour/categories' => 'App/Controllers/CategoriesController.php',
//   '404' => 'App/Controllers/ErrorController.php'
// ];

// return $routes;


// ------------------------------------------//


// $router->get('/themobilehour/', 'Controllers/HomeController.php');
// $router->get('/themobilehour/home', 'Controllers/HomeController.php');
// $router->get('/themobilehour/products', 'Controllers/ProductsController.php');
// $router->get('/themobilehour/product', 'Controllers/ProductShowController.php');

// ------------------------------------------//

$router->get('/themobilehour/', 'HomeController@index');
$router->get('/themobilehour/home', 'HomeController@index');
$router->get('/themobilehour/products', 'ProductsController@index');
$router->get('/themobilehour/products/{id}', 'ProductsController@show');

$router->get('/themobilehour/admin/dashboard', 'Admin\DashboardController@index', ['authAdmin']);

$router->get('/themobilehour/admin/product-management', 'Admin\ProductManagementController@index', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/create', 'Admin\ProductManagementController@create', ['authAdmin']);
$router->post('/themobilehour/admin/product-management', 'Admin\ProductManagementController@store', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/edit/{id}', 'Admin\ProductManagementController@edit', ['authAdmin']);
$router->post('/themobilehour/admin/product-management/update/{id}', 'Admin\ProductManagementController@update', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/delete/{id}', 'Admin\ProductManagementController@delete', ['authAdmin']);
$router->post('/themobilehour/admin/product-management/destroy/{id}', 'Admin\ProductManagementController@destroy', ['authAdmin']);

$router->get('/themobilehour/admin/user-management', 'Admin\UserManagementController@index', ['authSuperAdmin']);
$router->get('/themobilehour/admin/user-management/create', 'Admin\UserManagementController@create', ['authSuperAdmin']);
$router->post('/themobilehour/admin/user-management', 'Admin\UserManagementController@store', ['authSuperAdmin']);
$router->get('/themobilehour/admin/user-management/edit/{id}', 'Admin\UserManagementController@edit', ['authSuperAdmin']);
$router->get('/themobilehour/admin/user-management/update/{id}', 'Admin\UserManagementController@update', ['authSuperAdmin']);

$router->get('/themobilehour/admin/auth/login', 'Admin\UserManagementController@login', ['guest']);
$router->post('/themobilehour/admin/auth/login', 'Admin\UserManagementController@authenticate', ['guest']);
$router->post('/themobilehour/admin/auth/logout', 'Admin\UserManagementController@logout', ['authAdmin']);

$router->get('/themobilehour/admin/changelogs', 'Admin\ChangelogsController@index', ['authAdmin']);
