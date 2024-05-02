<?= loadPartial('header', ['pageTitle' => 'Admin User Management']) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Admin User Management']) ?>
<?= loadPartial('message') ?>

<main id="account-manager">
  <div class="container my-4">
    <div class="d-flex align-items-center justify-content-end my-4" id="account-manager-top">
      <a href="<?= assetPath('admin/user-management/create') ?>" role="button" class="btn btn-outline-primary">Add New
        Account</a>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Avatar</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Username</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th>
            <th scope="col">Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($adminUsers as $adminUser) : ?>
            <tr>
              <?php if (!$adminUser->avatar) : ?>
                <td>
                  <img src="<?= assetPath('assets/avatars-admin/default-avatar.png') ?>" alt="" class="img-thumbnail" width="50" height="50">
                </td>
              <?php else : ?>
                <td>
                  <img src="<?= assetPath($adminUser->avatar) ?>" alt="<?= $adminUser->firstname ?>" class="img-thumbnail" width="50" height="50">
                </td>
              <?php endif; ?>
              <td><?= $adminUser->firstname ?></td>
              <td><?= $adminUser->lastname ?></td>
              <td><?= $adminUser->username ?></td>
              <td><?= $adminUser->user_role ?></td>
              <td><?= $adminUser->status == 1 ? 'active' : 'inactive' ?></td>
              <td><a href="<?= assetPath('admin/user-management/edit/' . $adminUser->user_id) ?>" class="btn btn-primary btn-sm" role="button">Edit</a></td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>