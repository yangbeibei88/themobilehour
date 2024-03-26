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

$router->get('/themobilehour/', 'App/Controllers/HomeController.php');
$router->get('/themobilehour/home', 'App/Controllers/HomeController.php');
$router->get('/themobilehour/products', 'App/Controllers/ProductsController.php');
