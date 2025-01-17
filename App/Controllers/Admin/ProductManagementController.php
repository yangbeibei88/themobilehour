<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductImageGallery;
use Exception;
use Framework\Database;
use Framework\Session;
use Framework\Validation;
use HTMLPurifier;
use HTMLPurifier_Config;

class ProductManagementController
{
  protected $db;
  protected $productModel;
  protected $categoryModel;
  protected $featureModel;
  protected $productImageGalleryModel;

  public function __construct()
  {
    $config = require basePath('config/config.php');
    $this->db = new Database($config);
    $this->productModel = new Product();
  }

  public function getCategories()
  {

    $this->categoryModel = new Category();
    $categories = $this->categoryModel->getAllCategories();
    return $categories;
  }

  public function getFeatureModel()
  {
    return $this->featureModel = new Feature();
  }

  public function getProductImageGalleryModel()
  {
    return $this->productImageGalleryModel = new ProductImageGallery();
  }

  private function getInputProductMetaData()
  {
    $inputProductMetaData = filter_input_array(INPUT_POST, [
      'sku' => FILTER_DEFAULT,
      'product_name' => FILTER_DEFAULT,
      'category_id' => FILTER_DEFAULT,
      'product_model' => FILTER_DEFAULT,
      'manufacturer' => FILTER_DEFAULT,
      'list_price' => FILTER_DEFAULT,
      'disc_pct' => FILTER_DEFAULT,
      'stock_on_hand' => FILTER_DEFAULT,
      'is_active' => FILTER_VALIDATE_BOOLEAN,
      'product_desc' => FILTER_DEFAULT
    ]);

    // Convert Boolean is_active to TINYINT for MySQL
    $inputProductMetaData['is_active'] = $inputProductMetaData['is_active'] ? 1 : 0;

    return $inputProductMetaData;
  }

  private function getInputProductFeatureData()
  {
    $inputProductFeatureData = filter_input_array(INPUT_POST, [
      'weight' => FILTER_DEFAULT,
      'dimensions' => FILTER_DEFAULT,
      'os' => FILTER_DEFAULT,
      'screensize' => FILTER_DEFAULT,
      'resolution' => FILTER_DEFAULT,
      'storage' => FILTER_DEFAULT,
      'colour' => FILTER_DEFAULT,
      'ram' => FILTER_DEFAULT,
      'cpu' => FILTER_DEFAULT,
      'battery' => FILTER_DEFAULT,
      'rear_camera' => FILTER_DEFAULT,
      'front_camera' => FILTER_DEFAULT,
    ]);

    return $inputProductFeatureData;
  }

  private function getInputProductImgGalleryData()
  {
    $inputProductImgGalleryData = filter_input_array(INPUT_POST, [
      'alt1' => FILTER_DEFAULT,
      'alt2' => FILTER_DEFAULT,
      'alt3' => FILTER_DEFAULT,
    ]);
    return $inputProductImgGalleryData;
  }

  private function validateProductInputData($productMetaData, $productFeatureData, $productImgGalleryData)
  {
    $errors = [];
    $categories = $this->getCategories();

    $errors = [
      // product meta data validation
      'sku' => Validation::codePattern('sku', $productMetaData['sku'], 2, 254, TRUE),
      'product_name' => Validation::text('product_name', $productMetaData['product_name'], 2, 50, TRUE),
      'category_id' => Validation::categoryId('category_id', $productMetaData['category_id'], $categories, TRUE),
      'product_model' => Validation::codePattern('product_model', $productMetaData['product_model'], 2, 254, FALSE),
      'manufacturer' => Validation::text('manufacturer', $productMetaData['manufacturer'], 2, 50, FALSE),
      'list_price' => Validation::number('list_price', $productMetaData['list_price'], 0, NULL, TRUE),
      'disc_pct' => Validation::number('disc_pct', $productMetaData['disc_pct'], 0, 100, FALSE),
      'stock_on_hand' => Validation::number('stock_on_hand', $productMetaData['stock_on_hand'], 0, NULL, FALSE),
      'product_desc' => Validation::text('product_desc', $productMetaData['product_desc'], 2, 100000, FALSE),
      // product feature data validation
      'weight' => Validation::number('weight', $productFeatureData['weight'], 0, NULL, FALSE),
      'dimensions' => Validation::text('dimensions', $productFeatureData['dimensions'], 2, 50, FALSE),
      'os' => Validation::text('os', $productFeatureData['os'], 2, 20, FALSE),
      'screensize' => Validation::number('screensize', $productFeatureData['screensize'], 0, NULL, FALSE),
      'resolution' => Validation::text('resolution', $productFeatureData['resolution'], 2, 50, FALSE),
      'storage' => Validation::number('storage', $productFeatureData['storage'], 0, NULL, FALSE),
      'colour' => Validation::text('colour', $productFeatureData['colour'], 2, 50, FALSE),
      'ram' => Validation::number('ram', $productFeatureData['ram'], 0, NULL, FALSE),
      'cpu' => Validation::text('cpu', $productFeatureData['cpu'], 2, 50, FALSE),
      'battery' => Validation::number('battery', $productFeatureData['battery'], 0, NULL, FALSE),
      'rear_camera' => Validation::text('rear_camera', $productFeatureData['rear_camera'], 2, 100, FALSE),
      'front_camera' => Validation::text('front_camera', $productFeatureData['front_camera'], 2, 100, FALSE),
      // product image gallery alt-text validation
      'alt1' => Validation::text('alt1', $productImgGalleryData['alt1'], 2, 100, FALSE),
      'alt2' => Validation::text('alt2', $productImgGalleryData['alt2'], 2, 100, FALSE),
      'alt3' => Validation::text('alt3', $productImgGalleryData['alt3'], 2, 100, FALSE),
    ];


    foreach ($_FILES as $inputName => $fileInfo) {
      $errors[$inputName] = Validation::validateImage($fileInfo);
    }

    return $errors;
  }

  private function sanitizeProductInputData($productMetaData, $productFeatureData, $productImgGalleryData)
  {

    $trimmedProductMetaData = trimAndConvertNumericValues($productMetaData);
    $trimmedProductFeatureData = trimAndConvertNumericValues($productFeatureData);
    $trimmedProductImgGalleryData = trimAndConvertNumericValues($productImgGalleryData);

    $sanitizeInputProductMetaData = [
      'sku' => filter_var(strtoupper($trimmedProductMetaData['sku']), FILTER_SANITIZE_SPECIAL_CHARS),
      'product_name' => filter_var($trimmedProductMetaData['product_name'], FILTER_SANITIZE_SPECIAL_CHARS),
      'category_id' => filter_var($trimmedProductMetaData['category_id'], FILTER_SANITIZE_NUMBER_INT),
      'product_model' => filter_var($trimmedProductMetaData['product_model'], FILTER_SANITIZE_SPECIAL_CHARS),
      'manufacturer' => filter_var($trimmedProductMetaData['manufacturer'], FILTER_SANITIZE_SPECIAL_CHARS),
      'list_price' => filter_var($trimmedProductMetaData['list_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'disc_pct' => filter_var($trimmedProductMetaData['disc_pct'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'stock_on_hand' => filter_var($trimmedProductMetaData['stock_on_hand'], FILTER_SANITIZE_NUMBER_INT),
      'is_active' => $trimmedProductMetaData['is_active'],
      'product_desc' => $this->purifierTextarea()->purify($trimmedProductMetaData['product_desc'])
    ];

    $sanitizeInputProductFeatureData = [
      'weight' => filter_var($trimmedProductFeatureData['weight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'dimensions' => filter_var($trimmedProductFeatureData['dimensions'], FILTER_SANITIZE_SPECIAL_CHARS),
      'os' => filter_var($trimmedProductFeatureData['os'], FILTER_SANITIZE_SPECIAL_CHARS),
      'screensize' => filter_var($trimmedProductFeatureData['screensize'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'resolution' => filter_var($trimmedProductFeatureData['resolution'], FILTER_SANITIZE_SPECIAL_CHARS),
      'storage' => filter_var($trimmedProductFeatureData['storage'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'colour' => filter_var($trimmedProductFeatureData['colour'], FILTER_SANITIZE_SPECIAL_CHARS),
      'ram' => filter_var($trimmedProductFeatureData['ram'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'cpu' => filter_var($trimmedProductFeatureData['cpu'], FILTER_SANITIZE_SPECIAL_CHARS),
      'battery' => filter_var($trimmedProductFeatureData['battery'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
      'rear_camera' => filter_var($trimmedProductFeatureData['rear_camera'], FILTER_SANITIZE_SPECIAL_CHARS),
      'front_camera' => filter_var($trimmedProductFeatureData['front_camera'], FILTER_SANITIZE_SPECIAL_CHARS),
    ];

    $sanitizeInputProductImgGalleryData = [
      'alt1' => filter_var($trimmedProductImgGalleryData['alt1'], FILTER_SANITIZE_SPECIAL_CHARS),
      'alt2' => filter_var($trimmedProductImgGalleryData['alt2'], FILTER_SANITIZE_SPECIAL_CHARS),
      'alt3' => filter_var($trimmedProductImgGalleryData['alt3'], FILTER_SANITIZE_SPECIAL_CHARS),
    ];

    return [
      'productMetaData' => $sanitizeInputProductMetaData,
      'productFeatureData' => $sanitizeInputProductFeatureData,
      'productImgGalleryData' => $sanitizeInputProductImgGalleryData
    ];
  }

  private function moveAndUpdateFiles($fileArray, &$imgGalleryData)
  {
    moveFile($fileArray['imgpath1'], 'imgpath1', 'alt1', $imgGalleryData['alt1'], $imgGalleryData, 'uploads/images/');
    moveFile($fileArray['imgpath2'], 'imgpath2', 'alt2', $imgGalleryData['alt2'], $imgGalleryData, 'uploads/images/');
    moveFile($fileArray['imgpath3'], 'imgpath3', 'alt3', $imgGalleryData['alt3'], $imgGalleryData, 'uploads/images/');
  }

  private function purifierTextarea()
  {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
    $config->set('HTML.Allowed', 'p,br,strong,em,u,div,ul,ol,li,a[href]');
    $config->set('URI.DisableExternalResources', true);
    $config->set('AutoFormat.RemoveEmpty', true);

    $purifer = new HTMLPurifier($config);

    return $purifer;
  }

  /**
   * Show all products in Product Management of Admin dashboard
   *
   * @return void
   */
  public function index()
  {
    $products = $this->productModel->getAllProducts();
    $operators = $this->productModel->setOperators();

    loadView('Admin/ProductManagement/index', [
      'products' => $products,
      'operators' => $operators
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
    // $id = $params['id'];
    // $params = ['id' => $id];
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

    // $id = $params['id'] ?? '';

    // $params = [
    //   'id' => $id
    // ];
    $product = $this->productModel->getSingleProduct($params);
    $categories = $this->getCategories();


    $inputProductMetaData = $this->getInputProductMetaData();

    $inputProductFeatureData = $this->getInputProductFeatureData();

    $inputProductImgGalleryData = $this->getInputProductImgGalleryData();

    $errors = $this->validateProductInputData($inputProductMetaData, $inputProductFeatureData, $inputProductImgGalleryData);

    // check if sku exists
    $checkPrams = [
      'sku' => trimAndUpperCase($inputProductMetaData['sku']),
      'id' => $params['id']
    ];
    $productBySkuAndIdRow = $this->productModel->getSingleProductBySkuAndId($checkPrams);

    if ($productBySkuAndIdRow) {
      $errors['sku'] = 'The SKU already exists.';
    }

    // Filter out any non-errors
    $errors = array_filter($errors);



    // inspectAndDie($errors);

    if (!empty($errors)) {
      loadView('Admin/ProductManagement/edit', [
        'errors' => $errors,
        'product' => $product,
        'categories' => $categories
      ]);
      exit;
    } else {
      /*----------------------TRANSACTION BEGINS--------------------------------- */
      try {
        $this->db->conn->beginTransaction();

        $sanitizedData = $this->sanitizeProductInputData($inputProductMetaData, $inputProductFeatureData, $inputProductImgGalleryData);

        $updateProductMetaData = $sanitizedData['productMetaData'];
        // inspectAndDie($updateProductMetaData);

        $updateProductFeatureData = $sanitizedData['productFeatureData'];
        // inspectAndDie($updateProductFeatureData);

        $updateProductImgGalleryData = $sanitizedData['productImgGalleryData'];

        $this->moveAndUpdateFiles($_FILES, $updateProductImgGalleryData);

        // Update product meta data
        $updateProductMetaFields = implode(', ', array_map(fn ($field) => "{$field} = :{$field}", array_keys($updateProductMetaData)));

        $updateProductMetaData['id'] = $params['id'];
        $this->productModel->update($updateProductMetaFields, $updateProductMetaData);

        // Update features
        if ($product->feature_id) {
          $updateProductFeatureFields = implode(', ', array_map(fn ($field) => "{$field} = :{$field}", array_keys($updateProductFeatureData)));

          $updateProductFeatureData['id'] = $product->feature_id;
          $this->getFeatureModel()->update($updateProductFeatureFields, $updateProductFeatureData);
        }

        // Update product images
        if ($product->image_gallery_id) {
          $updateProductImgGalleryFields = implode(', ', array_map(fn ($field) => "{$field} = :{$field}", array_keys($updateProductImgGalleryData)));

          $updateProductImgGalleryData['id'] = $product->image_gallery_id;
          $this->getProductImageGalleryModel()->update($updateProductImgGalleryFields, $updateProductImgGalleryData);
        }

        $this->db->conn->commit();
        Session::setFlashMessage('success_message', "PRODUCT: <strong>{$product->sku}</strong> UPDATED SUCCESSFULLY");
        redirect(assetPath('admin/product-management'));
      } catch (Exception $e) {
        $this->db->conn->rollBack();
        Session::setFlashMessage('error_message', 'Failed to update product: ' . $e->getMessage());
        loadView('Admin/ProductManagement/edit', [
          'product' => $product,
          'categories' => $categories
        ]);
        exit;
      }
      /*----------------------TRANSACTION ENDS--------------------------------- */
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


    $categories = $this->getCategories();

    $inputProductMetaData = $this->getInputProductMetaData();

    $inputProductFeatureData = $this->getInputProductFeatureData();

    $inputProductImgGalleryData = $this->getInputProductImgGalleryData();


    // VALIDATION
    $errors = $this->validateProductInputData($inputProductMetaData, $inputProductFeatureData, $inputProductImgGalleryData);

    // check if sku exists
    $checkParams = [
      'sku' => trimAndUpperCase($inputProductMetaData['sku'])
    ];
    $productBySkuRow = $this->productModel->getSingleProductBySku($checkParams);

    if ($productBySkuRow) {
      $errors['sku'] = 'The SKU already exists.';
    }

    // Filter out any non-errors
    $errors = array_filter($errors);

    // inspectAndDie($errors);

    if (!empty($errors)) {
      // reload view with errors
      loadView('Admin/ProductManagement/create', [
        'errors' => $errors,
        'productMeta' => $inputProductMetaData,
        'productFeature' => $inputProductFeatureData,
        'productImgGallery' => $inputProductImgGalleryData,
        'categories' => $categories
      ]);
      exit;
    } else {
      /*----------------------TRANSACTION BEGINS--------------------------------- */
      try {
        $this->db->conn->beginTransaction();
        // get sanitized data
        $sanitizedData = $this->sanitizeProductInputData($inputProductMetaData, $inputProductFeatureData, $inputProductImgGalleryData);

        $newProductMetaData = $sanitizedData['productMetaData'];

        $newProductFeatureData = $sanitizedData['productFeatureData'];

        $newProductImgGalleryData = $sanitizedData['productImgGalleryData'];

        $this->moveAndUpdateFiles($_FILES, $newProductImgGalleryData);

        // Insert image gallery data
        $productImgGalleryFields = implode(', ', array_keys($newProductImgGalleryData));
        $productImgGalleryValues = ':' . implode(', :', array_keys($newProductImgGalleryData));
        $this->getProductImageGalleryModel()->insert($productImgGalleryFields, $productImgGalleryValues, $newProductImgGalleryData);
        $newProductMetaData['image_gallery_id'] = $this->productImageGalleryModel->getInsertID();

        // Insert feature data
        $productFeatureFields = implode(', ', array_keys($newProductFeatureData));
        $productFeatureValues = ':' . implode(', :', array_keys($newProductFeatureData));
        $this->getFeatureModel()->insert($productFeatureFields, $productFeatureValues, $newProductFeatureData);
        $newProductMetaData['feature_id'] = $this->featureModel->getInsertID();

        // Insert product meta data
        $productMetaFields = implode(', ', array_keys($newProductMetaData));
        $productMetaValues = ':' . implode(', :', array_keys($newProductMetaData));
        $this->productModel->insert($productMetaFields, $productMetaValues, $newProductMetaData);

        $this->db->conn->commit();
        Session::setFlashMessage('success_message', 'PRODUCT CREATED SUCCESSFULLY');
        redirect(assetPath('admin/product-management'));
      } catch (Exception $e) {
        $this->db->conn->rollBack();
        Session::setFlashMessage('error_message', 'Failed to create product: ' . $e->getMessage());
        loadView('Admin/ProductManagement/create', [
          'productMeta' => $inputProductMetaData,
          'productFeature' => $inputProductFeatureData,
          'productImgGallery' => $inputProductImgGalleryData,
          'categories' => $categories
        ]);
        exit;
      }
      /*----------------------TRANSACTION END--------------------------------- */
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
    // $id = $params['id'];

    // $params = [
    //   'id' => $id
    // ];

    $product = $this->productModel->getSingleProduct($params);

    if (!$product) {
      AdminErrorController::notFound('Category not found');
    } else {
      if ($product->stock_on_hand > 0) {
        Session::setFlashMessage('error_message', "PRODUCT: <strong>{$product->sku}</strong> CANNOT BE DELETED. YOU STILL HAVE $product->stock_on_hand X {$product->sku}.");
        redirect(assetPath('admin/product-management'));
      } else {
        $this->productModel->delete($params);

        // set flash message
        Session::setFlashMessage('success_message', "PRODUCT: <strong>{$product->sku}</strong> DELETED SUCCESSFULLY");
        // $_SESSION['success_message'] = 'PRODUCT DELETED SUCCESSFULLY';

        redirect(assetPath('admin/product-management'));
      }
    }
  }

  /**
   * search product by product sku or name
   * 
   * @return void
   */
  public function search()
  {
    // $term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
    $errors = [];

    $products = $this->productModel->getAllProducts();
    $operators = $this->productModel->setOperators();


    $inputData = filter_input_array(INPUT_GET, [
      'term' => FILTER_DEFAULT,
      'stockOperator' => FILTER_DEFAULT,
      'stockQty' => FILTER_DEFAULT
    ]);

    $errors = [
      'term' => Validation::text('term', trim($inputData['term']), 0, 100, FALSE),
      'stockQty' => Validation::number('stockQty', $inputData['stockQty'], 0, NULL, FALSE),
    ];

    if ($inputData['stockQty'] < 0 && !empty($inputData['stockOperator'])) {
      $errors['stockQty'] = 'Please enter a valid number';
    }
    if ($inputData['stockQty'] >= 0 && empty($inputData['stockOperator'])) {
      $errors['stockOperator'] = 'Please select a operator';
    }

    // Filter out any non-errors
    $errors = array_filter($errors);

    if (!empty($errors)) {
      loadView('Admin/ProductManagement/index', [
        'errors' => $errors,
        'products' => $products,
        'operators' => $operators,
        'inputData' => $inputData
      ]);
      exit;
    } else {
      $term = $inputData['term'];
      $sanitizedInputData = [
        'term' => filter_var(trim($inputData['term']), FILTER_SANITIZE_SPECIAL_CHARS),
        'stockOperator' => filter_var($inputData['stockOperator'], FILTER_SANITIZE_SPECIAL_CHARS),
        'stockQty' => filter_var($inputData['stockQty'], FILTER_SANITIZE_NUMBER_INT),
      ];

      $sanitizedInputData['term'] = "%{$term}%";

      $sanitizedInputData = array_filter($sanitizedInputData, fn ($data) => $data <> '' || $data <> NULL);

      $products = $this->productModel->adminProductSearch($sanitizedInputData);

      $count = count($products);

      loadView('Admin/ProductManagement/index', [
        'products' => $products,
        'term' => $term,
        'count' => $count,
        'operators' => $operators,
        'inputData' => $sanitizedInputData
      ]);
    }
  }
}
