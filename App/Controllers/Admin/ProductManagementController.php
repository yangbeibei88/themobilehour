<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Category;
use App\Models\Changelog;
use App\Models\Feature;
use App\Models\Product;
use Framework\Session;
use Framework\Validation;

class ProductManagementController
{
  protected $productModel;
  protected $categoryModel;
  protected $featureModel;
  protected $changelogModel;

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
      'products' => $products,
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

  public function getChangelog()
  {
    return $this->changelogModel = new Changelog();
  }

  /**
   * show the product edit form
   *
   * @param array $params
   * @return void
   */
  public function edit($params)
  {

    $id = $params['id'] ?? '';

    inspect($id);

    $params = [
      'id' => $id
    ];
    $product = $this->productModel->getSingleProduct($params);
    $categories = $this->getCategories();

    if (!$product) {
      AdminErrorController::notFound('Product not found');
    } else {
      // inspectAndDie($product);
      loadView('Admin/ProductManagement/edit', [
        'product' => $product,
        'categories' => $categories
      ]);
    }
  }

  /**
   * Update a product
   *
   * @param array $params
   * @return void
   */
  public function update($params)
  {


    // $cmsUserId = $this->getChangelog()->testSessionVariable($userId);

    // $cmsUserId = $this->getChangelog()->getSessionUserId();

    // inspectAndDie($cmsUserId);
    // inspectAndDie($userId);

    $userId = Session::get('adminUser')['id'];

    $this->productModel->setSessionUserId($userId);

    $id = $params['id'] ?? '';

    $params = [
      'id' => $id
    ];



    $product = $this->productModel->getSingleProduct($params);
    $categories = $this->getCategories();


    /*-----------------------INSERT CHANGELOG START------------------------*/
    // $this->getChangelog()->setSessionUserId($userId);

    /*-----------------------INSERT CHANGELOG END------------------------*/

    $allowedFields = [
      'product_meta' => ["sku", "product_name", "category_id", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc"],
      'product_feature' => ["weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear_camera", "front_camera"],
      'product_imggallery' => ["imgpath1", "alt1", "imgpath2", "alt2", "imgpath3", "alt3", "imgpath4", "alt4", "imgpath5", "alt5"]
    ];

    $updateProductMetaData = array_intersect_key($_POST, array_flip($allowedFields['product_meta']));
    $updateProductFeatureData = array_intersect_key($_POST, array_flip($allowedFields['product_feature']));
    $updateProductImgGallery = array_intersect_key($_POST, array_flip($allowedFields['product_imggallery']));




    $excludeSanitizeFields = ["product_desc"];
    $updateProductMetaData = sanitizeArr($updateProductMetaData, $excludeSanitizeFields);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updateProductMetaData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    }

    $updateProductFeatureData = array_map('sanitize', $updateProductFeatureData);
    $updateProductImgGallery = array_map('sanitize', $updateProductImgGallery);

    $requiredFields = ["sku", "product_name", "list_price", "category_id"];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($updateProductMetaData[$field])) {
        $errors[] = ucfirst($field) . ' is required';
      }
    }

    if (!empty($errors)) {
      loadView('Admin/ProductManagement/edit', [
        'errors' => $errors,
        'product' => $product
      ]);
      exit;
    } else {

      // submit updated data to database

      /*-----------------------UPDATE PRODUCT META START------------------------*/

      $updateProductMetaFields = [];
      foreach (array_keys($updateProductMetaData) as $field) {
        $updateProductMetaFields[] = "{$field} =:{$field}";
      }
      $updateProductMetaFields = implode(', ', $updateProductMetaFields);
      $updateProductMetaData['id'] = $id;
      $this->productModel->update($updateProductMetaFields, $updateProductMetaData);


      /*-----------------------UPDATE PRODUCT META END------------------------*/



      /*-----------------------UPDATE FEATURES START------------------------*/
      $updateProductFeatureFields = [];

      foreach (array_keys($updateProductFeatureData) as $field) {
        $updateProductFeatureFields[] = "{$field} =:{$field}";
      }
      $updateProductFeatureFields = implode(', ', $updateProductFeatureFields);
      $updateProductFeatureData['id'] = $product->feature_id;
      $this->getFeatures()->update($updateProductFeatureFields, $updateProductFeatureData);
      // inspectAndDie($updateProductFeatureFields);
      /*-----------------------UPDATE FEATURES END------------------------*/



      // set flash message
      $_SESSION['success_message'] = 'PRODUCT UPDATED SUCCESSFULLY';

      redirect(assetPath('admin/product-management'));
    }
  }

  /**
   * store data in a database
   *
   * @return void
   */
  public function store()
  {
    $userId = Session::get('adminUser')['id'];

    $this->productModel->setSessionUserId($userId);

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

    $userId = Session::get('adminUser')['id'];
    /*-----------------------INSERT CHANGELOG START------------------------*/
    $this->getChangelog()->setSessionUserId($userId);
    /*-----------------------INSERT CHANGELOG END------------------------*/

    $requiredFields = ["sku", "product_name", "list_price", "category_id"];

    $errors = [];


    // $newProductData = array_map('sanitize', $newProductData);


    // $newProductMetaData = array_map('sanitize', array_filter($newProductMetaData, function($key) use ($excludeSanitizeFields) {
    //   return !in_array($key, $excludeSanitizeFields);
    // }, ARRAY_FILTER_USE_KEY));
    // $newProductMetaData = array_map('sanitize', $newProductMetaData);

    $excludeSanitizeFields = ["product_desc"];

    $newProductMetaData = sanitizeArr($newProductMetaData, $excludeSanitizeFields);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newProductMetaData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    }

    $newProductFeatureData = array_map('sanitize', $newProductFeatureData);
    $newProductImgGallery = array_map('sanitize', $newProductImgGallery);

    foreach ($requiredFields as $field) {
      if (empty($newProductMetaData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }


    // inspectAndDie($newProductMetaData);

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'productMeta' => $newProductMetaData,
        'productFeature' => $newProductFeatureData
      ]);
      exit;
    } else {
      // submit data


      $productFeatureFields = [];

      foreach ($newProductFeatureData as $field => $value) {
        $productFeatureFields[] = $field;
      }



      $productFeatureFields = implode(', ', $productFeatureFields);


      $productFeatureValues = [];

      // inspectAndDie($productMetaFields);
      // inspectAndDie($productMetaValues);

      foreach ($newProductFeatureData as $field => $value) {
        // if ($value === '') {
        //   $newProductFeatureData[$field] === null;
        // }

        $productFeatureValues[] = ':' . $field;
      }

      // inspectAndDie($productFeatureValues);

      // inspectAndDie($newProductFeatureData);
      // inspectAndDie(count(array_filter($newProductFeatureData, fn ($val) => !empty($val))));

      /*-------below logic is feature is only inserted when no feature empty fields-----------*/

      // if (count(array_filter($newProductFeatureData, fn ($val) => !empty($val))) > 0) {
      //   $productFeatureValues = implode(', ', $productFeatureValues);
      //   $this->getFeatures()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
      //   $newProductMetaData['feature_id'] = $this->featureModel->getInsertID();

      //   // inspectAndDie($newProductMetaData['feature_id']);
      // }
      /*-------above logic is feature is only inserted when no feature empty fields-----------*/
      $productFeatureValues = implode(', ', $productFeatureValues);
      $this->getFeatures()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
      $newProductMetaData['feature_id'] = $this->featureModel->getInsertID();
      // inspectAndDie($newProductMetaData['feature_id']);

      $productMetaFields = [];

      foreach ($newProductMetaData as $field => $value) {
        $productMetaFields[] = $field;
      }

      $productMetaFields = implode(', ', $productMetaFields);

      $productMetaValues = [];

      foreach ($newProductMetaData as $field => $value) {

        // if ($value === '') {
        //   $newProductMetaData[$field] === null;
        // }

        $productMetaValues[] = ':' . $field;
      }

      $productMetaValues = implode(', ', $productMetaValues);

      // inspectAndDie($productMetaValues);

      $this->productModel->insert($productMetaFields, $productMetaValues, $newProductMetaData);


      $_SESSION['success_message'] = 'PRODUCT CREATED SUCCESSFULLY';

      redirect('product-management');
      // inspectAndDie($fields);
      // inspectAndDie($values);
    }
  }

  public function delete($params)
  {
    $id = $params['id'];

    $params = [
      'id' => $id
    ];

    $product = $this->productModel->getSingleProduct($params);

    loadView('Admin/ProductManagement/delete', [
      'product' => $product
    ]);
  }

  public function destroy($params)
  {
    $id = $params['id'];

    $params = [
      'id' => $id
    ];

    $product = $this->productModel->getSingleProduct($params);

    $this->productModel->delete($params);

    // set flash message
    $_SESSION['success_message'] = 'PRODUCT DELETED SUCCESSFULLY';

    redirect(assetPath('admin/product-management'));
  }
}
