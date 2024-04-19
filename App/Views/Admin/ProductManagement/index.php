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
    <div class="row justify-content-between" id="product-manager-top">
      <form class="col-md-6 me-auto d-flex" role="search" action="<?= assetPath('admin/product-management/search') ?>" method="GET">
        <input type="search" name="term" id="admin-product-search" placeholder="Search by SKU or Product Name" aria-label="Search" class="form-control me-2" value="<?= $term ?? '' ?>">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
      <div class="col-auto ms-auto">
        <a href="product-management/create" role="button" class="btn btn-outline-primary">Add New
          Product</a>
      </div>
    </div>
    <?php if (isset($term)) : ?>
      <div class="text-center border border-1 rounded py-2 bg-light">Search Result for: <strong><?= "'{$term}'" ?></strong>. Matches Found: <strong><?= $count ?></strong></div>
    <?php else : ?>
      All Products
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
              <td><a href="<?= assetPath('category-management/') . $product->category_id ?>"><?= $product->category_name ?></a></td>
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