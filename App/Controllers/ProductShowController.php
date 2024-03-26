<?php
$config = require basePath('config/config.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';

inspect($id);

$params = [
  'id' => $id
];

$product = $db->query("SELECT * FROM product WHERE product_id = :id", $params)->fetch();

inspect($product);
loadView('Products/show');
