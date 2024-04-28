<?= loadPartial('header', [
  'pageTitle' => 'Product Changelog'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Product Changelog'
]) ?>

<main id="changelogs">
  <div class="container mt-4">
    <form action="<?= assetPath('admin/changelogs/filter') ?>" method="GET" class="row gap-column-3 flex-wrap border rounded bg-body-tertiary p-2" id="changelogs-top">
      <div class="col-12 col-md-6">
        <label for="filterByUser" class="form-label">User</label>
        <!-- <input type="text" name="admin-changeloguser-search" id="admin-changeloguser-search" placeholder="Search by user" aria-label="Search by user" class="form-control me-2"> -->
        <select name="admin_user" id="filterByUser" class="form-select">
          <option selected value="">Select a user</option>
          <?php foreach ($users as $user) : ?>
            <option value="<?= $user->admin_user_id ?>" <?= $user->admin_user_id == ($filterInputData['admin_user'] ?? '') ? 'selected' : '' ?>> <?= $user->full_name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12 col-md-6">
        <label for="filterByProduct" class="form-label">Product</label>
        <input type="text" name="product_term" id="filterByProduct" placeholder="Search by product" aria-label="Search by product" value="<?= $product_term ?? '' ?>" class="form-control me-2">
      </div>
      <fieldset class="col-12 col-md-6 rounded p-2">
        <legend class="fs-6 fw-bold">Created Date</legend>
        <div class="d-flex gap-3">
          <div class="col">
            <label for="dateFromChangelog" class="form-label">From</label>
            <input type="date" name="dateFrom" id="dateFromChangelog" placeholder="Date from" aria-label="Date from" value="<?= $filterInputData['dateFrom'] ?? '' ?>" class="form-control me-2">
          </div>
          <div class="col">
            <label for="dateToChangelog" class="form-label">To</label>
            <input type="date" name="dateTo" id="dateToChangelog" placeholder="Date to" aria-label="Date to" value="<?= $filterInputData['dateTo'] ?? '' ?>" class="form-control me-2">
          </div>
        </div>
      </fieldset>
      <div class="col-12 col-md-6 d-flex align-items-end justify-content-end gap-2">
        <a href="<?= assetPath('admin/changelogs') ?>" class="btn btn-secondary">Reset</a>
        <button type="submit" class="btn btn-primary">Search</button>
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