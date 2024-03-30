<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController
{
  // create DI container and use the constructor promotion if I have time to refactor
  // public function __construct(protected Category $model)
  // {
  // }

  protected $model;

  public function __construct()
  {
    $this->model = new Category();
  }

  /**
   * site public home page, display all categories
   *
   * @return void
   */
  public function index()
  {

    $categories = $this->model->getAllCategories();


    loadView('Home/index', [
      'categories' => $categories
    ]);
  }
}
