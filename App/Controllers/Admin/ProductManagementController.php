<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductImageGallery;
use Framework\Session;
use Framework\Validation;

class ProductManagementController
{
  protected $productModel;
  protected $categoryModel;
  protected $featureModel;
  protected $productImageGalleryModel;

  public function __construct()
  {
    $this->productModel = new Product();
    $this->productImageGalleryModel = new ProductImageGallery();
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

  public function show($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];
    $product = $this->productModel->getSingleProduct($params);

    if (!$product) {
      AdminErrorController::notFound();
    } else {
      loadView('Admin/ProductManagement/show', [
        'product' => $product
      ]);
    }
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

    // inspectAndDie($product);

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


    /*-----------------------INSERT CHANGELOG START------------------------*/

    $userId = Session::get('adminUser')['id'];

    $this->productModel->setSessionUserId($userId);
    /*-----------------------INSERT CHANGELOG END------------------------*/

    $id = $params['id'] ?? '';

    $params = [
      'id' => $id
    ];



    $product = $this->productModel->getSingleProduct($params);
    $categories = $this->getCategories();

    $errors = [];


    $allowedFields = [
      'product_meta' => ["sku", "product_name", "category_id", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc"],
      'product_feature' => ["weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear_camera", "front_camera"]
    ];

    $updateProductMetaData = array_intersect_key($_POST, array_flip($allowedFields['product_meta']));
    $updateProductFeatureData = array_intersect_key($_POST, array_flip($allowedFields['product_feature']));
    $updateProductImgGalleryData = [];



    $excludeSanitizeFields = ["product_desc"];
    $updateProductMetaData = sanitizeArr($updateProductMetaData, $excludeSanitizeFields);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updateProductMetaData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    }

    $updateProductFeatureData = array_map('sanitize', $updateProductFeatureData);


    $requiredFields = ["sku", "product_name", "list_price"];


    foreach ($requiredFields as $field) {
      if (empty($updateProductMetaData[$field])) {
        $errors[] = ucfirst($field) . ' is required';
      }
    }

    // validate image data
    foreach ($_FILES as $file => $data) {
      // If file bigger than limit in php.ini
      // $errors[$file] = ($data['error'] === 1) ? "$file is too big" : '';
      if ($data['error'] === 1) {
        $errors[$file] = "$file is too big";
      }

      if ($data['tmp_name'] && $data['error'] === 0) {
        // convert file extension to lowercase
        $extension = strtolower(pathinfo($data['name'], PATHINFO_EXTENSION));
        switch (true) {
            // validate file type
          case !in_array(mime_content_type($data['tmp_name']), IMAGE_TYPES):
            $errors[$file] = "$file is a wrong file type.";
            break;
            // validate file extension
          case !in_array($extension, IMAGE_EXTENSIONS):
            $errors[$file] = "$file has a wrong file extension.";
            break;
            // validate file size
          case $data['size'] > IMAGE_MAX_SIZE:
            $errors[$file] = "$file is too big.";
            break;
        }
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

      /*-----------------------UPDATE PRODUCT IMAGES START------------------------*/


      // IMAGE DATA
      // Initialise image uploads

      $upload_path = 'uploads/images/';


      foreach ($_FILES as $file => $data) {

        if ($data['tmp_name']) {
          $moved = false;
          $filename = createFileName($data['name'], IMAGE_UPLOADS);
          $destination = IMAGE_UPLOADS . $filename;
          $moved = move_uploaded_file($data['tmp_name'], $destination);
          if ($moved === true) {
            $updateProductImgGalleryData[$file] = $upload_path . $filename;
            $num = substr($file, -1);
            $altKey = 'alt' . $num;
            $updateProductImgGalleryData[$altKey] = sanitize($_POST[$altKey]);
          }
        }
      }

      $updateProductImgGalleryFields = [];


      foreach (array_keys($updateProductImgGalleryData) as $field) {
        $updateProductImgGalleryFields[] = "{$field} =:{$field}";
      }

      $updateProductImgGalleryFields = implode(', ', $updateProductImgGalleryFields);


      // inspectAndDie($newProductImgGalleryData);


      $updateProductImgGalleryData['id'] = $product->image_gallery_id;
      $this->productImageGalleryModel->update($updateProductImgGalleryFields, $updateProductImgGalleryData);



      /*-----------------------UPDATE PRODUCT IMAGES END------------------------*/

      // set flash message
      // $_SESSION['success_message'] = 'PRODUCT UPDATED SUCCESSFULLY';
      Session::setFlashMessage('success_message', 'PRODUCT UPDATED SUCCESSFULLY');

      redirect(assetPath('admin/product-management'));
    }
  }

  /**
   * store new product data to product table
   *
   * @return void
   */
  public function store()
  {

    /*--------------------INSERT CHANGELOG START--------------------*/
    // capture admin user id
    $userId = Session::get('adminUser')['id'];

    // push user id to changelog
    $this->productModel->setSessionUserId($userId);
    /*--------------------INSERT CHANGELOG END--------------------*/

    // Sanitizing data, only fields in $allowedFields can be submitted through $_POST
    $allowedFields = [
      'product_meta' => ["sku", "product_name", "category_id", "product_model", "manufacturer", "list_price", "disc_pct", "stock_on_hand", "is_active", "product_desc"],
      'product_feature' => ["weight", "dimensions", "os", "screensize", "resolution", "storage", "colour", "ram", "cpu", "battery", "rear_camera", "front_camera"],
    ];

    $errors = [];

    // $newProductData = array_intersect_key($_POST, array_flip($allowedFields));

    $newProductMetaData = array_intersect_key($_POST, array_flip($allowedFields['product_meta']));
    $newProductFeatureData = array_intersect_key($_POST, array_flip($allowedFields['product_feature']));
    $newProductImgGalleryData = [];



    $requiredFields = ["sku", "product_name", "list_price", "category_id"];


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

    foreach ($requiredFields as $field) {
      if (empty($newProductMetaData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }

    // validate image data
    foreach ($_FILES as $file => $data) {
      // If file bigger than limit in php.ini
      // $errors[$file] = ($data['error'] === 1) ? "$file is too big" : '';
      if ($data['error'] === 1) {
        $errors[$file] = "$file is too big";
      }

      if ($data['tmp_name'] && $data['error'] === 0) {
        // convert file extension to lowercase
        $extension = strtolower(pathinfo($data['name'], PATHINFO_EXTENSION));
        switch (true) {
            // validate file type
          case !in_array(mime_content_type($data['tmp_name']), IMAGE_TYPES):
            $errors[$file] = "$file is a wrong file type.";
            break;
            // validate file extension
          case !in_array($extension, IMAGE_EXTENSIONS):
            $errors[$file] = "$file has a wrong file extension.";
            break;
            // validate file size
          case $data['size'] > IMAGE_MAX_SIZE:
            $errors[$file] = "$file is too big.";
            break;
        }
      }
    }

    // inspectAndDie($errors);
    // inspectAndDie($newProductMetaData);
    // inspectAndDie($imageTemps);
    // inspectAndDie($errors);
    // inspectAndDie($_FILES);
    // inspectAndDie(pathinfo($_FILES['product-image1']['name'], PATHINFO_FILENAME));
    $categories = $this->getCategories();

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'productMeta' => $newProductMetaData,
        'productFeature' => $newProductFeatureData,
        'productImgGallery' => $newProductImgGalleryData,
        'categories' => $categories
      ]);
      exit;
    } else {

      /*-------------------SUBMIT PRODUCT IMAGE DATA START------------------------ */

      // IMAGE DATA
      // Initialise image uploads

      $upload_path = 'uploads/images/';


      foreach ($_FILES as $file => $data) {

        if ($data['tmp_name']) {
          $moved = false;
          $filename = createFileName($data['name'], IMAGE_UPLOADS);
          $destination = IMAGE_UPLOADS . $filename;
          $moved = move_uploaded_file($data['tmp_name'], $destination);
          if ($moved === true) {
            $newProductImgGalleryData[$file] = $upload_path . $filename;
            $num = substr($file, -1);
            $altKey = 'alt' . $num;
            $newProductImgGalleryData[$altKey] = sanitize($_POST[$altKey]);
          }
        }
      }

      $productImgGalleryFields = [];
      $productImgGalleryValues = [];

      foreach ($newProductImgGalleryData as $field => $value) {
        $productImgGalleryFields[] = $field;
        $productImgGalleryValues[] = ':' . $field;
      }

      $productImgGalleryFields = implode(', ', $productImgGalleryFields);
      $productImgGalleryValues = implode(', ', $productImgGalleryValues);

      // inspectAndDie($newProductImgGalleryData);

      $this->productImageGalleryModel->insert($productImgGalleryFields, $productImgGalleryValues, $newProductImgGalleryData);
      $newProductMetaData['image_gallery_id'] = $this->productImageGalleryModel->getInsertID();


      /*-------------------SUBMIT PRODUCT IMAGE DATA END------------------------ */

      /*-------------------SUBMIT FEATURE DATA START------------------------ */
      $productFeatureFields = [];
      $productFeatureValues = [];

      foreach ($newProductFeatureData as $field => $value) {
        $productFeatureFields[] = $field;
        // if ($value === '') {
        //   $newProductFeatureData[$field] === null;
        // }
        $productFeatureValues[] = ':' . $field;
      }


      $productFeatureFields = implode(', ', $productFeatureFields);
      $productFeatureValues = implode(', ', $productFeatureValues);

      $this->getFeatures()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
      $newProductMetaData['feature_id'] = $this->featureModel->getInsertID();
      // inspectAndDie($newProductMetaData['feature_id']);


      /*-------below logic is feature is only inserted when no feature empty fields-----------*/

      // if (count(array_filter($newProductFeatureData, fn ($val) => !empty($val))) > 0) {
      //   $productFeatureValues = implode(', ', $productFeatureValues);
      //   $this->getFeatures()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
      //   $newProductMetaData['feature_id'] = $this->featureModel->getInsertID();

      //   // inspectAndDie($newProductMetaData['feature_id']);
      // }
      /*-------above logic is feature is only inserted when no feature empty fields-----------*/


      /*-------------------SUBMIT FEATURE DATA END------------------------ */



      /*-------------------SUBMIT PRODUCT META DATA START------------------------ */

      $productMetaFields = [];
      $productMetaValues = [];

      foreach ($newProductMetaData as $field => $value) {
        $productMetaFields[] = $field;
        // if ($value === '') {
        //   $newProductMetaData[$field] === null;
        // }

        $productMetaValues[] = ':' . $field;
      }

      $productMetaFields = implode(', ', $productMetaFields);
      $productMetaValues = implode(', ', $productMetaValues);

      // inspectAndDie($productMetaValues);

      $this->productModel->insert($productMetaFields, $productMetaValues, $newProductMetaData);


      Session::setFlashMessage('success_message', 'PRODUCT CREATED SUCCESSFULLY');
      // $_SESSION['success_message'] = 'PRODUCT CREATED SUCCESSFULLY';

      /*-------------------SUBMIT PRODUCT META DATA END------------------------ */

      redirect('product-management');
      // inspectAndDie($fields);
      // inspectAndDie($values);
    }
  }

  /**
   * Delete a product
   * 
   * @param array $params
   * @return void
   */
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

  /**
   * Delete a product
   * 
   * @param array $params
   * @return void
   */
  public function destroy($params)
  {
    $id = $params['id'];

    $params = [
      'id' => $id
    ];

    $product = $this->productModel->getSingleProduct($params);

    $this->productModel->delete($params);

    // set flash message
    Session::setFlashMessage('success_message', "PRODUCT: <strong>{$product->sku}</strong> DELETED SUCCESSFULLY");
    // $_SESSION['success_message'] = 'PRODUCT DELETED SUCCESSFULLY';

    redirect(assetPath('admin/product-management'));
  }

  /**
   * search product by product sku or name
   * 
   * @return void
   */
  public function search()
  {
    // $term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
    $term = isset($_GET['term']) ? sanitize($_GET['term']) : '';
    // inspectAndDie($term);
    // inspectAndDie($_GET);

    $params = [
      'term' => "%{$term}%"
    ];

    $products = $this->productModel->adminProductSearch($params);

    $count = count($products);

    loadView('Admin/ProductManagement/index', [
      'products' => $products,
      'term' => $term,
      'count' => $count
    ]);
  }
}
