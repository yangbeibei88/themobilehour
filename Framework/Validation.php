<?php

namespace Framework;

class Validation
{

  /**
   * validate a required field
   *
   * @param string $field
   * @return void
   */
  public static function required($fieldValue)
  {
    return empty($fieldValue) ? "$fieldValue is required" : true;
  }

  /**
   * Validate a string
   *
   * @param string $string
   * @param integer $min
   * @param integer $max
   * @return boolean
   */
  public static function isString(string $string, int $min = 0, int $max = 1000): bool
  {
    if (is_string($string)) {
      $string = trim($string);
      $length = strlen($string);
      return $length >= $min && $length <= $max;
    }
    return false;
  }

  /**
   * Validate a string
   *
   * @param string $name field name
   * @param string $value field value
   * @param integer $min field value min length
   * @param integer $max field value max length
   * @param boolean $required
   * @return void return error text message if invalid, return null if valid
   */
  public static function text(string $name, string $value, int $min = 0, int $max = 1000, bool $required = TRUE)
  {
    if ($required && empty($value)) {
      return "{$name} is required";
    } elseif (strlen($value) < $min && !empty($value)) {
      return "{$name} is too short, should be more than $min characters.";
    } elseif (strlen($value) > $max) {
      return "{$name} is too long, should not exceed $max characters.";
    }
  }

  /**
   * Validate a number
   *
   * @param mixed $number
   * @param integer $min
   * @param integer $max
   * @return boolean
   */
  public static function isNumber($number, $min = 0, $max = 100): bool
  {
    if (is_numeric($number)) {
      $number = trim($number);
      $length = strlen($number);
      return $length >= $min && $length <= $max;
    }
    return false;
  }

  /**
   * Validate an email, return valid email if true, false otherwise
   *
   * @param mixed $email
   * @return boolean
   */
  public static function isEmail($email)
  {
    $email = trim($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Validate an password, the password must be at least 8 chars, contains uppercase(s), lowercase(s), number(s) and special chars
   *
   * @param string $password
   * @return boolean
   */
  public static function isPassword($password)
  {
    if (
      strlen($password) >= 8                     // Length 8 or more chars
      and preg_match('/[A-Z]/', $password)       // Contains uppercase A-Z
      and preg_match('/[a-z]/', $password)       // Contains lowercase a-z
      and preg_match('/[0-9]/', $password)       // Contains 0-9
      and preg_match('/[\W_]/', $password)       // Contains special char(s)
    ) {
      return true;                               // Passed all tests
    }
    return false;                                  // Invalid password
  }


  /**
   * Match a value against another, 
   * use this function to compare if re-entered password match password
   *
   * @param string $val1
   * @param string $val2
   * @return boolean
   */
  public static function isMatch($val1, $val2): bool
  {
    return strcmp($val1, $val2) === 0 ? true : false;
  }

  /**
   * Validate an image and return error message
   *
   * @param array $file
   * @return void
   */
  public static function validateImage($file)
  {

    // If file bigger than limit in php.ini
    if ($file['error'] === 1) {
      return "{$file['name']} is too big";
    }

    if ($file['tmp_name'] && $file['error'] === 0) {
      // convert file extension to lowercase
      $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      switch (true) {
          // validate file type
        case !in_array(mime_content_type($file['tmp_name']), IMAGE_TYPES):
          return "{$file['name']} is a wrong file type.";
          break;
          // validate file extension
        case !in_array($extension, IMAGE_EXTENSIONS):
          return "{$file['name']} has a wrong file extension.";
          break;
          // validate file size
        case $file['size'] > IMAGE_MAX_SIZE:
          return "{$file['name']} is too big.";
          break;
      }
    }

    // return true;
  }
}
