<?php
class Database
{
  public $conn;

  public function __construct($config)
  {
    $dsn = "{$config['dbms']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);

      echo '<br>';
      echo 'database connected!';
      echo '<br>';
    } catch (PDOException $e) {
      throw new Exception("Database connection failed: {$e->getMessage()}");
    }
  }
}
