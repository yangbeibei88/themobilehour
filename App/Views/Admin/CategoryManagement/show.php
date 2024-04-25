<?= loadPartial('header', [
  'pageTitle' => $category->category_name
]) ?>
<?= loadPartial('navbar-admin') ?>
<div class="container pt-3">
  <div class="d-flex align-items-center justify-content-between">
    <a href="<?= assetPath('admin/category-management') ?>" class="d-block btn btn-outline-primary">Back To Categories</a>
    <div class="d-flex gap-3">
      <a href="<?= assetPath('admin/category-management/edit/' . $category->category_id) ?>" class="btn btn-primary">Edit</a>
      <a href="<?= assetPath('admin/category-management/delete/' . $category->category_id) ?>" class="btn btn-danger">Delete</a>
    </div>
  </div>
</div>
<?= loadPartial('pagetitle', [
  'pageTitle' => $category->category_name
]) ?>

<main id="admin-categories">
  <div class="container my-4">
    <div class="accordion" id="categoryAccordion">
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryPanel" aria-expanded="true" aria-controls="categoryPanel">
            <h2 class="fs-5">Category
              Information</h2>
          </button>
        </div>
        <div id="categoryPanel" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <table class="table">
              <tr>
                <th scope="row">Category Name</th>
                <td><?= $category->category_name ?></td>
              </tr>
              <tr>
                <th scope="row">Category Description</th>
                <td><?= $category->category_desc ?></td>
              </tr>
              <tr>
                <th scope="row">Display Online</th>
                <td><?= $category->is_active == 1 ? 'active' : 'inactive' ?></td>
              </tr>
              <tr>
                <th scope="row">Category Image</th>
                <td>
                  <?php if ($category->category_img_path) : ?>
                    <img src="<?= assetPath($category->category_img_path) ?>" alt="<?= $category->category_img_alt ?>" width="300" height="auto">
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th scope="row">Alt Text</th>
                <td>
                  <?= $category->category_img_alt ?>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryProductsPanel" aria-expanded="true" aria-controls="categoryProductsPanel">
            <h2 class="fs-5">Category
              Products</h2>
          </button>
          <div id="categoryProductsPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <?php if (!$products) : ?>
                <p>This category has no products yet.</p>
              <?php else : ?>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">SKU</th>
                        <th scope="col">Title</th>
                        <th scope="col">Stock</th>
                        <th scope="col">List Price</th>
                        <th scope="col">Sale Price</th>
                        <th scope="col">View</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($products as $product) : ?>
                        <tr>
                          <td><?= $product->sku ?></td>
                          <td><?= $product->product_name ?></td>

                          <td><?= $product->stock_on_hand ?></td>
                          <td><?= formatPrice($product->list_price) ?></td>
                          <td><?= getSalePrice($product->list_price, $product->disc_pct) ?></td>
                          <td><a href="<?= assetPath('admin/product-management/show/' . $product->product_id) ?>" class="btn btn-info btn-sm" role="button">View</a></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
<?= loadPartial('footer') ?>