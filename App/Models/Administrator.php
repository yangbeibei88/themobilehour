<?php

namespace App\Models;

use Framework\Database;

class Administrator
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }

  public function getAllUsers()
  {
    $adminUsers = $this->db->query("SELECT * FROM administrator")->fetchAll();
    return $adminUsers;
  }
}
