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

/*---------------------------------public uri routes--------------------------*/
$router->get('/themobilehour/', 'HomeController@index');
$router->get('/themobilehour/home', 'HomeController@index');
$router->get('/themobilehour/products', 'ProductsController@index');
$router->get('/themobilehour/products/search', 'ProductsController@search');
$router->get('/themobilehour/products/filter', 'ProductsController@filter');
$router->get('/themobilehour/products/{id}', 'ProductsController@show');

/*-------------------------------------admin dashboard route-----------------------------*/
$router->get('/themobilehour/admin/dashboard', 'Admin\DashboardController@index', ['authAdmin']);

/*------------------------------Admin Product Management Routes------------------------------------------*/
$router->get('/themobilehour/admin/product-management', 'Admin\ProductManagementController@index', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/search', 'Admin\ProductManagementController@search', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/create', 'Admin\ProductManagementController@create', ['authAdmin']);
$router->post('/themobilehour/admin/product-management', 'Admin\ProductManagementController@store', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/show/{id}', 'Admin\ProductManagementController@show', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/edit/{id}', 'Admin\ProductManagementController@edit', ['authAdmin']);
$router->post('/themobilehour/admin/product-management/update/{id}', 'Admin\ProductManagementController@update', ['authAdmin']);
$router->get('/themobilehour/admin/product-management/delete/{id}', 'Admin\ProductManagementController@delete', ['authAdmin']);
$router->post('/themobilehour/admin/product-management/destroy/{id}', 'Admin\ProductManagementController@destroy', ['authAdmin']);

/*------------------------------Admin Category Management Routes------------------------------------------*/

$router->get('/themobilehour/admin/category-management', 'Admin\CategoryManagementController@index', ['authAdmin']);
$router->get('/themobilehour/admin/category-management/show/{id}', 'Admin\CategoryManagementController@show', ['authAdmin']);
$router->get('/themobilehour/admin/category-management/create', 'Admin\CategoryManagementController@create', ['authAdmin']);
$router->post('/themobilehour/admin/category-management', 'Admin\CategoryManagementController@store', ['authAdmin']);
$router->get('/themobilehour/admin/category-management/edit/{id}', 'Admin\CategoryManagementController@edit', ['authAdmin']);
$router->post('/themobilehour/admin/category-management/update/{id}', 'Admin\CategoryManagementController@update', ['authAdmin']);
$router->get('/themobilehour/admin/category-management/delete/{id}', 'Admin\CategoryManagementController@delete', ['authAdmin']);
$router->post('/themobilehour/admin/category-management/destroy/{id}', 'Admin\CategoryManagementController@destroy', ['authAdmin']);

/*---------------------------Admin Management User Management Routes------------------------------------------*/
$router->get('/themobilehour/admin/user-management', 'Admin\UserManagementController@index', ['authSuperAdmin']);
$router->get('/themobilehour/admin/user-management/create', 'Admin\UserManagementController@create', ['authSuperAdmin']);
$router->post('/themobilehour/admin/user-management', 'Admin\UserManagementController@store', ['authSuperAdmin']);
$router->get('/themobilehour/admin/user-management/edit/{id}', 'Admin\UserManagementController@edit', ['authSuperAdmin']);
$router->post('/themobilehour/admin/user-management/update/{id}', 'Admin\UserManagementController@update', ['authSuperAdmin']);

/*---------------------------Admin changelog routes------------------------------------------*/
$router->get('/themobilehour/admin/changelogs', 'Admin\ChangelogsController@index', ['authAdmin']);

/*---------------------------Admin account routes------------------------------------------*/
$router->get('/themobilehour/admin/auth/login', 'Admin\AccountController@login', ['guest']);
// $router->get('/themobilehour/admin/auth/login', 'Admin\UserManagementController@login', ['guest']);
// $router->post('/themobilehour/admin/auth/login', 'Admin\UserManagementController@authenticate', ['guest']);
// $router->post('/themobilehour/admin/auth/logout', 'Admin\UserManagementController@logout', ['authAdmin']);


$router->post('/themobilehour/admin/auth/login', 'Admin\AccountController@authenticate', ['guest']);
$router->post('/themobilehour/admin/auth/logout', 'Admin\AccountController@logout', ['authAdmin']);
$router->get('/themobilehour/admin/auth/account/show/{id}', 'Admin\AccountController@show', ['authAdmin']);
$router->get('/themobilehour/admin/auth/account/edit/{id}', 'Admin\AccountController@edit', ['authAdmin']);
$router->post('/themobilehour/admin/auth/account/update/{id}', 'Admin\AccountController@update', ['authAdmin']);
