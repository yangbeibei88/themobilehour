<?php

namespace App\Controllers\Admin;

use App\Models\Administrator;
use Framework\Session;
use Framework\Validation;

class AccountController
{
  protected $administratorModel;
  public function __construct()
  {
    $this->administratorModel = new Administrator;
  }


  /**
   * Load admin account login view
   *
   * @return void
   */
  public function login()
  {
    loadView('Admin/Account/login');
  }

  /**
   * Authenticate a admin user login
   *
   * @return void
   */
  public function authenticate()
  {

    $inputData = filter_input_array(INPUT_POST, [
      'email' => FILTER_DEFAULT,
      'password' => FILTER_DEFAULT
    ]);

    $errors = [];

    // VALIDATION
    $errors = [
      'email' => Validation::email('email', $inputData['email'], TRUE),
      'password' => Validation::password($inputData['password'])
    ];

    $errors = array_filter($errors);

    if (!empty($errors)) {
      // if either email or password doesn't comply with validation, display error
      loadView('Admin/Account/login', [
        'errors' => $errors
      ]);
      exit;
    } else {

      $loginData = [
        'email' => filter_var($inputData['email'], FILTER_SANITIZE_EMAIL),
        'password' => $inputData['password']
      ];

      $params = [
        'username' => $loginData['email']
      ];

      $adminUserRow = $this->administratorModel->getSingleUserByEmail($params);

      // if both email and password comply with validation, check if email and password are correct and status is 1
      if (!$adminUserRow || !password_verify($loginData['password'], $adminUserRow->password)) {
        $errors['credentials'] = 'Incorrect credentials';
        loadView('Admin/Account/login', [
          'errors' => $errors
        ]);
        exit;
      } elseif ($adminUserRow && password_verify($loginData['password'], $adminUserRow->password) && $adminUserRow->status == 0) {
        $errors['credentials'] = 'Account disabled, please contact admin manager';
        loadView('Admin/Account/login', [
          'errors' => $errors
        ]);
        exit;
      } elseif ($adminUserRow && password_verify($loginData['password'], $adminUserRow->password) && $adminUserRow->status == 1) {

        // Update session id
        session_regenerate_id(true);

        // set user session
        Session::set('adminUser', [
          'id' => $adminUserRow->user_id,
          'email' => $adminUserRow->username,
          'role' => $adminUserRow->user_role,
          'firstname' => $adminUserRow->firstname,
          'lastname' => $adminUserRow->lastname
        ]);


        redirect(assetPath('admin/dashboard'));
      }
    }
  }

  /**
   * Log out a admin user and kill session
   *
   * @return void
   */
  public function logout()
  {
    // Session::clear('adminUser');
    Session::clearAll();
    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    redirect(assetPath('admin/auth/login'));
  }

  /**
   * show individual admin account
   *
   * @return void
   */
  public function show($params)
  {
    $userId = Session::get('adminUser')['id'];

    $params = [
      'id' => $userId
    ];

    $adminUser = $this->administratorModel->getSingleUserById($params);

    if (!$adminUser) {
      ErrorController::notFound('Admin user not found.');
    } else {
      loadView('Admin/Account/show', [
        'adminUser' => $adminUser
      ]);
    }
  }
  public function edit($params)
  {
    $userId = Session::get('adminUser')['id'];

    $params = [
      'id' => $userId
    ];

    $adminUser = $this->administratorModel->getSingleUserById($params);
    loadView('Admin/Account/edit', [
      'adminUser' => $adminUser
    ]);
  }
  public function update($params)
  {
    $userId = Session::get('adminUser')['id'];

    $params = [
      'id' => $userId
    ];

    $adminUser = $this->administratorModel->getSingleUserById($params);

    $errors = [];

    // Retrieve and filter input data
    $inputData = filter_input_array(INPUT_POST, [
      'firstname' => FILTER_DEFAULT,
      'lastname' => FILTER_DEFAULT,
      'password' => FILTER_DEFAULT,
      'confirmPassword' => FILTER_DEFAULT
    ]);

    // validation
    $errors = [
      'firstname' => Validation::text('firstname', $inputData['firstname'], 2, 50, TRUE),
      'lastname' => Validation::text('lastname', $inputData['lastname'], 2, 50, TRUE),
      'password' => (!empty($inputData['password'])) ? Validation::password($inputData['password']) : null,
      'confirmPassword' => (!empty(filter_input(INPUT_POST, 'confirmPassword'))) ? Validation::verify($inputData['password'], $inputData['confirmPassword']) : null,
    ];

    $errors = array_filter($errors);

    if (!empty($errors)) {
      loadView('Admin/Account/edit', [
        'errors' => $errors,
        'adminUser' => $adminUser
      ]);
      exit;
    } else {
      // proceed data sanitization after all checks
      $updateAdminUserData = [
        'firstname' => filter_var($inputData['firstname'], FILTER_SANITIZE_SPECIAL_CHARS),
        'lastname' => filter_var($inputData['lastname'], FILTER_SANITIZE_SPECIAL_CHARS),
      ];

      // hash password
      if (!empty($inputData['password'])) {
        $updateAdminUserData['password'] = password_hash($inputData['password'], PASSWORD_DEFAULT);
      }

      $updateAdminUserFields = [];

      foreach ($updateAdminUserData as $field => $value) {
        $updateAdminUserFields[] = "{$field} =:{$field}";
      }

      $updateAdminUserFields = implode(', ', $updateAdminUserFields);
      $updateAdminUserData['id'] = $userId;

      // inspectAndDie($updateAdminUserData);

      $this->administratorModel->update($updateAdminUserFields, $updateAdminUserData);

      // set flash message
      Session::setFlashMessage('success_message', "YOU ACCOUNT UPDATED SUCCESSFULLY");

      redirect(assetPath('admin/auth/account/show/' . $userId));
    }
  }
}