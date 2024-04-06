<?= loadPartial('header') ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('breadcrumb') ?>
<main id="product-delete">
  <div class="container my-4">

    <form method="POST" action="/themobilehour/admin/product-management/destroy/<?= $product->product_id ?>" id="product-delete-form">
      <h1>Delete Product</h1>
      <p>Click confirm to delete the product:
      </p>
      <p>SKU: <?= $product->sku ?></p>
      <p>Product Name: <?= $product->product_name ?></p>

      <a href="<?= assetPath('admin/product-management') ?>" class="btn btn-secondary">Cancel</a>
      <input type="submit" name="delete" value="confirm" class="btn btn-danger">
    </form>
  </div>
</main>
<?= loadPartial('footer') ?>