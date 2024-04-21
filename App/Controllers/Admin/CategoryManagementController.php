<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Category;
use Framework\Session;
use Framework\Validation;

class CategoryManagementController
{
  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new Category();
  }

  /**
   * Show all categories in Categories Management of Admin dashboard
   *
   * @return void
   */
  public function index()
  {
    $categories = $this->categoryModel->productCountByCategory();

    // inspectAndDie($categories);
    loadView('Admin/CategoryManagement/index', [
      'categories' => $categories
    ]);
  }

  public function create()
  {
    loadView('Admin/CategoryManagement/create');
  }

  public function show($params)
  {
    $category = $this->categoryModel->getSingleCategory($params);

    if (!$category) {
      AdminErrorController::notFound('Category not found');
    } else {
      loadView('Admin/CategoryManagement/show', [
        'category' => $category
      ]);
    }
  }

  /**
   * Single category edit form
   *
   * @param array $params
   * @return void
   */
  public function edit($params)
  {
    $category = $this->categoryModel->getSingleCategory($params);
    // inspectAndDie($id);
    // inspectAndDie($category);
    if (!$category) {
      AdminErrorController::notFound('Category not found');
    } else {
      loadView('Admin/CategoryManagement/edit', [
        'category' => $category
      ]);
    }
  }


  /**
   * Store new category to category table
   *
   * @return void
   */
  public function store()
  {
    // capture admin user id
    $userId = Session::get('adminUser')['id'];

    $allowedFields = ['category_name', 'category_desc', 'is_active'];
    $errors = [];

    $newCategoryData = array_intersect_key($_POST, array_flip($allowedFields));

    $excludeSanitizeFields = ["category_desc"];

    // sanatise input data except category_deesc
    $newCategoryData = sanitizeArr($newCategoryData, $excludeSanitizeFields);
    $newCategoryData['is_active'] = isset($_POST['is_active']) ? 1 : 0;


    // validate input data
    $errors['category_name'] = Validation::text('Category name', $newCategoryData['category_name'], 2, 50, TRUE);
    $errors['category_desc'] = Validation::text('Category description', $newCategoryData['category_desc'], 0, 254, FALSE);
    // $errors['category_img_alt'] = Validation::text('Image alt text', $newCategoryData['category_img_alt'], 0, 50, FALSE);

    // validate images
    foreach ($_FILES as $file) {
      $errors[$file['name']] = Validation::validateImage($file);
    }

    // inspectAndDie($newCategoryData);
    // inspectAndDie($errors);

    // inspectAndDie($_FILES);

    $invalid = implode($errors);
    // inspectAndDie($invalid);

    if ($invalid) {
      loadView('Admin/CategoryManagement/create', [
        'errors' => $errors,
        'categoryData' => $newCategoryData
      ]);
      exit;
    } else {

      /*----------------------SUBMIT NEW CATEGORY IMAGE-----------------  */
      $categoryFields = [];
      $categoryValues = [];

      /*---------------------MOVE IMAGE--------------------------*/

      moveFile($_FILES['category_img_path'], 'category_img_path', 'category_img_alt', $_POST['category_img_alt'], $newCategoryData, 'uploads/images/');

      // inspectAndDie($newCategoryData);

      foreach ($newCategoryData as $field => $value) {
        $categoryFields[] = $field;
        $categoryValues[] = ':' . $field;
      }

      // inspectAndDie($ca/tegoryValues);

      $categoryFields = implode(', ', $categoryFields);
      $categoryValues = implode(', ', $categoryValues);

      // inspectAndDie($categoryFields);


      $this->categoryModel->insert($categoryFields, $categoryValues, $newCategoryData);
      Session::setFlashMessage('success_message', 'CATEGORY CREATED SUCCESSFULLY');
      redirect('category-management');
    }
  }

  /**
   * Update a category
   *
   * @param array $params
   * @return void
   */
  public function update($params)
  {
    $userId = Session::get('adminUser')['id'];

    $category = $this->categoryModel->getSingleCategory($params);

    $allowedFields = ['category_name', 'category_desc', 'is_active'];
    $errors = [];

    // $updateCategoryData = array_intersect_key($_POST, array_flip($allowedFields));
    $updateCategoryData = array_intersect_key($_POST, array_flip($allowedFields));

    $excludeSanitizeFields = ["category_desc"];

    // sanatise input data except category_deesc
    $updateCategoryData = sanitizeArr($updateCategoryData, $excludeSanitizeFields);
    $updateCategoryData['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    // $updateCategoryData['is_active'] = $updateCategoryData['is_active'] ? 1 : 0;

    // validate input data
    $errors['category_name'] = Validation::text('Category name', $updateCategoryData['category_name'], 2, 50, TRUE);
    $errors['category_desc'] = Validation::text('Category description', $updateCategoryData['category_desc'], 0, 254, FALSE);
    // validate images
    foreach ($_FILES as $file) {
      $errors[$file['name']] = Validation::validateImage($file);
    }

    $invalid = implode($errors);

    if ($invalid) {
      loadView('Admin/CategoryManagement/edit', [
        'errors' => $errors,
        'category' => $category
      ]);
      exit;
    } else {

      $updatedCategoryFields = [];

      moveFile($_FILES['category_img_path'], 'category_img_path', 'category_img_alt', $_POST['category_img_alt'], $updateCategoryData, 'uploads/images/');

      foreach (array_keys($updateCategoryData) as $field) {
        $updatedCategoryFields[] = "{$field} =:{$field}";
      }

      $updatedCategoryFields = implode(', ', $updatedCategoryFields);

      $updateCategoryData['id'] = $params['id'];

      // inspectAndDie($updateCategoryData);

      $this->categoryModel->update($updatedCategoryFields, $updateCategoryData);

      Session::setFlashMessage('success_message', "CATEGORY: <strong>{$updateCategoryData['category_name']}</strong>  UPDATED SUCCESSFULLY");

      redirect(assetPath('admin/category-management'));
    }
  }

  /**
   * Delete a category
   *
   * @param array $params
   * @return void
   */
  public function delete($params)
  {
    $category = $this->categoryModel->getSingleCategory($params);

    if (!$category) {
      AdminErrorController::notFound('Category not found');
    } else {
      loadView('Admin/CategoryManagement/delete', [
        'category' => $category
      ]);
    }
  }

  /**
   * Delete a category
   *
   * @param array $params
   * @return void
   */
  public function destroy($params)
  {
    // $category = $this->categoryModel->getSingleCategory($params);
    $category = $this->categoryModel->getSingleCategoryCount($params);
    // inspectAndDie($category);
    if (!$category) {
      AdminErrorController::notFound('Category not found');
    } else {
      if ($category->productCount > 0) {
        Session::setFlashMessage('error_message', "CATEGORY: <strong>{$category->category_name}</strong> contains products that must be deleted before you can delete the category.");

        redirect(assetPath('admin/category-management'));
      } else {
        $this->categoryModel->delete($params);

        Session::setFlashMessage('success_message', "CATEGORY: <strong>{$category->category_name}</strong> DELETED SUCCESSFULLY");

        redirect(assetPath('admin/category-management'));
      }
    }
  }
}
