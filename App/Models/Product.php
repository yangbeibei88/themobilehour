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

  public function getAllActiveProducts()
  {
    $params = [
      'is_active' => 1
    ];
    $products = $this->db->query("SELECT * FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
    WHERE p.is_active = :is_active", $params)->fetchAll();

    return $products;
  }

  public function getActiveProductCountByCategory()
  {
    $params = [
      'product_is_active' => 1,
      'category_is_active' => 1,
    ];

    $query = "SELECT c.*, COUNT(p.product_id) AS productCount, c.is_active AS category_is_active, p.is_active AS product_is_active 
              FROM category c
              LEFT JOIN product p ON c.category_id = p.category_id
              WHERE p.is_active = :product_is_active AND c.is_active = :category_is_active
              GROUP BY c.category_id";

    $categories = $this->db->query($query, $params)->fetchAll();

    return $categories;
  }

  public function getActiveProductCountByStorage()
  {
    $params = [
      'product_is_active' => 1,
    ];

    $query = "SELECT p.*, f.*, COUNT(p.product_id) AS productCount, p.is_active AS product_is_active 
              FROM product p
              LEFT JOIN feature f ON p.feature_id = f.feature_id
              WHERE p.is_active = :product_is_active
              GROUP BY f.storage";

    $storages = $this->db->query($query, $params)->fetchAll();

    return $storages;
  }

  public function getSingleActiveProduct($params)
  {
    $id = $params['id'];
    $params = [
      'id' =>  $id,
      'is_active' => 1
    ];
    $product = $this->db->query("SELECT * FROM product p 
                            LEFT JOIN feature f ON p.feature_id = f.feature_id  
                            LEFT JOIN category c ON p.category_id = c.category_id
                            LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
                            WHERE p.product_id = :id AND p.is_active = :is_active", $params)->fetch();

    return $product;
  }

  public function getSingleProduct($params)
  {
    $id = $params['id'];
    $params = [
      'id' =>  $id
    ];
    $product = $this->db->query("SELECT 
                            p.*, f.*, c.*, g.*, p.is_active AS product_is_active, c.is_active AS category_is_active FROM product p 
                            LEFT JOIN feature f ON p.feature_id = f.feature_id  
                            LEFT JOIN category c ON p.category_id = c.category_id
                            LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
                            WHERE p.product_id = :id", $params)->fetch();

    return $product;
  }

  public function getSingleProductBySku($params)
  {
    $product = $this->db->query("SELECT * FROM product
                            WHERE product.sku = :sku", $params)->fetch();

    return $product;
  }

  public function getSingleProductBySkuAndId($params)
  {
    $product = $this->db->query("SELECT * FROM product
    WHERE sku = :sku AND product_id <> :id", $params)->fetch();

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

    $this->db->query($query, ['userId' => $userId]);
  }
  public function getSessionUserId($userId)
  {
    $this->setSessionUserId($userId);

    $query = "SELECT @cms_user_id";

    return $this->db->query($query)->fetch();
  }

  public function getMinSalePrice()
  {

    $query = "SELECT MIN(ROUND(list_price * (1 - disc_pct / 100),2)) AS minSalePrice FROM product";

    return $this->db->query($query)->fetch();
  }

  public function getMaxSalePrice()
  {
    $query = "SELECT MAX(ROUND(list_price * (1 - disc_pct / 100),2)) AS maxSalePrice FROM product";

    return $this->db->query($query)->fetch();
  }

  public function priceRanges()
  {
    $minSalePrice = (float)$this->getMinSalePrice()->minSalePrice;
    $maxSalePrice = (float)$this->getMaxSalePrice()->maxSalePrice;

    $priceRanges = [];
    $price = $minSalePrice;
    $i = 0;

    do {
      $nextPrice = $price + 200;
      // $priceRanges[] = ["priceLevel$i" => "$$price - $$nextPrice"];
      $priceRanges["priceLevel$i"] = [
        'label' => "$$price - $$nextPrice",
        'min' => $price,
        'max' => $nextPrice
      ];
      $price = $nextPrice;
      $i++;
    } while ($price <= $maxSalePrice);


    return $priceRanges;
  }

  public function getProductCountPriceRanges()
  {

    $priceRanges = $this->priceRanges();
    foreach ($priceRanges as $key => $value) {
      $params = [
        'minPrice' => $value['min'],
        'maxPrice' => $value['max']
      ];
      $query = "SELECT COUNT(product_id) AS productCount FROM product 
              WHERE ROUND(list_price * (1 - disc_pct / 100),2) BETWEEN :minPrice AND :maxPrice";

      $productCount = $this->db->query($query, $params)->fetch()->productCount;
      $priceRanges[$key]['count'] = $productCount;
    }

    // return price ranges that 
    return array_filter($priceRanges, fn ($priceRange) => $priceRange['count'] > 0);
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

  public function publicProductSearch($params)
  {
    $query = "SELECT p.*, f.*, c.*, g.*, p.is_active AS product_is_active, c.is_active AS category_is_active FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
    WHERE p.is_active = :product_is_active AND (sku LIKE :term OR product_name LIKE :term)";

    $products = $this->db->query($query, $params)->fetchAll();

    return $products;
  }

  public function getPublicFilterProducts($params)
  {
    $conditions = [];
    $allParams = [];

    // handling category filter
    if (!empty($params['category_id'])) {
      $categoryIdsParams = array_combine(
        array_map(fn ($key) => 'cat' . $key, array_keys($params['category_id'])),
        $params['category_id']
      );
      $conditions[] = 'c.category_id IN (' . implode(', ', array_map(fn ($key) =>
      ':' . $key, array_keys($categoryIdsParams))) . ')';
      $allParams = array_merge($allParams, $categoryIdsParams);
    }

    // handling storage filter
    if (!empty($params['storage'])) {
      $storageParams = array_combine(
        array_map(fn ($key) => 'stor' . $key, array_keys($params['storage'])),
        $params['storage']
      );
      $conditions[] = 'f.storage IN (' . implode(', ', array_map(fn ($key) => ':' . $key, array_keys($storageParams))) . ')';
      $allParams = array_merge($allParams, $storageParams);
    }

    // Adding price range filter
    if (!empty($params['minPrice']) && !empty($params['maxPrice'])) {
      $conditions[] = 'ROUND(p.list_price * (1 - p.disc_pct / 100), 2) BETWEEN :minPrice AND :maxPrice';
      $allParams['minPrice'] = $params['minPrice'];
      $allParams['maxPrice'] = $params['maxPrice'];
    }


    $query = "SELECT p.*, f.*, c.*, g.*, p.is_active AS product_is_active, c.is_active AS category_is_active FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN category c ON p.category_id = c.category_id
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
    WHERE p.is_active = 1";

    if (!empty($conditions)) {
      $query .= " AND (" . implode(' AND ', $conditions) . ")";
    }

    $products = $this->db->query($query, $allParams)->fetchAll();

    return $products;
  }
}
