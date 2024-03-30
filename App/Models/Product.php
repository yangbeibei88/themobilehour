<?php

namespace App\Models;

use Framework\Database;

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

  public function getSingleProduct()
  {

    $id = $_GET['id'] ?? '';

    inspect($id);

    $params = [
      'id' => $id
    ];

    $product = $this->db->query("SELECT * FROM product p 
                            LEFT JOIN feature f ON p.feature_id = f.feature_id  
                            LEFT JOIN category c ON p.category_id = c.category_id
                            LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
                            WHERE p.product_id = :id", $params)->fetch();

    return $product;
  }
}
