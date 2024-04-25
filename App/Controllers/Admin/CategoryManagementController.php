<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Category;
use Framework\Session;
use Framework\Validation;
use HTMLPurifier;
use HTMLPurifier_Config;

class CategoryManagementController
{
  protected $categoryModel;

  public function __construct()
  {
    $this->categoryModel = new Category();
  }

  private function getInputCategoryData()
  {
    $inputCategoryData = filter_input_array(INPUT_POST, [
      'category_name' => FILTER_DEFAULT,
      'category_desc' => FILTER_DEFAULT,
      'is_active' => FILTER_VALIDATE_BOOLEAN,
      'category_img_alt' => FILTER_DEFAULT,
    ]);

    // Convert Boolean is_active to TINYINT for MySQL
    $inputCategoryData['is_active'] = $inputCategoryData['is_active'] ? 1 : 0;

    return $inputCategoryData;
  }

  private function validateInputCategoryData($inputData)
  {
    $errors = [];
    $errors = [
      'category_name' => Validation::text('Category name', $inputData['category_name'], 2, 50, TRUE),
      'category_desc' => Validation::text('Category description', $inputData['category_desc'], 0, 254, FALSE),
      'category_img_alt' => Validation::text('category_img_alt', $inputData['category_img_alt'], 2, 50, FALSE),
    ];

    // validate images
    foreach ($_FILES as $inputName => $fileInfo) {
      $errors[$inputName] = Validation::validateImage($fileInfo);
    }

    return $errors;
  }

  private function sanitizeCategoryInputData($inputData)
  {
    $sanitizeData = [
      'category_name' => filter_var(trimAndUpperCase($inputData['category_name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS),
      // 'category_desc' => $inputData['category_desc'],
      'category_desc' => $this->purifierTextarea()->purify(trim($inputData['category_desc'])),
      'category_img_alt' => filter_var($inputData['category_img_alt'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
      'is_active' => $inputData['is_active']
    ];

    return $sanitizeData;
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

  private function moveAndUpdateFiles($fileArray, &$categoryData)
  {
    moveFile($fileArray['category_img_path'], 'category_img_path', 'category_img_alt', $categoryData['category_img_alt'], $categoryData, 'uploads/images/');
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
    $products = $this->categoryModel->getAllProductsByCategory($params);

    if (!$category) {
      AdminErrorController::notFound('Category not found');
    } else {
      loadView('Admin/CategoryManagement/show', [
        'category' => $category,
        'products' => $products
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

    // Get input data
    $inputCategoryData = $this->getInputCategoryData();

    // inspectAndDie($inputCategoryData);

    // validate data
    $errors = $this->validateInputCategoryData($inputCategoryData);


    $params = [
      'category_name' => strtoupper(trim($inputCategoryData['category_name']))
    ];
    // check if category name exists
    $categoryByNameRow = $this->categoryModel->getSingleCategoryByName($params);
    if ($categoryByNameRow) {
      $errors['category_name'] = "{$inputCategoryData['category_name']} already exists.";
    }


    // Filter out any non-errors
    $errors = array_filter($errors);

    // inspectAndDie($errors);


    if (!empty($errors)) {
      loadView('Admin/CategoryManagement/create', [
        'errors' => $errors,
        'categoryData' => $inputCategoryData
      ]);
      exit;
    } else {

      // Sanitize data
      $newCategoryData = $this->sanitizeCategoryInputData($inputCategoryData);

      // move file and sanitize image path
      $this->moveAndUpdateFiles($_FILES, $newCategoryData);

      $categoryFields = [];
      $categoryValues = [];


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

    // get the current category data
    $category = $this->categoryModel->getSingleCategory($params);

    // get input data
    $inputCategoryData = $this->getInputCategoryData();

    // validate input data
    $errors = $this->validateInputCategoryData($inputCategoryData);

    // check if input category name already exists
    $categoryByNameIdRow = $this->categoryModel->getSingleCategoryByNameAndId([
      'category_name' => strtoupper($inputCategoryData['category_name']),
      'id' => $category->category_id
    ]);

    if ($categoryByNameIdRow) {
      $errors['category_name'] = "{$inputCategoryData['category_name']} already exists";
    }

    // Filter out any non-errors
    $errors = array_filter($errors);

    if (!empty($errors)) {
      loadView('Admin/CategoryManagement/edit', [
        'errors' => $errors,
        'category' => $category
      ]);
      exit;
    } else {

      // sanitize data
      $updateCategoryData = $this->sanitizeCategoryInputData($inputCategoryData);

      // move file and sanitize path
      $this->moveAndUpdateFiles($_FILES, $updateCategoryData);

      /**----------------SUBMIT DATA START------------------------------------ */
      $updatedCategoryFields = [];


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
