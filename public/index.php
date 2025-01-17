<?php

// session_start();
require __DIR__ . '/../vendor/autoload.php';
// echo '__DIR__: ' . __DIR__;
// echo '<br>';
// echo 'dirname(__DIR__,1): ' . dirname(__DIR__, 1);


use Framework\Router;
use Framework\Session;

Session::start();

require '../functions.php';

// inspectAndDie(session_status());
/**
 * session_status():
 * _DISABLED = 0
 * _NONE = 1
 * _ACTIVE = 2
 */

// require basePath('Framework/Router.php');
// require basePath('Framework/Database.php');


// spl_autoload_register(function ($className) {
//   $path = basePath('Framework/' . $className . '.php');
//   if (file_exists($path)) {
//     require $path;
//   }
// });

// $now = date("Y-m-d H:i:s");
// echo '<br>';
// echo getDateTime();
// echo '<br>';
// echo 'basePath(): ' . basePath();
// echo '<br>';
// echo 'DIRECTORY_SEPARATOR: ' . DIRECTORY_SEPARATOR;
// echo '<br>';
// echo 'DOCUMENT_ROOT: ' . $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo '__DIR__: ' . __DIR__;
// echo '<br>';
// echo '__FILE__' . __FILE__;
// echo '<br>';
// echo substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
// echo '<br>';
// echo substr(dirname(__DIR__), strlen($_SERVER['DOCUMENT_ROOT']));
// echo '<br>';
// echo 'actual URI: ' . $_SERVER['REQUEST_URI'];
// echo '<br>';
// echo 'parse_url: ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// echo '<br>';
// echo 'removed subfolder name URI: ' . getURI($_SERVER['REQUEST_URI']);
// echo '<br>';

// echo 'image_uploads_folder: ' . IMAGE_UPLOADS;
// echo '<br>';
// echo 'image_path_db: ' . assetPath(IMAGE_UPLOADS);
// echo '<br>';
// echo 'documents_uploads_folder: ' . DOCUMENT_UPLOADS;
// echo '<br>';
// echo 'avatars_uploads_folder: ' . AVATAR_UPLOADS;
// echo '<br>';
// inspectAndDie(Session::get('adminUser')['id']);

// inspect('appBasePath: ' . appBasePath());
// inspect(strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']));
// inspect('normalizedURIPath: ' . normalizedURIPath());


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



// instatiating the router
$router = new Router();

// get routes
$routes = require basePath('routes.php');

/*----------------get current URI and HTTP method start-------------*/
// get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
/*----------------get current URI and HTTP method end-------------*/

// move $method to Router, 
// $method = $_SERVER['REQUEST_METHOD'];


// inspect($uri);
// inspect($method);

// Route the request
// $router->route($uri, $method);
// $router->route($uri);
$router->route();

// if uri exists in routes, then...
// if (array_key_exists($uri, $routes)) {
//   require basePath($routes[$uri]);
// } else {
//   require basePath($routes['404']);
// }
