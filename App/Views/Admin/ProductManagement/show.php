<?= loadPartial('header', [
  'pageTitle' => $product->product_name
]) ?>
<?= loadPartial('navbar-admin') ?>
<div class="container pt-3">
  <div class="d-flex align-items-center justify-content-between">
    <a href="<?= assetPath('admin/product-management') ?>" class="d-block btn btn-outline-primary">Back To Products</a>
    <div class="d-flex gap-3">
      <a href="<?= assetPath('admin/product-management/edit/' . $product->product_id) ?>" class="btn btn-primary">Edit</a>
      <a href="<?= assetPath('admin/product-management/delete/' . $product->product_id) ?>" class="btn btn-danger">Delete</a>
    </div>
  </div>
</div>
<?= loadPartial('pagetitle', [
  'pageTitle' => $product->product_name
]) ?>
<?php
// push each product's not-null image paths to a new array
$imagePaths = [];

foreach ((array) $product as $key => $value) {
  if (strripos($key, 'imgpath') === 0 && !empty($value)) {
    $num = substr($key, -1);
    $imgpathKey = 'imgpath' . $num;
    $altKey = 'alt' . $num;
    $imagePaths[] = [
      'imgpath' => $value,
      'alt' => $product->$altKey
    ];
  }
}

?>

<main id="single-product-page-detail-admin">
  <div class="container my-4">
    <div class="accordion" id="productAccordion">
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productMetaPanel" aria-expanded="true" aria-controls="productMetaPanel">
            <h2 class="fs-5">Product Meta</h2>
          </button>
        </div>
        <div id="productMetaPanel" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <table class="table">
              <tbody>
                <tr>
                  <th scope="row">SKU</th>
                  <td><?= $product->sku ?></td>
                </tr>
                <tr>
                  <th scope="row">Title</th>
                  <td><?= $product->product_name ?></td>
                </tr>
                <tr>
                  <th scope="row">Category</th>
                  <td><?= $product->category_name ?></td>
                </tr>
                <tr>
                  <th scope="row">Model</th>
                  <td><?= $product->product_model ?></td>
                </tr>
                <tr>
                  <th scope="row">Manufacturer</th>
                  <td><?= $product->manufacturer ?></td>
                </tr>
                <tr>
                  <th scope="row">List Price</th>
                  <td><?= $product->list_price ?></td>
                </tr>
                <tr>
                  <th scope="row">Discount</th>
                  <td><?= $product->disc_pct ?></td>
                </tr>
                <tr>
                  <th scope="row">Stock</th>
                  <td><?= $product->stock_on_hand ?></td>
                </tr>
                <tr>
                  <th scope="row">Display Online</th>
                  <td><?= (isset($product->product_is_active) && $product->product_is_active == 1) ? 'active' : 'inactive' ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionPanel" aria-expanded="true" aria-controls="productDescriptionPanel">
            <h2 class="fs-5">Product
              Description</h2>
          </button>
        </div>
        <div id="productDescriptionPanel" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <?= $product->product_desc ?>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productImagesPanel" aria-expanded="true" aria-controls="productImagesPanel">
            <h2 class="fs-5">Product
              Images</h2>
          </button>
        </div>
        <div id="productImagesPanel" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <table class="table" id="product-imagegallery-table">
              <thead>
                <tr>
                  <th scope="col">Thumbnail
                  </th>
                  <th scope="col">File Name
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if (!is_null($product->image_gallery_id) && count($imagePaths) > 0) : ?>
                  <?php foreach ($imagePaths as $key => $value) : ?>
                    <tr>
                      <td><img src="<?= assetPath($value['imgpath']) ?>" alt="<?= $value['alt'] ?>" width="50" height="auto"></td>
                      <td><?= basename(assetPath($value['imgpath'])) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <div class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productFeaturesPanel" aria-expanded="true" aria-controls="productFeaturesPanel">
            <h2 class="fs-5">Product
              Features</h2>
          </button>
        </div>
        <div id="productFeaturesPanel" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <table class="table" id="admin-product-feature">
              <tbody>
                <tr>
                  <th scope="row">Weight</th>
                  <td><?= $product->weight ?></td>
                </tr>
                <tr>
                  <th scope="row">Dimensions</th>
                  <td><?= $product->dimensions ?></td>
                </tr>
                <tr>
                  <th scope="row">OS</th>
                  <td><?= $product->os ?></td>
                </tr>
                <tr>
                  <th scope="row">Screensize</th>
                  <td><?= $product->screensize ?></td>
                </tr>
                <tr>
                  <th scope="row">Resolution</th>
                  <td><?= $product->resolution ?></td>
                </tr>
                <tr>
                  <th scope="row">Storage (GB)</th>
                  <td><?= $product->storage ?></td>
                </tr>
                <tr>
                  <th scope="row">Colour</th>
                  <td><?= $product->colour ?></td>
                </tr>
                <tr>
                  <th scope="row">RAM (GB)</th>
                  <td><?= $product->ram ?></td>
                </tr>
                <tr>
                  <th scope="row">CPU</th>
                  <td><?= $product->cpu ?></td>
                </tr>
                <tr>
                  <th scope="row">Battery (mAh)</th>
                  <td><?= $product->battery ?></td>
                </tr>
                <tr>
                  <th scope="row">Rear Camera</th>
                  <td><?= $product->rear_camera ?></td>
                </tr>
                <tr>
                  <th scope="row">Front Camera</th>
                  <td><?= $product->front_camera ?></td>
                </tr>
              </tbody>
            </table>
            <div class="row row-cols-1 row-cols-md-2 g-3">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?= loadPartial('footer') ?>