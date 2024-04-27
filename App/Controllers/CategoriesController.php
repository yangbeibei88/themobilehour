<?php

namespace App\Controllers;

use App\Models\Category;

class CategoriesController
{
  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new Category();
  }

  /**
   * Show all categories
   *
   * @return void
   */
  public function index()
  {
    $categories = $this->categoryModel->getAllActiveCategories();


    loadView('Categories/index', [
      'categories' => $categories,
    ]);
  }

  public function show($params)
  {
    $category = $this->categoryModel->getSingleCategory($params);
    $products = $this->categoryModel->getAllActiveProductsByCategory($params);
    $storages = $this->categoryModel->getStoragesbyCategory($params);
    $screensizes = $this->categoryModel->getScreensizeByCategory($params);
    $priceRanges = $this->categoryModel->getProductCountPriceRangesByCategory($params);
    $sorts = $this->categoryModel->setProductSortsByCategory();
    // $resolutions = $this->categoryModel->getResolutionByCategory($params);

    // inspectAndDie($category);

    if (!$category) {
      ErrorController::notFound('Category not found');
    } else {
      loadView('Categories/show', [
        'category' => $category,
        'products' => $products,
        'storages' => $storages,
        'screensizes' => $screensizes,
        'priceRanges' => $priceRanges,
        'sorts' => $sorts
        // 'resolutions' => $resolutions
      ]);
    }
  }

  public function filter($params)
  {
    $id = $params['id'];
    $params = ['id' => $id];
    $category = $this->categoryModel->getSingleCategory($params);
    $storages = $this->categoryModel->getStoragesbyCategory($params);
    $screensizes = $this->categoryModel->getScreensizeByCategory($params);
    $priceRanges = $this->categoryModel->getProductCountPriceRangesByCategory($params);
    $sorts = $this->categoryModel->setProductSortsByCategory();

    $args = [
      'storage' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags'  => FILTER_FLAG_ALLOW_FRACTION | FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
      ],
      'screensize' => [
        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY
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
    $inputData['storage'] = $inputData['storage'] ?? [];
    $inputData['screensize'] = $inputData['screensize'] ?? [];
    $inputData['priceRange'] = $inputData['priceRange'] ?? [];
    $inputData['sortBy'] = $inputData['sortBy'] ?? [];
    $inputData['id'] = $id;

    $products = $this->categoryModel->getCategoryFilterProducts($inputData);

    // inspectAndDie($inputData);

    loadView('Categories/show', [
      'category' => $category,
      'products' => $products,
      'screensizes' => $screensizes,
      'priceRanges' => $priceRanges,
      'storages' => $storages,
      'sorts' => $sorts
    ]);
  }
}
