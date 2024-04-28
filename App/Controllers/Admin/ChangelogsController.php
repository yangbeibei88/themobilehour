<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Changelog;

class ChangelogsController
{
  protected $changelogModel;

  public function __construct()
  {
    $this->changelogModel = new Changelog();
  }

  public function index()
  {
    $changelogs = $this->changelogModel->getAllChangelogs();
    $users = $this->changelogModel->getDistinctUsers();
    inspect($users);

    if (!$changelogs) {
      AdminErrorController::notFound('Changelogs not found');
    } else {
      loadView('Admin/Changelogs/index', [
        'changelogs' => $changelogs,
        'users' => $users
      ]);
    }
  }

  public function filter()
  {
    $changelogs = $this->changelogModel->getAllChangelogs();
    $users = $this->changelogModel->getDistinctUsers();

    $errors = [];
    $inputData = filter_input_array(
      INPUT_GET,
      [
        'admin_user' => FILTER_VALIDATE_INT,
        'product_term' => FILTER_DEFAULT,
        'dateFrom' => FILTER_DEFAULT,
        'dateTo' => FILTER_DEFAULT,
      ]
    );

    if ($inputData['dateTo'] < $inputData['dateFrom']) {
      $errors['date'] = 'End date must be equal to or later than start date';
      loadView('Admin/Changelogs/index', [
        'errors' => $errors,
        'changelogs' => $changelogs,
        'users' => $users,
        'filterInputData' => $inputData,
      ]);
      exit;
    } else {

      // Create sanitizedInputData array excluding empty values
      $sanitizedInputData = [];
      $product_term = $inputData['product_term'];
      if (!empty($inputData['admin_user'])) {
        $sanitizedInputData['admin_user'] = filter_var($inputData['admin_user'], FILTER_SANITIZE_NUMBER_INT);
      }
      if (!empty($inputData['product_term'])) {
        $product_term = filter_var(trimAndUpperCase($inputData['product_term']), FILTER_SANITIZE_SPECIAL_CHARS);
        $sanitizedInputData['product_term'] = "%{$product_term}%";
      }
      if (!empty($inputData['dateFrom'])) {
        $sanitizedInputData['dateFrom'] = filter_var($inputData['dateFrom'], FILTER_SANITIZE_SPECIAL_CHARS);
      }
      if (!empty($inputData['dateTo'])) {
        $sanitizedInputData['dateTo'] = filter_var($inputData['dateTo'], FILTER_SANITIZE_SPECIAL_CHARS);
      }

      // inspectAndDie($sanitizedInputData);

      $changelogs = $this->changelogModel->getFilterResults($sanitizedInputData);

      loadView('Admin/Changelogs/index', [
        'changelogs' => $changelogs,
        'users' => $users,
        'filterInputData' => $sanitizedInputData,
        'product_term' => $product_term
      ]);
    }
  }
}
