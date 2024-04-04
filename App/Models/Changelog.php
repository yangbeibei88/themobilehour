<?php

namespace App\Models;

use Framework\Database;

class Changelog
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }

  public function getAllChangelogs()
  {
    $changelogs = $this->db->query("SELECT c.*, p.sku, a1.firstname AS created_by, a2.firstname AS modified_by FROM changelog c
    INNER JOIN product p ON c.product_id = p.product_id
    INNER JOIN administrator a1 ON c.user_id = a1.user_id
    INNER JOIN administrator a2 ON c.user_id_modifiedby = a2.user_id")->fetchAll();

    return $changelogs;
  }
}
