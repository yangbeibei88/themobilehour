<?php

namespace App\Controllers\Admin;

use Framework\Session;

class DashboardController
{
  public function index()
  {
    // inspect(Session::get('adminUser'));
    loadView('Admin/Dashboard/index');
  }
}
