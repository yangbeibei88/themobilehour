<?php

namespace App\Controllers\Admin;

use App\Models\Category;

class CategoryManagementController
{
  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new Category();
  }

  public function index()
  {
    $categories = $this->categoryModel->getAllCategories();
    loadView('Admin/CategoryManagement/index', [
      'categories' => $categories
    ]);
  }
}
