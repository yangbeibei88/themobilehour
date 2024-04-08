<?php

namespace App\Controllers\Admin;

class DashboardController
{
  public function index()
  {
    loadView('Admin/Dashboard/index');
  }
}
