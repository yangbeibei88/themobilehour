<?php

namespace App\Controllers\Admin;

use App\Models\Product;

class ProductManagementController
{
  protected $model;

  public function __construct()
  {
    $this->model = new Product();
  }

  /**
   * Show all products in Product Management of Admin dashboard
   *
   * @return void
   */
  public function index()
  {
    $products = $this->model->getAllProducts();
    loadView('Admin/ProductManagement/index', [
      'products' => $products
    ]);
  }
}
