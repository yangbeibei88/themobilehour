<?php

namespace Framework;

class Validation
{

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
}
