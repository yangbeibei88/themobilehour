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
}
