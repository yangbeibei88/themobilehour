<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use Framework\Validation;

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

  public function create()
  {
    loadView('Admin/ProductManagement/create');
  }

  /**
   * store data in a database
   *
   * @return void
   */
  public function store()
  {
    // Sanitizing data, only fields in $allowedFields can be submitted through $_POST
    $allowedFields = ["sku", "title", "category", "product_model", "manufacturer", "list-price", "discount", "stock", "displayOnline", "description", "weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "CPU", "battery", "rear-camera", "front-camera", "imgpath1", "alt1", "imgpath2", "alt2", "imgpath3", "alt3", "imgpath4", "alt4", "imgpath5", "alt5"];

    $newProductData = array_intersect_key($_POST, array_flip($allowedFields));

    $newProductData['nuser_id'] = 1;

    $newProductData = array_map('sanitize', $newProductData);

    inspectAndDie($newProductData);
    // inspectAndDie($_POST);
  }
}
