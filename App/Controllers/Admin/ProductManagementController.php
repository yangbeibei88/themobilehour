<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use Framework\Validation;

class ProductManagementController
{
  protected $productModel;
  protected $categoryModel;
  protected $featureModel;

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

  public function getFeatures()
  {
    return $this->featureModel = new Feature();
  }

  /**
   * store data in a database
   *
   * @return void
   */
  public function store()
  {
    // Sanitizing data, only fields in $allowedFields can be submitted through $_POST

    $allowedFields = [
      'product_meta' => ["sku", "product_name", "category_id", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc"],
      'product_feature' => ["weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear_camera", "front_camera"],
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


    $excludeSanitizeFields = ["product_desc"];

    // $newProductMetaData = array_map('sanitize', array_filter($newProductMetaData, function($key) use ($excludeSanitizeFields) {
    //   return !in_array($key, $excludeSanitizeFields);
    // }, ARRAY_FILTER_USE_KEY));
    // $newProductMetaData = array_map('sanitize', $newProductMetaData);
    $newProductMetaData = sanitizeArr($newProductMetaData, $excludeSanitizeFields);

    $newProductFeatureData = array_map('sanitize', $newProductFeatureData);
    $newProductImgGallery = array_map('sanitize', $newProductImgGallery);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newProductMetaData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    }


    // inspectAndDie($newProductMetaData);

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'productMeta' => $newProductMetaData,
        'productFeature' => $newProductFeatureData
      ]);
    } else {
      // submit data

      $productMetaFields = [];
      $productFeatureFields = [];
      foreach ($newProductMetaData as $field => $value) {
        $productMetaFields[] = $field;
      }
      foreach ($newProductFeatureData as $field => $value) {
        $productFeatureFields[] = $field;
      }


      $productMetaFields = implode(', ', $productMetaFields);
      $productFeatureFields = implode(', ', $productFeatureFields);

      $productMetaValues = [];
      $productFeatureValues = [];


      foreach ($newProductMetaData as $field => $value) {

        if ($value === '') {
          $newProductMetaData[$field] === null;
        }

        $productMetaValues[] = ':' . $field;
      }

      // inspectAndDie($productMetaFields);
      // inspectAndDie($productMetaValues);

      foreach ($newProductFeatureData as $field => $value) {
        if ($value === '') {
          $newProductFeatureData[$field] === null;
        }

        $productFeatureValues[] = ':' . $field;
      }

      // inspectAndDie($values);

      if (count(array_filter($productFeatureValues, fn ($val) => empty($val))) < count(explode(', ', $productFeatureFields))) {
        $productFeatureValues = implode(', ', $productFeatureValues);
        $this->getFeatures()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
        // $newProductMetaData['feature_id'] = $this->getFeatures()->getInsertID();
      }

      $productMetaValues = implode(', ', $productMetaValues);
      // inspectAndDie($productMetaValues);

      $this->productModel->insert($productMetaFields, $productMetaValues, $newProductMetaData);

      redirect('product-management');
      // inspectAndDie($fields);
      // inspectAndDie($values);
    }
  }
}
