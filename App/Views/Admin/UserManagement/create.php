<?= loadPartial('header', ['pageTitle' => 'Add New Admin User']) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Add New Admin User']) ?>

<main id="add-admin-account">
  <div class="container my-4">
    <form action="/themobilehour/admin/user-management" method="POST" class="row row-cols-1 flex-column g-2 align-items-center justify-content-center" novalidate id="create-admin-form">
      <!-- <?php if (isset($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?> -->
      <div class="col-12 col-md-8 col-lg-6">
        <label for="firstname" class="form-label">First
          Name</label>
        <input type="text" name="firstname" id="firstname" class="form-control <?= !empty($errors['firstname']) ? 'is-invalid' : '' ?>" value="<?= $adminUser['firstname'] ?? '' ?>">
        <div class="text-danger"><?= $errors['firstname'] ?? '' ?></div>
      </div>
      <div class="col-12 col-md-8 col-lg-6">
        <label for="lastname" class="form-label">Last
          Name</label>
        <input type="text" name="lastname" id="lastname" class="form-control <?= !empty($errors['lastname']) ? 'is-invalid' : '' ?>" value="<?= $adminUser['lastname'] ?? '' ?>">
        <div class="text-danger"><?= $errors['lastname'] ?? '' ?></div>
      </div>
      <div class="col-12 col-md-8 col-lg-6">
        <label for="username" class="form-label">Email</label>
        <input type="email" name="username" id="username" class="form-control <?= !empty($errors['username']) ? 'is-invalid' : '' ?>" value="<?= $adminUser['username'] ?? '' ?>">
        <div class="text-danger"><?= $errors['username'] ?? '' ?></div>
      </div>
      <div class="col-12 col-md-8 col-lg-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" value="<?= $adminUser['password'] ?? '' ?>">
        <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
      </div>
      <div class="col-12 col-md-8 col-lg-6">
        <label for="confirmPassword" class="form-label">Confirm
          Password</label>
        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control <?= !empty($errors['password_verify']) ? 'is-invalid' : '' ?>">
        <div class="text-danger"><?= $errors['confirmPassword'] ?? '' ?></div>
      </div>
      <div class="col-12 col-md-8 col-lg-6 form-check form-switch">
        <label for="status" class="form-check-label">Enable this
          user</label>
        <input type="checkbox" name="status" id="status" class="form-check-input" role="switch" value="1" <?= isset($adminUser['status']) && $adminUser['status'] == 1 ? 'checked' : '' ?>>
      </div>
      <div class="col-12 col-md-8 col-lg-6 my-4">
        <input type="submit" value="Add Admin User" name="submit" class="btn btn-primary">
        <a href="<?= assetPath('admin/user-management') ?>" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</main>