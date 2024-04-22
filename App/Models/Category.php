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

  public function getSingleCategory($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];

    $query = "SELECT * FROM category WHERE category_id = :id";

    $category = $this->db->query($query, $params)->fetch();
    return $category;
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
}
