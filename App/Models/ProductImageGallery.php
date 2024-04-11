<?php

namespace App\Models;

use Framework\Database;

class ProductImageGallery
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

    $query = "INSERT INTO product_image_gallery({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
  }

  public function update($fields, $params)
  {
    $query = "UPDATE product_image_gallery SET {$fields} WHERE image_gallery_id = :id";
    $this->db->query($query, $params);
  }
}
