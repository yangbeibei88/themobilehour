<?php
// $config = require basePath('config/config.php');
// $db = new Database($config);

// $id = $_GET['id'] ?? '';

// inspect($id);

// $params = [
//   'id' => $id
// ];

// $product = $db->query("SELECT * FROM product p 
//                         LEFT JOIN feature f ON p.feature_id = f.feature_id  
//                         LEFT JOIN category c ON p.category_id = c.category_id
//                         LEFT JOIN product_image_gallery g ON p.image_gallery_id = g.image_gallery_id
//                         WHERE p.product_id = :id", $params)->fetch();

require basePath('App/Models/Product.php');

// inspect($product);
loadView('Products/show', [
  'product' => $product
]);
