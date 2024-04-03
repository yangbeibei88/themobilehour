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

$router->get('/themobilehour/admin/product-management/index', 'Admin\ProductManagementController@index');
$router->get('/themobilehour/admin/product-management/create', 'Admin\ProductManagementController@create');
$router->get('/themobilehour/admin/product-management/edit', 'Admin\ProductManagementController@edit');
$router->get('/themobilehour/admin/product-management/update', 'Admin\ProductManagementController@update');
$router->get('/themobilehour/admin/product-management/delete', 'Admin\ProductManagementController@delete');
