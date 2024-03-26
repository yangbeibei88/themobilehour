<?php

/**
 * Get the base path
 *
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
  return __DIR__ . '/' . $path;
}

// function getParentFolder()
// {
//   return substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
// }

/**
 * remove subfolder's name from URI
 *
 * @param string $uri
 * @return void
 */
function getURI($uri)
{
  $curDir = '/' . basename(dirname(__FILE__));
  return substr($uri, strlen($curDir));
}


/**
 * Load a view
 *
 * @param string $name
 * @return void
 */
function loadView($name)
{
  $viewPath = basePath("App/Views/{$name}.php");

  inspect($viewPath);

  if (file_exists($viewPath)) {
    require $viewPath;
  } else {
    echo "View '{$name}' not found!";
  }
}

/**
 * Load a partial
 *
 * @param string $name
 * @return void
 */
function loadPartial($name)
{
  $partialPath = basePath("App/Views/partials/{$name}.php");
  if (file_exists($partialPath)) {
    require $partialPath;
  } else {
    echo "Partial '{$name}' not found!";
  }
}

/**
 * Inspect a value(s)
 * 
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}

/**
 * Inspect a value(s) & die
 * 
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
  echo '<pre>';
  die(var_dump($value));
  echo '</pre>';
}
