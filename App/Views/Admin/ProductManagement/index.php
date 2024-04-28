<?= loadPartial('header', [
  'pageTitle' => 'Product Mangement'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Product Mangement'
]) ?>
<?= loadPartial('message') ?>


<main id="product-manager">
  <div class="container my-4">
    <div class="d-flex justify-content-end mb-3">
      <a href="product-management/create" role="button" class="btn btn-outline-primary">Add New
        Product</a>
    </div>

    <form class="row row-cols-1 row-cols-sm-2 row-cols-md-4 align-items-center justify-conent-between border rounded bg-body-tertiary p-2" role="search" action="<?= assetPath('admin/product-management/search') ?>" method="GET">
      <div class="col col-md-6">
        <label for="admin-product-search" class="form-label">Search</label>
        <input type="search" name="term" id="admin-product-search" placeholder="Search by SKU or Product Name" aria-label="Search" class="form-control me-2" value="<?= $term ?? '' ?>">
        <div class="text-danger"><?= $errors['term'] ?? '' ?></div>
      </div>
      <div class="col">
        <label for="stockOperator" class="form-label">Operator</label>
        <select name="stockOperator" id="stockOperator" class="form-select">
          <option value="" selected>Select a operator</option>
          <?php foreach ($operators as $key => $value) : ?>
            <option value="<?= $key ?>" <?= (isset($inputData['stockOperator']) && $inputData['stockOperator'] == $key) ? 'selected' : '' ?>><?= $value['label'] ?></option>
          <?php endforeach; ?>
        </select>
        <div class="text-danger"><?= $errors['stockOperator'] ?? '' ?></div>
      </div>
      <div class="col">
        <label for="stockQty" class="form-label">Stock Qty</label>
        <input type="number" name="stockQty" id="stockQty" class="form-control" value="<?= $inputData['stockQty'] ?? '' ?>">
        <div class="text-danger"><?= $errors['stockQty'] ?? '' ?></div>
      </div>

      <div class="col d-flex flex-grow-1 align-items-end justify-content-end mt-auto gap-3 pt-3">
        <a href="<?= assetPath('admin/product-management') ?>" class="btn btn-secondary">Reset</a>
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <?php if (!empty($inputData) && empty($errors)) : ?>
      <div class="text-center border border-1 rounded py-2 bg-light">Search Result for: <strong><?= "'{$term}'" ?? '' ?> <?= !empty($inputData['stockOperator']) ? ' stock quantity ' . $operators[$inputData['stockOperator']]['label'] : '' ?> <?= $inputData['stockQty'] ?? '' ?></strong>. Matches Found: <strong><?= $count ?? '' ?></strong></div>
    <?php else : ?>
      Total: <?= count($products) ?> products
    <?php endif; ?>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Image</th>
            <th scope="col">SKU</th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Stock</th>
            <th scope="col">List Price</th>
            <th scope="col">Sale Price</th>
            <th scope="col">View</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) : ?>
            <tr>
              <td>
                <?php if (!is_null($product->image_gallery_id) && !is_null($product->imgpath1)) : ?>
                  <img src="<?= assetPath($product->imgpath1) ?>" alt="<?= $product->alt1 ?>" class="img-thumbnail" width="50" height="50">
                <?php else : ?>
                  <img src="<?= assetPath('uploads/images/product-placeholder.jpeg') ?>" alt="<?= $product->product_name ?>" class="img-thumbnail" width="50" height="auto">
                <?php endif; ?>
              </td>
              <td><?= $product->sku ?></td>
              <td><?= $product->product_name ?></td>
              <td><a href="<?= assetPath('admin/category-management/show/') . $product->category_id ?>"><?= $product->category_name ?></a></td>
              <td><?= $product->stock_on_hand ?></td>
              <td><?= formatPrice($product->list_price) ?></td>
              <td><?= getSalePrice($product->list_price, $product->disc_pct) ?></td>
              <td><a href="<?= assetPath('admin/product-management/show/' . $product->product_id) ?>" class="btn btn-info btn-sm" role="button">View</a></td>
              <td><a href="<?= assetPath('admin/product-management/edit/' . $product->product_id) ?>" class="btn btn-primary btn-sm" role="button">Edit</a></td>
              <td><a href="<?= assetPath('admin/product-management/delete/' . $product->product_id) ?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
            <?php endforeach; ?>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>