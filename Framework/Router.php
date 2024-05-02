<?php

namespace Framework;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

// require basePath('routes.php');
// inspect($routes);
// // if uri exists in routes, then...
// if (array_key_exists($uri, $routes)) {
//   require basePath($routes[$uri]);
// } else {
//   http_response_code(404);
//   require basePath($routes['404']);
// }


class Router
{
  protected $routes = [];

  /**
   * Add a new route
   *
   * @param string $method http method
   * @param string $uri
   * @param string $controllerAndAction
   * @param array $middleware
   * @return void
   */
  public function registerRoute($method, $uri, $controllerAndAction, $middleware = [])
  {
    // destructure to $controller and $action
    list($controller, $action) = explode('@', $controllerAndAction);
    // inspectAndDie($action);
    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller,
      'action' => $action,
      'middleware' => $middleware
    ];
  }

  /**
   * Add a GET route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function get($uri, $controller, $middleware = [])
  {
    $this->registerRoute('GET', $uri, $controller, $middleware);
  }
  /**
   * Add a POST route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function post($uri, $controller, $middleware = [])
  {
    $this->registerRoute('POST', $uri, $controller, $middleware);
  }
  /**
   * Add a PUT route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function put($uri, $controller, $middleware = [])
  {
    $this->registerRoute('PUT', $uri, $controller, $middleware);
  }
  /**
   * Add a DELETE route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function delete($uri, $controller, $middleware = [])
  {
    $this->registerRoute('DELETE', $uri, $controller, $middleware);
  }

  // public function error($httpCode = 404)
  // {
  //   http_response_code($httpCode);
  //   loadView("error");
  //   exit;
  // }

  /**
   * Route the request
   * $uri and $method parsed in this function are actual url and http method called in public/index.php
   * This function also handles errors
   * 
   * @param string $uri
   * @param string $method http method
   * @return void
   */
  public function route()
  {

    $uri = $this->normalizedURIPath();
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // inspect($uri);


    foreach ($this->routes as $route) {

      // split the route URI into segments
      $routeSegments = explode('/', trim($route['uri'], '/'));
      // split the current URI into segments
      $uriSegments = explode('/', $uri);

      // inspect($routeSegments);

      // check if actual uri and route uri match, set initial value to true
      $match = true;

      // first check if the number of segments matches
      if (count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {
        $params = [];

        for ($i = 0; $i < count($uriSegments); $i++) {
          // if actual uri segment part not match router uri segment part, and there is no pram
          if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
            $match = false;
            break;
          }

          // check for the pram and add to $params array
          if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
            // inspectAndDie($matches); // $matches[0] == {id}, $matches[1] == id
            // inspectAndDie($uriSegments[$i]);
            $params[$matches[1]] = $uriSegments[$i];
            // inspectAndDie($params);
          }
        }

        if ($match) {
          foreach ($route['middleware'] as $role) {
            (new Authorize())->handle($role);
          }

          // Extract controller and controller method
          $controller = 'App\\Controllers\\' . $route['controller'];
          $action = $route['action'];

          // instantiate the controller and call the method
          $controllerInstance = new $controller();
          $controllerInstance->$action($params);

          // inspect($controller);
          // inspect($action);

          return;
        }
      }
    }

    if (in_array('admin', $uriSegments)) {
      AdminErrorController::notFound();
    } else {
      ErrorController::notFound();
    }
  }


  private function normalizedURIPath()
  {
    // $requestUri = $_SERVER['REQUEST_URI'];

    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $scriptName = $_SERVER['SCRIPT_NAME'];

    // // Normalize the request URI by removing the script name or its directory
    // $appBasePath = dirname($scriptName);

    // Calculate the base path dynamically: Remove the script's filename and then strip it from the request URI
    $appBasePath = str_replace('/public/index.php', '', $scriptName); // removes the trailing '/public/index.php'

    if (strpos($requestUri, $appBasePath) === 0) {
      $path = substr($requestUri, strlen($appBasePath));
    } else {
      $path = $requestUri; // Fallback if something unexpected occurs
    }


    $path = trim($path, '/');
    return $path;
  }
}
