<?php

namespace Framework;

use Framework\Session;

class Authorization
{
  public static function isAdminManager($role)
  {
    $role = Session::get('adminUser')['role'];

    return $role === 'Super Admin' ? true : false;
  }
}
