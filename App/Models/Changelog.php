<?php

namespace App\Models;

use Framework\Database;
use PDO, PDOException, Exception;

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
    LEFT JOIN product p ON c.product_id = p.product_id
    LEFT JOIN administrator a1 ON c.user_id = a1.user_id
    LEFT JOIN administrator a2 ON c.user_id_modifiedby = a2.user_id")->fetchAll();

    return $changelogs;
  }

  public function getDistinctUsers()
  {
    $query = "SELECT DISTINCT c.admin_user_id, CONCAT_WS(' - ', a.firstname, a.username) AS full_name 
              FROM (
                SELECT user_id AS admin_user_id FROM changelog
                WHERE user_id IS NOT NULL
                UNION
                SELECT user_id_modifiedby AS admin_user_id FROM changelog
                WHERE user_id_modifiedby IS NOT NULL
                ) c LEFT JOIN administrator a ON c.admin_user_id = a.user_id";

    $users = $this->db->query($query)->fetchAll();

    return $users;
  }

  public function setSessionUserId($userId)
  {
    $query = "SET @cms_user_id = :userId";
    try {
      $stmt = $this->db->conn->prepare($query);
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Error setting session user ID: " . $e->getMessage());
    }
  }

  public function getSessionUserId()
  {
    $query = "SELECT @cms_user_id";
    try {
      $stmt = $this->db->conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_NUM);
      if ($result) {
        return $result[0]; // The value of @cms_user_id
      } else {
        return 'Not set';
      }
    } catch (PDOException $e) {
      throw new Exception("Error retrieving session user ID: " . $e->getMessage());
    }
  }

  public function testSessionVariable($userId)
  {
    $this->setSessionUserId($userId);

    $query = "SELECT @cms_user_id";
    try {
      $stmt = $this->db->conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_NUM);
      return $result ? $result[0] : 'Variable not set or is null';
    } catch (PDOException $e) {
      throw new Exception("Error retrieving session variable: " . $e->getMessage());
    }
  }

  public function getFilterResults($params = [])
  {
    $conditions = [];

    $query = "SELECT c.*, p.sku, p.product_model, a1.firstname AS created_by, a2.firstname AS modified_by FROM changelog c
    LEFT JOIN product p ON c.product_id = p.product_id
    LEFT JOIN administrator a1 ON c.user_id = a1.user_id
    LEFT JOIN administrator a2 ON c.user_id_modifiedby = a2.user_id";

    if (!empty($params['admin_user'])) {
      $conditions[] = "(c.user_id = :admin_user OR c.user_id_modifiedby = :admin_user)";
    }

    if (!empty($params['product_term'])) {
      $conditions[] = "(p.sku LIKE :product_term OR p.product_model LIKE :product_term)";
    }

    if (!empty($params['dateFrom']) || !empty($params['dateTo'])) {
      $conditions[] = "((DATE(c.date_created) BETWEEN :dateFrom AND :dateTo) OR (DATE(c.date_last_modified) BETWEEN :dateFrom AND :dateTo))";
    }

    if (!empty($conditions)) {
      $query .= " WHERE " . implode(' AND ', $conditions);
    }

    // inspectAndDie($query);

    $changelogs = $this->db->query($query, $params)->fetchAll();
    // inspectAndDie($this->db->query($query, $params));

    return $changelogs;
  }
}
