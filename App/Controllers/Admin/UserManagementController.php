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

  private function getAdminUserInputData()
  {
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

    return $inputData;
  }

  private function validateAdminUserInputData($inputData, $action)
  {
    $errors = [];
    $errors = [
      'firstname' => Validation::text('firstname', $inputData['firstname'], 2, 50, TRUE),
      'lastname' => Validation::text('lastname', $inputData['lastname'], 2, 50, TRUE),
      'username' => Validation::email('username', $inputData['username'], TRUE),
    ];

    //   'password' => (!empty($inputData['password'])) ? Validation::password($inputData['password']) : null,
    //   'confirmPassword' => (!empty(filter_input(INPUT_POST, 'confirmPassword'))) ? Validation::verify($inputData['password'], $inputData['confirmPassword']) : null,

    if ($action === 'create') {
      $errors['password'] = Validation::password($inputData['password'], TRUE);
      $errors['confirmPassword'] = Validation::verify($inputData['password'], $inputData['confirmPassword']);
    } elseif ($action === 'update') {
      $errors['password'] = Validation::password($inputData['password'], FALSE);
      $errors['confirmPassword'] = Validation::verify($inputData['password'], $inputData['confirmPassword']);
    }


    return $errors;
  }

  private function sanitizeAdminUserInputData($inputData)
  {
    $trimmedInputData = trimAndConvertNumericValues($inputData);
    $sanitizeData = [
      'firstname' => filter_var($trimmedInputData['firstname'], FILTER_SANITIZE_SPECIAL_CHARS),
      'lastname' => filter_var($trimmedInputData['lastname'], FILTER_SANITIZE_SPECIAL_CHARS),
      'username' => filter_var(strtolower($trimmedInputData['username']), FILTER_SANITIZE_EMAIL),
      'status' => $trimmedInputData['status'],
    ];

    return $sanitizeData;
  }

  private function sanitizePasswordInput($password)
  {
    $password = trim($password);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
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

  public function create()
  {
    loadView('Admin/UserManagement/create');
  }


  public function edit($params)
  {
    $adminUser = $this->administratorModel->getSingleUserById($params);
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

    // Retrieve and filter input data
    $inputAdminUserData = $this->getAdminUserInputData();

    // Validate data
    $errors = $this->validateAdminUserInputData($inputAdminUserData, 'create');

    // check if email exists
    $params = [
      'username' => trimAndLowerCase($inputAdminUserData['username'])
    ];

    $adminUserRow = $this->administratorModel->getSingleUserByEmail($params);

    if ($adminUserRow) {
      $errors['username'] = 'This email/username you entered already exists.';
    }

    // inspectAndDie($errors);

    // Filter out any non-errors
    $errors = array_filter($errors);

    if (!empty($errors)) {
      loadView('Admin/UserManagement/create', [
        'errors' => $errors,
        'adminUser' => $inputAdminUserData
      ]);
      exit;
    } else {

      // sanitize data
      $adminUser = $this->sanitizeAdminUserInputData($inputAdminUserData);

      // hash password
      $adminUser['password'] = $this->sanitizePasswordInput($inputAdminUserData['password']);


      $adminUserFields = [];
      $adminUserValues = [];

      foreach ($adminUser as $key => $value) {
        $adminUserFields[] = $key;
        $adminUserValues[] = ':' . $key;
      }

      $adminUserFields = implode(', ', $adminUserFields);
      $adminUserValues = implode(', ', $adminUserValues);

      // inspectAndDie($adminUserValues);
      // inspectAndDie($adminUserFields);

      // inspectAndDie($adminUser);

      $this->administratorModel->insert($adminUserFields, $adminUserValues, $adminUser);


      // set flash message
      Session::setFlashMessage('success_message', "ADMIN USER <strong>{$adminUser['username']}</strong> UPDATED SUCCESSFULLY");

      redirect('user-management');
    }
  }

  /**
   * Update new admin user in database
   *
   * @return void
   */
  public function update($params)
  {

    // inspectAndDie($prams);

    // get current user data
    $adminUser = $this->administratorModel->getSingleUserById($params);

    // Retrieve and filter input data
    $inputAdminUserData = $this->getAdminUserInputData();

    // validation
    $errors = $this->validateAdminUserInputData($inputAdminUserData, 'update');

    // check if email exists
    $checkParams = [
      'username' => trimAndLowerCase($inputAdminUserData['username']),
      'id' => $adminUser->user_id          // exclude the updating user id
    ];

    // inspectAndDie($params);

    $adminUserRow = $this->administratorModel->getSingleUserByEmailAndId($checkParams);

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
      $updateAdminUserData = $this->sanitizeAdminUserInputData($inputAdminUserData);

      // hash password, only hash if it's not empty
      if (!empty(trim($inputAdminUserData['password']))) {
        $updateAdminUserData['password'] = $this->sanitizePasswordInput($inputAdminUserData['password']);
      }

      $updateAdminUserFields = [];

      foreach ($updateAdminUserData as $field => $value) {
        $updateAdminUserFields[] = "{$field} =:{$field}";
      }

      $updateAdminUserFields = implode(', ', $updateAdminUserFields);
      $updateAdminUserData['id'] = $params['id'];


      // inspectAndDie($updateAdminUserData);
      // inspectAndDie($updateAdminUserFields);

      $this->administratorModel->update($updateAdminUserFields, $updateAdminUserData);

      // set flash message
      Session::setFlashMessage('success_message', "ADMIN USER <strong>{$updateAdminUserData['username']}</strong> UPDATED SUCCESSFULLY");

      redirect(assetPath('admin/user-management'));
    }
  }
}
