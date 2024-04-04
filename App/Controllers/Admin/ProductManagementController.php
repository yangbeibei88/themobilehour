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
    // $allowedFields = ["sku", "product_name", "category", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc", "weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear-camera", "front-camera", "imgpath1", "alt1", "imgpath2", "alt2", "imgpath3", "alt3", "imgpath4", "alt4", "imgpath5", "alt5"];

    $allowedFields = [
      'product_meta' => ["sku", "product_name", "category", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc"],
      'product_feature' => ["weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear-camera", "front-camera"],
      'product_imggallery' => ["imgpath1", "alt1", "imgpath2", "alt2", "imgpath3", "alt3", "imgpath4", "alt4", "imgpath5", "alt5"]
    ];

    // $newProductData = array_intersect_key($_POST, array_flip($allowedFields));

    $newProductMetaData = array_intersect_key($_POST, array_flip($allowedFields['product_meta']));
    $newProductFeatureData = array_intersect_key($_POST, array_flip($allowedFields['product_feature']));
    $newProductImgGallery = array_intersect_key($_POST, array_flip($allowedFields['product_imggallery']));

    // $newProductData['user_id'] = 1;

    $requiredFields = ["sku", "product_name", "list_price"];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newProductMetaData[$field])) {
        $errors[] = ucfirst($field) . ' is required';
      }
    }

    // $newProductData = array_map('sanitize', $newProductData);

    $newProductMetaData = array_map('sanitize', $newProductMetaData);
    $newProductFeatureData = array_map('sanitize', $newProductFeatureData);
    $newProductImgGallery = array_map('sanitize', $newProductImgGallery);

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'productMeta' => $newProductMetaData
      ]);
    } else {
      // submit data

      $productMetaFields = [];
      $newProductFeatureFields = [];
      foreach ($newProductMetaData as $field => $value) {
        $productMetaFields[] = $field;
      }
      foreach ($newProductFeatureData as $field => $value) {
        $newProductFeatureFields[] = $field;
      }

      $productMetaFields = implode(', ', $productMetaFields);
      $newProductFeatureFields = implode(', ', $newProductFeatureFields);

      $productMetaValues = [];
      $productFeatureValues = [];
      foreach ($newProductMetaData as $field => $value) {
        if ($value === '') {
          $newProductMetaData[$field] === null;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $newProductMetaData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
        }

        $productMetaValues[] = ':' . $field;
      }

      foreach ($newProductFeatureData as $field => $value) {
        if ($value === '') {
          $newProductFeatureData[$field] === null;
        }

        $productFeatureValues[] = ':' . $field;
      }

      $productMetaValues = implode(', ', $productMetaValues);
      $productFeatureValues = implode(', ', $productFeatureValues);


      // inspectAndDie($fields);
      // inspectAndDie($values);
    }


    inspectAndDie($newProductMetaData);
  }
}
