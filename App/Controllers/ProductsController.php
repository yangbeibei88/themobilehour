<?php

namespace App\Controllers;

use App\Models\Product;

class ProductsController
{

  protected $model;

  public function __construct()
  {
    $this->model = new Product();
  }


  public function index()
  {
    $products = $this->model->getAllProducts();
    // inspect($products);
    // $products = $db->query("SELECT * FROM product")->fetchAll();
    loadView('Products/index', [
      'products' => $products
    ]);
  }

  public function show()
  {
    $product = $this->model->getSingleProduct();
    loadView('Products/show', [
      'product' => $product
    ]);
  }
}
