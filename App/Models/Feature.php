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

  public function getSingleFeature($params)
  {
    $feature = $this->db->query("SELECT * FROM feature WHERE feature_id = :id", $params)->fetch();
    return $feature;
  }

  public function insert($fields, $values, $params)
  {

    $query = "INSERT INTO feature({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
    // $this->db->query($query, );
  }

  public function update($fields, $params)
  {
    $query = "UPDATE feature SET {$fields} WHERE feature_id = :id";
    $this->db->query($query, $params);
  }
}
