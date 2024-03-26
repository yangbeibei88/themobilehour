<?php
$config = require basePath('config/config.php');
$db = new Database($config);

$products = $db->query("SELECT * FROM product")->fetchAll();

// inspect($products);

loadView('Products/index', [
  'products' => $products
]);
