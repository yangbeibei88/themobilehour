<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Administrator;
use Framework\Validation;

class UserManagementController
{
  protected $administratorModel;

  public function __construct()
  {
    $this->administratorModel = new Administrator();
  }

  /**
   * Display all admin users
   *
   * @return void
   */
  public function index()
  {
    $adminUsers = $this->administratorModel->getAllUsers();

    if (!$adminUsers) {
      AdminErrorController::notFound();
    } else {
      loadView('Admin/UserManagement/index', [
        'adminUsers' => $adminUsers
      ]);
    }
  }

  public function show()
  {
    loadView('Admin/UserManagement/show');
  }

  public function create()
  {
    loadView('Admin/UserManagement/create');
  }
  public function edit()
  {
    loadView('Admin/UserManagement/edit');
  }

  /**
   * Store new admin user in database
   *
   * @return void
   */
  public function store()
  {
    $adminUser = [];
    $errors = [];

    $adminUser['firstname'] = $_POST['firstname'];
    $adminUser['lastname'] = $_POST['lastname'];
    $adminUser['username'] = $_POST['username'];
    $adminUser['password'] = $_POST['password'];
    $adminUser['status'] = isset($_POST['status']) ? 1 : 0;
    $confirmPassword = $_POST['confirmPassword'];
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //   $adminUser['status'] = isset($_POST['status']) ? 1 : 0;
    // }

    // Validate first name
    if (!Validation::isString($adminUser['firstname'], 2, 50)) {
      $errors['firstname'] = 'First name must be between 2 and 50 characters.';
    }

    // Validate last name
    if (!Validation::isString($adminUser['lastname'], 2, 50)) {
      $errors['lastname'] = 'Last name must be between 2 and 50 characters.';
    }

    // Validate email
    if (!Validation::isEmail($adminUser['username'])) {
      $errors['username'] = 'Please enter a valid email address';
    }

    // check if email exists
    $params = [
      'username' => $adminUser['username']
    ];

    $adminUserRow = $this->administratorModel->getSingleUser($params);

    if ($adminUserRow) {
      $errors['username'] = 'This email/username already exists.';
    }

    // Validate password
    if (!Validation::isPassword($adminUser['password'])) {
      $errors['password'] = 'Your password must be at least 8 characters and must contains uppercase, lowercase, number and special characters.';
    }

    // validate password match
    if (!Validation::isMatch($adminUser['password'], $confirmPassword)) {
      $errors['password_verify'] = 'Passwords do not match.';
    }

    // inspectAndDie($errors);
    // inspectAndDie($adminUser);

    if (!empty($errors)) {
      loadView('Admin/UserManagement/create', [
        'errors' => $errors,
        'adminUser' => $adminUser
      ]);
      exit;
    } else {
      // create user account

      // hash password
      $adminUser['password'] = password_hash($adminUser['password'], PASSWORD_DEFAULT);

      $adminUserFields = implode(', ', array_keys($adminUser));

      $adminUserValues = [];
      foreach ($adminUser as $key => $value) {
        $adminUserValues[] = ':' . $key;
      }
      $adminUserValues = implode(', ', $adminUserValues);

      // inspectAndDie($adminUserValues);
      // inspectAndDie($adminUserFields);

      // inspectAndDie($adminUser);

      $this->administratorModel->insert($adminUserFields, $adminUserValues, $adminUser);

      // set flash message
      $_SESSION['success_message'] = 'ADMIN USER CREATED SUCCESSFULLY';

      redirect('user-management');
    }
  }
}
