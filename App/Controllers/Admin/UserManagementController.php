<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\ErrorController as AdminErrorController;
use App\Models\Administrator;
use Framework\Session;
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
  public function edit($id)
  {
    $adminUser = $this->administratorModel->getSingleUserById($id);
    if (!$adminUser) {
      AdminErrorController::notFound('Admin User not found');
    } else {
      loadView('Admin/UserManagement/edit', [
        'adminUser' => $adminUser
      ]);
    }
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

    $adminUserRow = $this->administratorModel->getSingleUserByEmail($params);

    if ($adminUserRow) {
      $errors['username'] = 'This email/username already exists.';
    }

    // Validate password
    if (!Validation::isPassword($adminUser['password'])) {
      $errors['password'] = 'Your password must be at least 8 characters and must contains uppercase, lowercase, number and special characters.';
    }

    // validate password match
    if (!Validation::isMatch($adminUser['password'], $confirmPassword)) {
      $errors['confirmPassword'] = 'Passwords do not match.';
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

  /**
   * Update new admin user in database
   *
   * @return void
   */
  public function update($id)
  {

    // inspectAndDie($id);

    // inspectAndDie($id);
    $adminUser = $this->administratorModel->getSingleUserById($id);

    $errors = [];
    // $allowedFields = ['firstname', 'lastname', 'username', 'password', 'status'];

    // Retrieve and filter input data
    $inputData = filter_input_array(INPUT_POST, [
      'firstname' => FILTER_DEFAULT,
      'lastname' => FILTER_DEFAULT,
      'username' => FILTER_DEFAULT,
      'password' => FILTER_DEFAULT,
      'status' => FILTER_VALIDATE_BOOLEAN,
      'confirmPassword' => FILTER_DEFAULT
    ]);

    // Convert Boolean status to TINYINT for MySQL
    $inputData['status'] = $inputData['status'] ? 1 : 0;

    // inspectAndDie($updateAdminUserData['username']);


    // validation
    $errors = [
      'firstname' => Validation::text('firstname', $inputData['firstname'], 2, 50, TRUE),
      'lastname' => Validation::text('lastname', $inputData['lastname'], 2, 50, TRUE),
      'username' => Validation::email('username', $inputData['username'], TRUE),
      'password' => (!empty($inputData['password'])) ? Validation::password($inputData['password']) : null,
      'confirmPassword' => (!empty(filter_input(INPUT_POST, 'confirmPassword'))) ? Validation::verify($inputData['password'], $inputData['confirmPassword']) : null,
    ];

    // check if email exists
    $params = [
      'username' => $inputData['username'],
      'id' => $id['id']           // Extracting the 'id' from the array
    ];

    // inspectAndDie($params);

    $adminUserRow = $this->administratorModel->getSingleUserByEmailAndId($params);

    // inspectAndDie($adminUserRow);

    if ($adminUserRow) {
      $errors['username'] = 'This email/username already exists.';
    }

    // Filter out any non-errors
    $errors = array_filter($errors);

    // inspectAndDie($errors);

    if (!empty($errors)) {
      loadView('Admin/UserManagement/edit', [
        'errors' => $errors,
        'adminUser' => $adminUser
      ]);
      exit;
    } else {

      // proceed data sanitization after all checks
      $updateAdminUserData = [
        'firstname' => filter_var($inputData['firstname'], FILTER_SANITIZE_SPECIAL_CHARS),
        'lastname' => filter_var($inputData['lastname'], FILTER_SANITIZE_SPECIAL_CHARS),
        'username' => filter_var($inputData['username'], FILTER_SANITIZE_EMAIL),
        'status' => $inputData['status'] // already converted to 0 or 1
      ];

      // inspectAndDie('success');
      // create user account

      // hash password
      if (!empty($inputData['password'])) {
        $updateAdminUserData['password'] = password_hash($inputData['password'], PASSWORD_DEFAULT);
      }

      $updateAdminUserFields = [];

      foreach ($updateAdminUserData as $field => $value) {
        $updateAdminUserFields[] = "{$field} =:{$field}";
      }

      $updateAdminUserFields = implode(', ', $updateAdminUserFields);
      $updateAdminUserData['id'] = $id['id'];


      // inspectAndDie($updateAdminUserData);
      // inspectAndDie($updateAdminUserFields);

      $this->administratorModel->update($updateAdminUserFields, $updateAdminUserData);

      // set flash message
      Session::setFlashMessage('success_message', "ADMIN USER <strong>{$updateAdminUserData['username']}</strong> UPDATED SUCCESSFULLY");

      redirect(assetPath('admin/user-management'));
    }
  }
}
