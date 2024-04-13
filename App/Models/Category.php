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

  public function getSingleCategory($params)
  {
    $query = "SELECT * FROM category WHERE category_id = :id";

    $category = $this->db->query($query, $params)->fetch();
    return $category;
  }

  public function productCountByCategory()
  {

    $categories = $this->db->query(
      "SELECT c.*, COUNT(p.product_id) AS productCount, SUM(p.stock_on_hand) AS stock FROM category c
      LEFT JOIN product p ON c.category_id = p. category_id
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
}
