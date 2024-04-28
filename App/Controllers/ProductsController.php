<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Validation;

class ProductsController
{

  protected $productModel;

  public function __construct()
  {
    $this->productModel = new Product();
  }


  /**
   * Show all products
   *
   * @return void
   */
  public function index()
  {
    $products = $this->productModel->getAllActiveProducts();
    $categories = $this->productModel->getActiveProductCountByCategory();
    $storages = $this->productModel->getActiveProductCountByStorage();
    $priceRanges = $this->productModel->getProductCountPriceRanges();
    $sorts = $this->productModel->setProductSorts();
    // inspect($priceRanges);
    // inspect($products);
    // $products = $db->query("SELECT * FROM product")->fetchAll();

    if (!$products) {
      ErrorController::notFound('Products not found');
    } else {
      loadView('Products/index', [
        'products' => $products,
        'categories' => $categories,
        'storages' => $storages,
        'priceRanges' => $priceRanges,
        'sorts' => $sorts
      ]);
    }
  }


  public function show($params)
  {
    $product = $this->productModel->getSingleActiveProduct($params);

    if (!$product) {
      ErrorController::notFound('Product not found');
    } else {

      loadView('Products/show', [
        'product' => $product
      ]);
    }
  }

  /**
   * Search product by SKU or product name
   *
   * @return void
   */
  public function search()
  {
    // inspect($_GET);
    $categories = $this->productModel->getActiveProductCountByCategory();
    $storages = $this->productModel->getActiveProductCountByStorage();
    $priceRanges = $this->productModel->getProductCountPriceRanges();
    $sorts = $this->productModel->setProductSorts();

    $term = filter_input(INPUT_GET, 'term', FILTER_DEFAULT);

    $errors = [];

    // VALIDATE SEARCH INPUT TERM
    $errors['term'] = Validation::text('term', $term, 0, 50, FALSE);

    // Filter out any non-errors
    // $errors = array_filter($errors);

    // Sanitize
    $term = filter_var(trimAndLowerCase($term), FILTER_SANITIZE_SPECIAL_CHARS);

    $params = [
      'product_is_active' => 1,
      'term' => "%{$term}%"
    ];

    $products = $this->productModel->publicProductSearch($params);

    $count = count($products);

    loadView('products/index', [
      'products' => $products,
      'term' => $term,
      'count' => $count,
      'categories' => $categories,
      'storages' => $storages,
      'priceRanges' => $priceRanges,
      'sorts' => $sorts
    ]);
  }

  public function filter()
  {
    // inspectAndDie($_GET);
    $categories = $this->productModel->getActiveProductCountByCategory();
    $storages = $this->productModel->getActiveProductCountByStorage();
    $priceRanges = $this->productModel->getProductCountPriceRanges();
    $sorts = $this->productModel->setProductSorts();

    $args = [
      'category_id' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags'  => FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
      ],
      'storage' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags'  => FILTER_FLAG_ALLOW_FRACTION | FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
      ],
      'priceRange' => [
        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
      ],
      'sortBy' => [
        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
      ],
    ];

    $inputData = filter_input_array(INPUT_GET, $args);

    // Check and use the filtered data
    // Ensure both category_id and storage are set and are arrays
    $inputData['category_id'] = $inputData['category_id'] ?? [];
    $inputData['storage'] = $inputData['storage'] ?? [];
    $inputData['priceRange'] = $inputData['priceRange'] ?? [];
    $inputData['sortBy'] = $inputData['sortBy'] ?? [];


    $products = $this->productModel->getPublicFilterProducts($inputData);

    // inspectAndDie($inputData);

    loadView('products/index', [
      'products' => $products,
      'categories' => $categories,
      'storages' => $storages,
      'priceRanges' => $priceRanges,
      'sorts' => $sorts
    ]);
  }
}
