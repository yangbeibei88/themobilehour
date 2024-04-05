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

  public function getInsertID()
  {
    $conn = $this->db->conn;
    return $conn->lastInsertId();
  }

  public function insert($fields, $values, $params)
  {

    $query = "INSERT INTO feature({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
    // $this->db->query($query, );
  }
}
