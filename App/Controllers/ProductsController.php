<?php

namespace App\Controllers;

use App\Models\Product;

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
    // inspect($products);
    // $products = $db->query("SELECT * FROM product")->fetchAll();

    if (!$products) {
      ErrorController::notFound('Products not found');
    } else {
      loadView('Products/index', [
        'products' => $products
      ]);
    }
  }

  /**
   * Show a single product on public, only display is_active=1
   *
   * @param array $params
   * @return void
   */
  // public function show($params)
  // {

  //   // $id = $_GET['id'] ?? '';
  //   $id = $params['id'] ?? '';

  //   inspect($id);

  //   $params = [
  //     'id' => $id
  //   ];
  //   $product = $this->productModel->getSingleProduct($params);

  //   if (!$product) {
  //     ErrorController::notFound('Product not found');
  //   } else {

  //     loadView('Products/show', [
  //       'product' => $product
  //     ]);
  //   }
  // }
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
}
