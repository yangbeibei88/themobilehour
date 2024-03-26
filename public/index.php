<?php
echo '__DIR__: ' . __DIR__;
require '../functions.php';
require basePath('App/Database.php');
$config = require basePath('config/config.php');

$db = new Database($config);


echo '<br>';
echo 'basePath(): ' . basePath();
echo '<br>';
echo 'DIRECTORY_SEPARATOR: ' . DIRECTORY_SEPARATOR;
echo '<br>';
echo 'DOCUMENT_ROOT: ' . $_SERVER['DOCUMENT_ROOT'];
echo '<br>';
echo '__DIR__: ' . __FILE__;
echo '<br>';
echo substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
echo '<br>';
// echo getParentFolder();
echo 'actual URI: ' . $_SERVER['REQUEST_URI'];
echo '<br>';
// echo 'PHP_URL_PATH' . PHP_URL_PATH;
echo '<br>';
echo 'parse_url: ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo '<br>';
echo 'removed subfolder name URI: ' . getURI($_SERVER['REQUEST_URI']);
echo '<br>';


// require '../config/config.php';
// require basePath('App/Views/Home/index.php');


// loadView('Home/index');
// require '../App/Views/Home/index.php';

// create $routes associative array to map url to controller
// $routes = [
//   '/' => 'App/Controllers/HomeController.php',
//   '/products' => 'App/Controllers/ProductsController.php',
//   '/categories' => 'App/Controllers/CategoriesController.php',
//   '404' => 'App/Controllers/ErrorController.php'
// ];

// $uri = getURI($_SERVER['REQUEST_URI']);


require basePath('Router.php');

$router = new Router();

$routes = require basePath('routes.php');

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// inspectAndDie($uri);
inspect($uri);
inspect($method);

$router->route($uri, $method);

// if uri exists in routes, then...
// if (array_key_exists($uri, $routes)) {
//   require basePath($routes[$uri]);
// } else {
//   require basePath($routes['404']);
// }
