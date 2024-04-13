<?= loadPartial('header', [
  'pageTitle' => 'Delete Product'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Delete Product'
]) ?>
<main id="product-delete">
  <div class="container my-4">
    <form method="POST" action="/themobilehour/admin/product-management/destroy/<?= $product->product_id ?>" id="product-delete-form">
      <h1>Delete Product</h1>
      <p>Click confirm to delete the product:
      </p>
      <p>SKU: <?= $product->sku ?></p>
      <p>Product Name: <?= $product->product_name ?></p>

      <a href="<?= assetPath('admin/product-management') ?>" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-danger">Confirm</button>
    </form>
  </div>
</main>
<?= loadPartial('footer') ?>