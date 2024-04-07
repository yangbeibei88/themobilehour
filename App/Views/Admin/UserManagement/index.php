<?= loadPartial('header', ['pageTitle' => 'Admin User Management']) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Admin User Management']) ?>

<main id="account-manager">
  <div class="container my-4">
    <div class="d-flex align-items-center justify-content-between" id="account-manager-top">
      <form class="d-flex" role="search">
        <input type="search" name="admin-account-search" id="admin-account-search" placeholder="Search" aria-label="Search" class="form-control me-2">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
      <a href="<?= assetPath('admin/user-management/create') ?>" role="button" class="btn btn-outline-primary">Add New
        Account</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Avatar</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Username</th>
          <th scope="col">Role</th>
          <th scope="col">Status</th>
          <th scope="col">View</th>
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
            <td><?= $adminUser->status ?></td>
            <td><a href="#" class="btn btn-secondary btn-sm" role="button">View</a></td>
            <td><a href="#" class="btn btn-primary btn-sm" role="button">Edit</a></td>
          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>
</main>