<?= loadPartial('header', [
  'pageTitle' => 'Category Mangement'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Category Mangement'
]) ?>
<?= loadPartial('message') ?>

<main id="category-manager">
  <div class="container my-4">
    <div class="d-flex align-items-center justify-content-end mb-3" id="product-manager-top">
      <a href="<?= assetPath('admin/category-management/create') ?>" role="button" class="btn btn-outline-primary">Add New
        Category</a>
    </div>

    <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col">Category</th>
            <th scope="col">Product Count</th>
            <th scope="col">Stock</th>
            <th scope="col">View</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $category) : ?>
            <tr>
              <td><?= $category->category_name ?></td>
              <td><?= $category->productCount ?></td>
              <td><?= $category->stock ?></td>
              <td><a href="<?= assetPath('admin/category-management/show/' . $category->category_id) ?>" class="btn btn-secondary btn-sm" role="button">View</a></td>
              <td><a href="<?= assetPath('admin/category-management/edit/' . $category->category_id) ?>" class="btn btn-primary btn-sm" role="button">Edit</a></td>
              <td><a href="<?= assetPath('admin/category-management/delete/' . $category->category_id) ?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>