<?php

/*---------------------------------public uri routes--------------------------*/

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/products', 'ProductsController@index');
$router->get('/categories', 'CategoriesController@index');
$router->get('/products/search', 'ProductsController@search');
$router->get('/products/filter', 'ProductsController@filter');
$router->get('/products/{id}', 'ProductsController@show');
$router->get('/categories/{id}', 'CategoriesController@show');
$router->get('/categories/filter/{id}', 'CategoriesController@filter');

/*-------------------------------------admin dashboard route-----------------------------*/
$router->get('/admin/dashboard', 'Admin\DashboardController@index', ['authAdmin']);

/*------------------------------Admin Product Management Routes------------------------------------------*/
$router->get('/admin/product-management', 'Admin\ProductManagementController@index', ['authAdmin']);
$router->get('/admin/product-management/search', 'Admin\ProductManagementController@search', ['authAdmin']);
$router->get('/admin/product-management/create', 'Admin\ProductManagementController@create', ['authAdmin']);
$router->post('/admin/product-management', 'Admin\ProductManagementController@store', ['authAdmin']);
$router->get('/admin/product-management/show/{id}', 'Admin\ProductManagementController@show', ['authAdmin']);
$router->get('/admin/product-management/edit/{id}', 'Admin\ProductManagementController@edit', ['authAdmin']);
$router->post('/admin/product-management/update/{id}', 'Admin\ProductManagementController@update', ['authAdmin']);
$router->get('/admin/product-management/delete/{id}', 'Admin\ProductManagementController@delete', ['authAdmin']);
$router->post('/admin/product-management/destroy/{id}', 'Admin\ProductManagementController@destroy', ['authAdmin']);

/*------------------------------Admin Category Management Routes------------------------------------------*/

$router->get('/admin/category-management', 'Admin\CategoryManagementController@index', ['authAdmin']);
$router->get('/admin/category-management/show/{id}', 'Admin\CategoryManagementController@show', ['authAdmin']);
$router->get('/admin/category-management/create', 'Admin\CategoryManagementController@create', ['authAdmin']);
$router->post('/admin/category-management', 'Admin\CategoryManagementController@store', ['authAdmin']);
$router->get('/admin/category-management/edit/{id}', 'Admin\CategoryManagementController@edit', ['authAdmin']);
$router->post('/admin/category-management/update/{id}', 'Admin\CategoryManagementController@update', ['authAdmin']);
$router->get('/admin/category-management/delete/{id}', 'Admin\CategoryManagementController@delete', ['authAdmin']);
$router->post('/admin/category-management/destroy/{id}', 'Admin\CategoryManagementController@destroy', ['authAdmin']);

/*---------------------------Admin Management User Management Routes------------------------------------------*/
$router->get('/admin/user-management', 'Admin\UserManagementController@index', ['authSuperAdmin']);
$router->get('/admin/user-management/create', 'Admin\UserManagementController@create', ['authSuperAdmin']);
$router->post('/admin/user-management', 'Admin\UserManagementController@store', ['authSuperAdmin']);
$router->get('/admin/user-management/edit/{id}', 'Admin\UserManagementController@edit', ['authSuperAdmin']);
$router->post('/admin/user-management/update/{id}', 'Admin\UserManagementController@update', ['authSuperAdmin']);

/*---------------------------Admin changelog routes------------------------------------------*/
$router->get('/admin/changelogs', 'Admin\ChangelogsController@index', ['authAdmin']);
$router->get('/admin/changelogs/filter', 'Admin\ChangelogsController@filter', ['authAdmin']);

/*---------------------------Admin account routes------------------------------------------*/
$router->get('/admin/auth/login', 'Admin\AccountController@login', ['guest']);
$router->post('/admin/auth/login', 'Admin\AccountController@authenticate', ['guest']);
$router->post('/admin/auth/logout', 'Admin\AccountController@logout', ['authAdmin']);
$router->get('/admin/auth/account/show/{id}', 'Admin\AccountController@show', ['authAdmin']);
$router->get('/admin/auth/account/edit/{id}', 'Admin\AccountController@edit', ['authAdmin']);
$router->post('/admin/auth/account/update/{id}', 'Admin\AccountController@update', ['authAdmin']);
