<?= loadPartial('header', [
  'pageTitle' => 'Product Changelog'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Product Changelog'
]) ?>

<main id="changelogs">
  <div class="container my-4">
    <form class="row row-cols-1 row-cols-md-4 border rounded bg-body-tertiary py-4" id="changelogs-top">
      <div class="col col-md-3">
        <input type="text" name="admin-changeloguser-search" id="admin-changeloguser-search" placeholder="Search by user" aria-label="Search by user" class="form-control me-2">
      </div>
      <div class="col col-md-3">
        <input type="text" name="admin-changelogproduct-search" id="admin-changelogproduct-search" placeholder="Search by product" aria-label="Search by product" class="form-control me-2">
      </div>
      <div class="col col-md-3">
        <input type="date" name="admin-changelogDatefrom-search" id="admin-changelogDatefrom-search" placeholder="Date from" aria-label="Date from" class="form-control me-2">
      </div>
      <div class="col col-md-3">
        <input type="date" name="admin-changelogDateto-search" id="admin-changelogDateto-search" placeholder="Date to" aria-label="Date to" class="form-control me-2">
      </div>
      <div class="col col-md-3 my-2">
        <input type="submit" value="Search" name="search" class="btn btn-primary">
      </div>

    </form>
    <table class="table my-4" id="admin-order-list">
      <thead>
        <tr>
          <th scope="col">Date created</th>
          <th scope="col">Created by</th>
          <th scope="col">Product</th>
          <th scope="col">Date Modified</th>
          <th scope="col">Modified by</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($changelogs as $changelog) : ?>
          <tr>
            <td><?= $changelog->date_created ?></td>
            <td><?= $changelog->created_by ?></td>
            <td><a href="<?= assetPath('admin/product-management/show/' . $changelog->product_id) ?>"><?= $changelog->sku ?></a></td>
            <td><?= $changelog->date_last_modified ?></td>
            <td><?= $changelog->modified_by ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>