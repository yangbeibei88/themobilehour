<?php
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

  public function registerRoute($method, $uri, $controller)
  {
    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller
    ];
  }

  /**
   * Add a GET route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function get($uri, $controller)
  {
    $this->registerRoute('GET', $uri, $controller);
  }
  /**
   * Add a POST route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function post($uri, $controller)
  {
    $this->registerRoute('POST', $uri, $controller);
  }
  /**
   * Add a PUT route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function put($uri, $controller)
  {
    $this->registerRoute('PUT', $uri, $controller);
  }
  /**
   * Add a DELETE route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function delete($uri, $controller)
  {
    $this->registerRoute('DELETE', $uri, $controller);
  }

  public function error($httpCode = 404)
  {
    http_response_code($httpCode);
    loadView("error");
    exit;
  }

  /**
   * Route the request
   * $uri and $method parsed in this function are actual $uri and $methods called in public/index.php
   * This function also handles errors
   * 
   * @param string $uri
   * @param string $method
   * @return void
   */
  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $method) {
        require basePath($route['controller']);
        return;
      }
    }

    $this->error();
  }
}
