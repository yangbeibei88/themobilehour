<?= loadPartial('header') ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('breadcrumb') ?>
<?= loadPartial('message') ?>

<main id="product-manager">
  <div class="container my-4">
    <div class="d-flex align-items-center justify-content-between" id="product-manager-top">
      <form class="d-flex" role="search">
        <input type="search" name="admin-product-search" id="admin-product-search" placeholder="Search" aria-label="Search" class="form-control me-2">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
      <a href="product-management/create" role="button" class="btn btn-outline-primary">Add New
        Product</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">SKU</th>
          <th scope="col">Title</th>
          <th scope="col">Category</th>
          <th scope="col">List Price</th>
          <th scope="col">Sale Price</th>
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
                <img src="<?= assetPath('uploads/images/product-placeholder.jpeg') ?>" alt="<?= $product->product_name ?>" class="img-thumbnail" width="50" height="50">
              <?php endif; ?>
            </td>
            <td><a href="product-management/<?= $product->product_id ?>"><?= $product->sku ?></a></td>
            <td><a href="product-management/<?= $product->product_id ?>"><?= $product->product_name ?></a></td>
            <td><a href="category-management/<?= $product->category_id ?>"><?= $product->category_name ?></a></td>
            <td><?= formatPrice($product->list_price) ?></td>
            <td><?= getSalePrice($product->list_price, $product->disc_pct) ?></td>
            <td><a href="product-management/edit/<?= $product->product_id ?>" class="btn btn-primary btn-sm" role="button">Edit</a></td>
            <td><a href="product-management/delete/<?= $product->product_id ?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
          <?php endforeach; ?>
          </tr>
      </tbody>
    </table>
  </div>
</main>
<?= loadPartial('footer') ?>