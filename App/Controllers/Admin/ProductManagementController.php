<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Framework\Validation;

class ProductManagementController
{
  protected $productModel;
  protected $categoryModel;

  public function __construct()
  {
    $this->productModel = new Product();
  }

  /**
   * Show all products in Product Management of Admin dashboard
   *
   * @return void
   */
  public function index()
  {
    $products = $this->productModel->getAllProducts();
    loadView('Admin/ProductManagement/index', [
      'products' => $products
    ]);
  }

  public function create()
  {

    $categories = $this->getCategories();

    loadView('Admin/ProductManagement/create', [
      'categories' => $categories
    ]);
  }

  public function getCategories()
  {

    $this->categoryModel = new Category();
    $categories = $this->categoryModel->getAllCategories();
    return $categories;
  }

  /**
   * store data in a database
   *
   * @return void
   */
  public function store()
  {
    // Sanitizing data, only fields in $allowedFields can be submitted through $_POST
    $allowedFields = ["sku", "product_name", "category", "product_model", "manufacturer", "list_price", "discount", "stock", "displayOnline", "description", "weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear-camera", "front-camera", "imgpath1", "alt1", "imgpath2", "alt2", "imgpath3", "alt3", "imgpath4", "alt4", "imgpath5", "alt5"];

    $newProductData = array_intersect_key($_POST, array_flip($allowedFields));

    $newProductData['user_id'] = 1;

    $requiredFields = ["sku", "product_name", "list_price"];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newProductData[$field])) {
        $errors[] = ucfirst($field) . ' is required';
      }
    }

    $newProductData = array_map('sanitize', $newProductData);

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'product' => $newProductData
      ]);
    } else {
      // submit data
      echo 'Success';
    }


    // inspectAndDie($newProductData);

  }
}
