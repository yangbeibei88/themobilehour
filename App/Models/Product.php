<?php

namespace App\Models;

use Framework\Database;

use PDO, Exception, PDOException;

class Product
{

  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }

  // public function getAllProducts()
  // {
  //   $products = $this->db->query("SELECT * FROM product")->fetchAll();

  //   return $products;
  // }

  public function getAllProducts()
  {
    $products = $this->db->query("SELECT * FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id")->fetchAll();

    return $products;
  }

  public function getSingleProduct($params)
  {
    $product = $this->db->query("SELECT * FROM product p 
                            LEFT JOIN feature f ON p.feature_id = f.feature_id  
                            LEFT JOIN category c ON p.category_id = c.category_id
                            LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
                            WHERE p.product_id = :id", $params)->fetch();

    return $product;
  }

  public function insert($fields, $values, $params)
  {
    $query = "INSERT INTO product({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
  }

  public function update($fields, $params)
  {
    $query = "UPDATE product SET {$fields} WHERE product_id = :id";
    $this->db->query($query, $params);
  }

  public function delete($params)
  {
    $this->db->query("DELETE FROM product WHERE product_id = :id", $params);
  }

  public function setSessionUserId($userId)
  {
    $query = "SET @cms_user_id = :userId";
    // try {
    //   $stmt = $this->db->conn->prepare($query);
    //   $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    //   $stmt->execute();
    // } catch (PDOException $e) {
    //   throw new Exception("Error setting session user ID: " . $e->getMessage());
    // }

    $this->db->query($query, ['userId' => $userId]);
  }
  public function getSessionUserId($userId)
  {
    $this->setSessionUserId($userId);

    $query = "SELECT @cms_user_id";
    // try {
    //   $stmt = $this->db->conn->prepare($query);
    //   $stmt->execute();
    //   $result = $stmt->fetch(PDO::FETCH_NUM);
    //   return $result ? $result[0] : 'Variable not set or is null';
    // } catch (PDOException $e) {
    //   throw new Exception("Error retrieving session variable: " . $e->getMessage());
    // }

    return $this->db->query($query)->fetch();
  }

  public function adminProductSearch($params)
  {
    $query = "SELECT * FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id WHERE sku LIKE :term OR product_name LIKE :term";
    $products = $this->db->query($query, $params)->fetchAll();
    return $products;
  }
}
