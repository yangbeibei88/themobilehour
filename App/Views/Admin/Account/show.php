<?= loadPartial('header', ['pageTitle' => 'My Admin Account']) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'My Admin Account']) ?>
<?= loadPartial('message') ?>

<main id="admin-user-account-show">
  <div class="container-sm my-4">
    <a href="<?= urlPath('admin/dashboard') ?>" class="btn btn-link">Back to dashboard</a>
    <div class="card my-4">
      <div class="card-body">
        <h5 class="card-title">Account Information</h5>
        <table class="table">
          <tbody>
            <tr>
              <th scope="row">First Name: </th>
              <td><?= $adminUser->firstname ?></td>
            </tr>
            <tr>
              <th scope="row">Last Name: </th>
              <td><?= $adminUser->lastname ?></td>
            </tr>
            <tr>
              <th scope="row">Username: </th>
              <td><?= $adminUser->username ?></td>
            </tr>
            <tr>
              <th scope="row">Role: </th>
              <td><?= $adminUser->user_role ?></td>
            </tr>
            <tr>
              <th scope="row">Password: </th>
              <td>******</td>
            </tr>
          </tbody>
        </table>
        <a href="<?= assetPath('admin/auth/account/edit/' . $adminUser->user_id) ?>" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>