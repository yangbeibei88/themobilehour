<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController
{
  // create DI container and use the constructor promotion if I have time to refactor
  // public function __construct(protected Category $model)
  // {
  // }

  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new Category();
  }

  /**
   * site public home page, display all categories
   *
   * @return void
   */
  public function index()
  {

    $categories = $this->categoryModel->getAllActiveCategories();


    loadView('Home/index', [
      'categories' => $categories
    ]);
  }
}
