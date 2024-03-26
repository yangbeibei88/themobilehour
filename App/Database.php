<?php
class Database
{
  public $conn;

  /**
   * constructor for database class;
   * database config info is in config/config.php;
   *
   * @param array $config
   */
  public function __construct($config)
  {
    $dsn = "{$config['dbms']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
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

  /**
   * Query the database
   *
   * @param string $query
   * @param array $params
   * @return PDOStatement
   * @throws PDOException
   */
  public function query($query, $params = [])
  {
    try {
      $stmt = $this->conn->prepare($query);
      // bind named params
      foreach ($params as $param => $value) {
        $stmt->bindValue(':' . $param, $value);
      }

      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      throw new Exception("Query failed to execute: {$e->getMessage()}");
    }
  }
}
