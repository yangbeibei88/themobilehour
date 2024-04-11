<?= loadPartial('header', ['pageTitle' => 'Admin Dashboard']) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Admin Dashboard']) ?>
<main id="admin-dash">
  <div class="container my-4">
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
        <a href="<?= assetPath('admin/user-management') ?>" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Admin
                Management</h2>
              <p class="card-text">Manage admin
                users</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= assetPath('admin/product-management') ?>" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Product
                Management</h2>
              <p class="card-text">Manage
                products</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= assetPath('admin/category-management') ?>" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Category
                Management</h2>
              <p class="card-text">Manage
                categories</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="#" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Customer
                Management</h2>
              <p class="card-text">Manage
                customers</p>
            </div>
          </div>
        </a>
      </div>


      <div class="col">
        <a href="#" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Order
                Management</h2>
              <p class="card-text">Manage
                orders</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col">
        <a href="<?= assetPath('admin/changelogs') ?>" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
          <div class="card shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="card-body">
              <h2 class="card-title fs-5">
                Changelogs
              </h2>
              <p class="card-text">Check
                changelogs</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>