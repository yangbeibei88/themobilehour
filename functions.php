<?php

/**
 * Define timezone to 'Australia/Brisbane';
 */
date_default_timezone_set('Australia/Brisbane');

/**
 * Define image upload setting
 */
define('IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']); // Allowed file types
define('IMAGE_EXTENSIONS', ['jpeg', 'jpg', 'png', 'gif']);       // Allowed file extensions
define('IMAGE_MAX_SIZE', '5000000');                                    // Max file size

/**
 * Define upload path
 */
define('IMAGE_UPLOADS', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);
define('DOCUMENT_UPLOADS', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR);
define('AVATAR_UPLOADS', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR);
// inspect(substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
// inspect('urlPath: ' . urlPath('admin/product-management'));

// echo '<br>';
// echo 'image_uploads_folder: ' . IMAGE_UPLOADS;
// echo '<br>';
// echo 'documents_uploads_folder: ' . DOCUMENT_UPLOADS;
// echo '<br>';
// echo 'avatars_uploads_folder: ' . AVATAR_UPLOADS;

/**
 * Get formatted current date time
 */

function getDateTime()
{
  return date("Y-m-d H:i:s");
}

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


function assetPath($path)
{
  $docRoot = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
  return $docRoot . DIRECTORY_SEPARATOR . $path;
}

function appBasePath()
{
  $appBasePath = dirname($_SERVER['SCRIPT_NAME']);

  return $appBasePath;
}

function urlPath($path)
{
  return str_replace('\\', '/', assetPath($path));
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

  // inspect($viewPath);

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
function loadPartial($name, $data = [])
{
  $partialPath = basePath("App/Views/partials/{$name}.php");
  if (file_exists($partialPath)) {
    extract($data);
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

/**
 * Redirect to a given url
 * 
 * @param string $url
 * @return void
 */
function redirect($url)
{
  header("Location: {$url}");
  exit;
}

/**
 * Exclude sanitising some values, and return a new array
 *
 * @param array $arr
 * @param array $excludeKeys
 * @return array
 */
function sanitizeArr($arr, $excludeKeys = [])
{
  $sanitizedArr = [];
  foreach ($arr as $key => $value) {
    if (in_array($key, $excludeKeys)) {
      $sanitizedArr[$key] = $value;
    } else {
      $sanitizedArr[$key] = sanitize($value);
    }
  }
  return $sanitizedArr;
}

/**
 * Create file name
 *
 * @param string $filename
 * @param string $upload_path
 * @return string
 */
function createFileName($filename, $upload_path)
{
  $basename = pathinfo($filename, PATHINFO_FILENAME); // get filename without extension
  $extension = pathinfo($filename, PATHINFO_EXTENSION); // get the file's extension
  $basename =  preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
  $filename = $basename . '.' . $extension;
  $i = 1;
  while (file_exists($upload_path . $filename)) {
    $i++;
    $filename = $basename . "-$i." . $extension;
  }
  return $filename;
}

function moveFile($file, $fileFieldName, $altFieldName, $altValue, &$data, $upload_path)
{
  if ($file['tmp_name']) {
    $moved = false;
    $filename = createFileName($file['name'], IMAGE_UPLOADS);
    $destination = IMAGE_UPLOADS . $filename;
    $moved = move_uploaded_file($file['tmp_name'], $destination);

    if ($moved === true) {
      // if the file is successfully moved to upload_path, assign file field value and file alt text to corresponding data field
      $data[$fileFieldName] = $upload_path . $filename;
      $data[$altFieldName] = sanitize($altValue);
    }
  }
}

/**
 * trim and lowercase a string
 *
 * @param string $value
 * @return string
 */
function trimAndLowerCase($value)
{
  return strtolower(trim($value));
}

/**
 * trim and lowercase a string
 *
 * @param string $value
 * @return string
 */
function trimAndUpperCase($value)
{
  return strtoupper(trim($value));
}

/**
 * trim and capitalise first letter of each word
 *
 * @param string $value
 * @return string
 */
function trimAndUcWords($value)
{
  return ucwords(trim($value));
}

function trimAndConvertNumericValues($array)
{
  foreach ($array as $key => $value) {
    if ($value === null) {
      // Keep null values as they are
      $array[$key] = null;
    } elseif (is_numeric($value)) {
      // Convert numeric strings to numbers
      $array[$key] = $value + 0;
    } else {
      $array[$key] = trim($value);
      // // Trim the value if it's not numeric and not null
      // $trimmedValue = trim($value);
      // // Convert empty strings to null after trimming
      // $array[$key] = $trimmedValue === '' ? null : $trimmedValue;
    }
  }
  return $array;
}
