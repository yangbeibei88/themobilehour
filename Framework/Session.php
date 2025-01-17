<?php

namespace Framework;

// set session's methods to static, no need to instantiate
class Session
{

  /**
   * Start a session
   *
   * @return void
   */
  public static function start()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Set a session key/value pair
   * 
   * @param string $key
   * @param mixed $value
   * @return void
   */

  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  /**
   * Get a session value by the key
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
  public static function get($key, $default = null)
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
  }

  /**
   * check if session key exists
   * 
   * @param string $key
   * @return  bool
   */
  public static function has($key)
  {
    return isset($_SESSION[$key]);
  }

  /**
   * clear session by value
   * 
   * @param string $key
   * @return void
   */
  public static function clear($key)
  {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }

  /**
   * clear all session data
   * 
   * @return void
   */
  public static function clearAll()
  {
    // Empty $_SESSION superglobal, equal to $_SESSION = []
    session_unset();
    // Destroy the session data on the server
    session_destroy();
    // Get session cookie parameters
    $params = session_get_cookie_params();
    // Clear the session cookie from the browser by setting its expiration to one day (60*60*24=86400) ago
    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
  }

  /**
   * Set a flash message
   * 
   * @param string $key
   * @param string $message
   * @return void
   */
  public static function setFlashMessage($key, $message)
  {
    self::set('flash_' . $key, $message);
  }

  /**
   * get a flash message and unset
   * 
   * @param string $key
   * @param mixed $default
   * @return string
   */
  public static function getFlashMessage($key, $default = null)
  {
    $message = self::get('flash_' . $key, $default);
    self::clear('flash_' . $key);
    return $message;
  }
}
