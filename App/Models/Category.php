<?php

namespace App\Models;

use Framework\Database;

class Category
{

  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }

  public function getAllCategories()
  {
    $categories = $this->db->query('SELECT * FROM category')->fetchAll();

    return $categories;
  }
}
