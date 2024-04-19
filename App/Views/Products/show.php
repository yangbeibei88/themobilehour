<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('breadcrumb-notitle') ?>
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

// inspect($imagePaths);
// inspect(count($imagePaths));
?>
<main id="single-product-page-detail">
  <div class="container py-4">
    <section class="row product-info">
      <div class="col order-1 order-md-2 product-title">
        <h1 class="fs-2"><?= $product->product_name ?></h1>
        <p>SKU: <?= $product->sku ?></p>
      </div>
      <div class="col product-img-gallery order-2 order-md-1">
        <div id="productGalleryCarousel" class="carousel slide">
          <div class="carousel-indicators">
            <?php if (is_null($product->image_gallery_id) || count($imagePaths) === 0) : ?>
              <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="0" class="active img-thumnail">
                <img src="<?= assetPath('uploads/images/product-placeholder.jpeg') ?>" alt="<?= $product->product_name ?>" class="d-block w-100">
              </button>
            <?php else : ?>
              <?php foreach ($imagePaths as $key => $value) : ?>
                <?php if ($key === 0) : ?>
                  <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="0" class="active img-thumnail">
                    <img src="<?= assetPath($value['imgpath']) ?>" alt="<?= $value['alt'] ?>" class="d-block w-100">
                  </button>
                <?php else : ?>
                  <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="<?= $key ?>" class="img-thumnail">
                    <img src="<?= assetPath($value['imgpath']) ?>" alt="<?= $value['alt'] ?>" class="d-block w-100">
                  </button>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>

          </div>
          <div class="carousel-inner border">
            <?php if (is_null($product->image_gallery_id) || count($imagePaths) === 0) : ?>
              <div class="carousel-item active">
                <img src="<?= assetPath('uploads/images/product-placeholder.jpeg') ?>" class="d-block w-100" alt="<?= $product->product_name ?>">
              </div>
            <?php else : ?>
              <?php foreach ($imagePaths as $key => $value) : ?>
                <?php if ($key === 0) : ?>
                  <div class="carousel-item active">
                    <img src="<?= assetPath($value['imgpath']) ?>" class="d-block w-100" alt="<?= $value['alt'] ?>">
                  </div>
                <?php else : ?>
                  <div class="carousel-item">
                    <img src="<?= assetPath($value['imgpath']) ?>" class="d-block w-100" alt="<?= $value['alt'] ?>">
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#productGalleryCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#productGalleryCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="col product-short-desc order-2">
        <?php if ($product->disc_pct > 0) : ?>
          <p class="mb-0">RRP: <s><?= formatPrice($product->list_price) ?></s></p>
          <span class="fs-2 fw-bold"><?= getSalePrice($product->list_price, $product->disc_pct) ?></span>
          <span class="fs-4">(<?= getDiscAmount($product->list_price, $product->disc_pct) ?> OFF)</span>
        <?php else : ?>
          <span class="fs-2 fw-bold"><?= formatPrice($product->list_price) ?></span>
        <?php endif; ?>

        <p>Colour: <?= $product->colour ?></p>
        <p>Storage: <?= getInteger($product->storage) ?>GB</p>
        <!-- <input type="number" name="product-qty" class="form-control w-auto my-4" value="1">
        <a href="#" class="btn btn-primary d-block w-100" role="button">Add to Cart</a> -->
        <?php if ($product->stock_on_hand > 0) : ?>
          <p class="card-text text-success mt-2">
            In Stock</p>
        <?php else : ?>
          <p class="card-text text-danger mt-2">
            Out of Stock</p>
        <?php endif; ?>
      </div>
    </section>
    <section class="row my-4 product-details">
      <ul class="nav nav-tabs" id="productDetailTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" aria-controls="desc-tab-pane" aria-selected="true">Description</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-tab-pane" type="button" role="tab" aria-controls="specs-tab-pane" aria-selected="false">Specifications</button>
        </li>
      </ul>
      <div class="tab-content" id="productContentTab">
        <div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel" aria-labelledby="desc-tab" tabindex="0">
          <?= $product->product_desc ?>
        </div>
        <div class="tab-pane fade" id="specs-tab-pane" role="tabpanel" aria-labelledby="specs-tab" tabindex="0">
          <table class="table table-striped my-4">
            <tbody>
              <tr>
                <th scope="row">SKU</th>
                <td><?= $product->sku ?></td>
              </tr>
              <tr>
                <th scope="row">Brand</th>
                <td><?= $product->manufacturer ?></td>
              </tr>
              <tr>
                <th scope="row">MPN</th>
                <td><?= $product->product_model ?></td>
              </tr>
              <tr>
                <th scope="row">OS</th>
                <td><?= $product->os ?></td>
              </tr>
              <tr>
                <th scope="row">Screen Size
                  (Inches)</th>
                <td><?= $product->screensize ?></td>
              </tr>
              <tr>
                <th scope="row">Resolution
                  (Pixels)</th>
                <td><?= $product->resolution ?></td>
              </tr>
              <tr>
                <th scope="row">Storage (GB)
                </th>
                <td><?= getInteger($product->storage) ?></td>
              </tr>
              <tr>
                <th scope="row">RAM (GB)</th>
                <td><?= getInteger($product->ram) ?></td>
              </tr>
              <tr>
                <th scope="row">Colour</th>
                <td><?= $product->colour ?></td>
              </tr>
              <tr>
                <th scope="row">CPU</th>
                <td><?= $product->cpu ?>
                </td>
              </tr>
              <tr>
                <th scope="row">Battery (mAh)
                </th>
                <td><?= getInteger($product->battery) ?></td>
              </tr>
              <tr>
                <th scope="row">Rear Camera (MP)
                </th>
                <td><?= $product->rear_camera ?></td>
              </tr>
              <tr>
                <th scope="row">Front Camera
                  (MP)</th>
                <td><?= $product->front_camera ?></td>
              </tr>
              <tr>
                <th scope="row">Weight (kg)</th>
                <td><?= $product->weight ?></td>
              </tr>
              <tr>
                <th scope="row">Dimensions (W x H x T, mm)
                </th>
                <td><?= $product->dimensions ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</main>
<?= loadPartial('footer') ?>