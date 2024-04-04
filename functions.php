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
  // return __DIR__ . DIRECTORY_SEPARATOR . $path;
}

// function getParentFolder()
// {
//   return substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
// }

function assetPath($path)
{
  $docRoot = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
  return $docRoot . DIRECTORY_SEPARATOR . $path;
}

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
 * $data array comes from pdo
 *
 * @param string $name
 * @param array $data
 * @return void
 */
function loadView($name, $data = [])
{
  $viewPath = basePath("App/Views/{$name}.php");

  inspect($viewPath);

  if (file_exists($viewPath)) {
    extract($data);
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

/**
 * Format price, keep two decimals
 *
 * @param float $price
 * @return void
 */
function formatPrice($price)
{
  return '$' . number_format(floatval($price), 2);
}

/**
 * get sale price
 *
 * @param float $rrp
 * @param float $disc
 * @return void
 */
function getSalePrice($rrp, $disc)
{
  return '$' . number_format(floatval($rrp * (1 - $disc / 100)), 2);
}

/**
 * get discount amount
 *
 * @param float $rrp
 * @param float $disc
 * @return void
 */
function getDiscAmount($rrp, $disc)
{
  return '$' . number_format(floatval($rrp * $disc / 100), 0);
}

function getInteger($number)
{
  return number_format(floatval($number), 0);
}

/**
 * Sanitise Data
 * 
 * @param string $dirty
 * @return string
 */
function sanitize($dirty)
{
  return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}
