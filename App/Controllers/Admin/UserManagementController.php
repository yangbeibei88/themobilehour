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

  public function login()
  {
    loadView('Admin/UserManagement/login');
  }

  /**
   * Authenticate a admin user login
   *
   * @return void
   */
  public function authenticate()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    // check if entered email address complies with validation
    if (!Validation::isEmail($email)) {
      $errors['email'] = 'Please enter a valid email';
    }

    // check if entered password complies with validation
    if (!Validation::isPassword($password)) {
      $errors['password'] = 'Passwords must be at least 8 characters and have:<br> 
      at least one lowercase letter;<br>and at least one uppercase letter;<br>and at least one number; 
      <br>and at least one special character.';
    }


    if (!empty($errors)) {
      // if either email or password doesn't comply with validation, display error
      loadView('Admin/UserManagement/login', [
        'errors' => $errors
      ]);
      exit;
    } else {

      $params = [
        'username' => $email
      ];

      $adminUserRow = $this->administratorModel->getSingleUser($params);

      // if both email and password comply with validation, check if email and password are correct and status is 1
      if (!$adminUserRow || !password_verify($password, $adminUserRow->password)) {
        $errors['credentials'] = 'Incorrect credentials';
        loadView('Admin/UserManagement/login', [
          'errors' => $errors
        ]);
        exit;
      } elseif ($adminUserRow && password_verify($password, $adminUserRow->password) && $adminUserRow->status == 0) {
        $errors['credentials'] = 'Account disabled, please contact admin manager';
        loadView('Admin/UserManagement/login', [
          'errors' => $errors
        ]);
        exit;
      } elseif ($adminUserRow && password_verify($password, $adminUserRow->password) && $adminUserRow->status == 1) {
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
}
