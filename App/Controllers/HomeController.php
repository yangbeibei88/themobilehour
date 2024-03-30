<?php

namespace App\Controllers;

class HomeController
{
  public function __construct()
  {
    // die('HomeController@index');
    loadView('Home/index');
  }
}
