<?= loadPartial('header', ['pageTitle' => 'Admin Login']) ?>
<?= loadPartial('navbar') ?>
<main id="admin-login">
  <div class="container my-4">
    <div class="card">
      <div class="card-header text-center">
        <h2>Admin Login</h2>
      </div>
      <div class="card-body">
        <div class="text-danger text-center"><?= $errors['credentials'] ?? '' ?></div>

        <form action="<?= urlPath('admin/auth/login') ?>" method="POST" class="row g-3 flex-column align-items-center justify-content-center" id="admin-login-form" novalidate>
          <div class="col-12 col-md-6">
            <label for="email" class="form-label">Username (Email)</label>
            <input type="email" name="email" id="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>">
            <div class="text-danger"><?= $errors['email'] ?? '' ?></div>
          </div>
          <div class="col-12 col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>">
            <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
          </div>
          <div class="col-12 col-md-6 my-4">
            <button type="submit" class="btn btn-primary d-block w-100">Login</button>
          </div>
        </form>

      </div>
      <div class="card-footer">
        <div class="row g-3 flex-column align-items-center justify-content-center">
          <div class="col-12 col-md-6">
            <a href="#">Forgot password?</a>
          </div>
        </div>
      </div>
    </div>


  </div>
</main>
<?= loadPartial('footer') ?>