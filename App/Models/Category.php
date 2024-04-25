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

  public function getAllActiveCategories()
  {
    $params = ['is_active' => 1];
    $categories = $this->db->query('SELECT * FROM category WHERE is_active = :is_active', $params);
    return $categories;
  }

  public function getFourActiveCategories()
  {
    $params = ['is_active' => 1];
    $categories = $this->db->query('SELECT * FROM category WHERE is_active = :is_active LIMIT 4', $params);
    return $categories;
  }

  public function getSingleCategory($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];

    $query = "SELECT * FROM category WHERE category_id = :id";

    $category = $this->db->query($query, $params)->fetch();
    return $category;
  }

  public function getAllProductsByCategory($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];

    $query = "SELECT * FROM product WHERE category_id = :id";

    $products = $this->db->query($query, $params)->fetchAll();

    return $products;
  }

  public function getAllActiveProductsByCategory($params)
  {
    $id = $params['id'];
    $params = [
      'id' => $id,
      'product_is_active' => 1,
      'category_is_active' => 1,
    ];

    $query = "SELECT p.*, c.*, f.*, g.*, p.is_active AS product_is_active, c.is_active AS category_is_active 
              FROM product p 
              LEFT JOIN feature f ON p.feature_id = f.feature_id  
              LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
              RIGHT JOIN category c ON p.category_id = c.category_id
              WHERE c.category_id = :id AND p.is_active = :product_is_active AND c.is_active = :category_is_active";

    $products = $this->db->query($query, $params)->fetchAll();

    return $products;
  }

  public function getSingleCategoryByName($params)
  {
    $query = "SELECT * FROM category WHERE category_name = :category_name";
    $category = $this->db->query($query, $params)->fetch();
    return $category;
  }

  public function getSingleCategoryByNameAndId($params)
  {
    $query = "SELECT * FROM category WHERE category_name = :category_name AND category_id <> :id";
    $category = $this->db->query($query, $params)->fetch();
    return $category;
  }

  public function getSingleCategoryCount($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];

    $query = "SELECT c.*, COUNT(p.product_id) AS productCount FROM category c 
    LEFT JOIN product p ON c.category_id = p.category_id
    WHERE c.category_id = :id
    GROUP BY c.category_id";

    $category = $this->db->query($query, $params)->fetch();

    return $category;
  }

  public function productCountByCategory()
  {

    $categories = $this->db->query(
      "SELECT c.*, COUNT(p.product_id) AS productCount, SUM(p.stock_on_hand) AS stock FROM category c
      LEFT JOIN product p ON c.category_id = p.category_id
      GROUP BY c.category_id"
    )->fetchAll();

    return $categories;
  }

  public function getStoragesbyCategory($params)
  {
    $id = $params['id'];
    $params = [
      'product_is_active' => 1,
      'id' => $id
    ];

    $query = "SELECT p.*, f.*, COUNT(p.product_id) AS productCount, p.is_active AS product_is_active 
              FROM product p
              LEFT JOIN feature f ON p.feature_id = f.feature_id
              WHERE p.is_active = :product_is_active AND p.category_id = :id
              GROUP BY f.storage";

    $storages = $this->db->query($query, $params)->fetchAll();

    return $storages;
  }

  public function getScreensizeByCategory($params)
  {
    $id = $params['id'];
    $params = [
      'product_is_active' => 1,
      'id' => $id
    ];

    $query = "SELECT p.*, f.*, COUNT(p.product_id) AS productCount, p.is_active AS product_is_active 
              FROM product p
              LEFT JOIN feature f ON p.feature_id = f.feature_id
              WHERE p.is_active = :product_is_active AND p.category_id = :id
              GROUP BY f.screensize";

    $screensizes = $this->db->query($query, $params)->fetchAll();

    return $screensizes;
  }
  public function getResolutionByCategory($params)
  {
    $id = $params['id'];
    $params = [
      'product_is_active' => 1,
      'id' => $id
    ];

    $query = "SELECT p.*, f.*, COUNT(p.product_id) AS productCount, p.is_active AS product_is_active 
              FROM product p
              LEFT JOIN feature f ON p.feature_id = f.feature_id
              WHERE p.is_active = :product_is_active AND p.category_id = :id
              GROUP BY f.resolution";

    $resolutions = $this->db->query($query, $params)->fetchAll();

    return $resolutions;
  }

  public function insert($fields, $values, $params)
  {
    $query = "INSERT INTO category({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
  }

  public function update($fields, $params)
  {
    $query = "UPDATE category SET {$fields} WHERE category_id = :id";
    $this->db->query($query, $params);
  }

  public function delete($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];
    $this->db->query("DELETE FROM category WHERE category_id = :id", $params);
  }

  public function getCategoryFilterProducts($params)
  {
    $id = $params['id'];
    $conditions = [];
    $allParams = ['id' => $id];

    if (!empty($params['storage'])) {
      $storageParams = array_combine(
        array_map(fn ($key) => 'stor' . $key, array_keys($params['storage'])),
        $params['storage']
      );
      $conditions[] = 'f.storage IN (' . implode(', ', array_map(fn ($key) => ':' . $key, array_keys($storageParams))) . ')';
      $allParams = array_merge($allParams, $storageParams);
    }

    if (!empty($params['screensize'])) {
      $screensizeParams = array_combine(
        array_map(fn ($key) => 'screensize' . $key, array_keys($params['screensize'])),
        $params['screensize']
      );
      $conditions[] = 'f.screensize IN (' . implode(', ', array_map(fn ($key) => ':' . $key, array_keys($screensizeParams))) . ')';
      $allParams = array_merge($allParams, $screensizeParams);
    }

    // if (empty($conditions)) {
    //   return []; // No filters selected, could return all or none based on requirements
    // }

    $query = "SELECT p.*, f.*, c.*, g.*, p.is_active AS product_is_active FROM product p 
    LEFT JOIN feature f ON p.feature_id = f.feature_id  
    LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
    RIGHT JOIN category c ON p.category_id = c.category_id
    WHERE p.is_active = 1 AND c.category_id = :id";

    if (!empty($conditions)) {
      $query .= " AND (" . implode(' AND ', $conditions) . ")";
    }


    // inspectAndDie($allParams);
    // inspectAndDie($query);

    // Execute the query using your query function which handles the binding
    $products = $this->db->query($query, $allParams)->fetchAll();

    return $products;
  }
}
