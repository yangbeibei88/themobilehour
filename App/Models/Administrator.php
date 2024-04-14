<?php

namespace App\Models;

use Framework\Database;

class Administrator
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
  }

  public function getAllUsers()
  {
    $adminUsers = $this->db->query("SELECT * FROM administrator")->fetchAll();
    return $adminUsers;
  }

  public function getSingleUserByEmail($params)
  {
    $adminUser = $this->db->query("SELECT * FROM administrator WHERE username = :username", $params)->fetch();
    return $adminUser;
  }

  public function getSingleUserById($params)
  {
    $adminUser = $this->db->query("SELECT * FROM administrator WHERE user_id = :id", $params)->fetch();
    return $adminUser;
  }

  public function getSingleUserByEmailAndId($params)
  {
    $adminUser = $this->db->query("SELECT * FROM administrator WHERE username = :username AND user_id <> :id", $params)->fetch();
    return $adminUser;
  }

  public function insert($fields, $values, $params)
  {
    $query = "INSERT INTO administrator({$fields}) VALUES({$values})";
    $this->db->query($query, $params);
  }

  public function update($fields, $params)
  {
    $query = "UPDATE administrator SET {$fields} WHERE user_id = :id";
    $this->db->query($query, $params);
  }
}
