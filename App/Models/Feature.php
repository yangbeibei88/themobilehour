<?php

namespace App\Models;

use Framework\Database;

class Feature
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }
}
