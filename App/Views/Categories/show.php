<?= loadPartial('header', ['pageTitle' => $category->category_name]) ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => $category->category_name,
  'pageDesc' => $category->category_desc
]) ?>

<main id="category-products">
  <div class="container-fluid py-3">
    <div class="row">
      <section class="col-12 col-md-9 order-2" id="productlist-and-sort">
        <div class="container" id="product-sort-and-count">
          <?php if (isset($term)) : ?>
            <div class="row align-items-center">
              <div class="text-center border border-1 rounded py-2 bg-light">Search Result for: <strong><?= "'{$term}'" ?></strong>. Matches Found: <strong><?= $count ?></strong></div>
            </div>
          <?php endif; ?>
          <div class="row align-items-center">
            <div class="col"><?= count($products) ?> Products</div>
          </div>
        </div>
        <div class="container" id="product-list">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 my-4">
            <?php foreach ($products as $product) : ?>
              <!-- PRODUCT CARD START -->
              <article class="col">
                <div class="card h-100">
                  <?php if ($product->disc_pct > 0) : ?>
                    <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                      ON SALE
                    </span>
                  <?php endif; ?>

                  <a href="<?= assetPath('products/' . $product->product_id) ?>">
                    <?php if (!is_null($product->image_gallery_id) && !is_null($product->imgpath1)) : ?>
                      <img src="<?= assetPath($product->imgpath1) ?>" alt="<?= $product->alt1 ?>" class="card-img-top p-4">
                    <?php else : ?>
                      <img src="<?php assetPath('uploads/images/product-placeholder.jpeg') ?>" alt="<?= $product->product_name ?>" class="card-img-top p-4">
                    <?php endif; ?>
                  </a>
                  <div class="card-body">
                    <h5 class="card-title">
                      <a href="<?= assetPath('products/' . $product->product_id) ?>" class="link-underline link-underline-opacity-0">
                        <?= $product->product_name ?>
                      </a>
                    </h5>
                    <?php if ($product->disc_pct > 0) : ?>
                      <p class="card-text fs-5 text-decoration-line-through listprice mb-0">
                        <?= formatPrice($product->list_price) ?>
                      </p>
                      <p class="card-text fs-3 fw-bold saleprice">
                        <?= getSalePrice($product->list_price, $product->disc_pct) ?>
                      </p>
                    <?php else : ?>
                      <p class="card-text fs-3 fw-bold saleprice">
                        <?= formatPrice($product->list_price) ?>
                      </p>
                    <?php endif; ?>
                    <!-- <?php if ($product->stock_on_hand > 0) : ?>
                      <a href="#" class="btn btn-primary w-100" role="button">Add to
                        Cart</a>
                    <?php else : ?>
                      <a href="#" class="btn btn-secondary w-100 disabled" role="button" aria-disabled="true">Unavailable</a>
                    <?php endif; ?> -->
                    <?php if ($product->stock_on_hand > 0) : ?>
                      <p class="card-text text-success text-center mt-2">
                        In Stock</p>
                    <?php else : ?>
                      <p class="card-text text-danger text-center mt-2">
                        Out of Stock</p>
                    <?php endif; ?>
                  </div>
                </div>
              </article>
              <!-- PRODUCT CARD END -->
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <aside class="col-12 col-md-3 order-1">
        <div class="container">
          <form method="GET" action="<?= assetPath("categories/filter/" . $category->category_id) ?>" id="category-product-filters">
            <div class="accordion accordion-flush" id="productfilters">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#storageFilter" aria-expanded="true" aria-controls="collapseOne">
                    By Storage
                  </button>
                </h2>
                <div id="storageFilter" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <?php foreach ($storages as $storage) : ?>
                      <div class="form-check">
                        <input type="checkbox" name="storage[]" id="<?= number_format($storage->storage, 0) . 'GB' ?>" class="form-check-input" value="<?= $storage->storage ?>" <?= in_array($storage->storage, $_GET['storage'] ?? []) ? 'checked' : '' ?>>
                        <label for="<?= number_format($storage->storage, 0) . 'GB' ?>" class="form-check-label"><?= number_format($storage->storage, 0) . 'GB' ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#screensizeFilter" aria-expanded="true" aria-controls="collapseOne">
                    By Screensize
                  </button>
                </h2>
                <div id="screensizeFilter" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <?php foreach ($screensizes as $screensize) : ?>
                      <div class="form-check">
                        <input type="checkbox" name="screensize[]" id="<?= number_format($screensize->screensize, 1) . 'inch' ?>" class="form-check-input" value="<?= $screensize->screensize ?>" <?= in_array($screensize->screensize, $_GET['screensize'] ?? []) ? 'checked' : '' ?>>
                        <label for="<?= number_format($screensize->screensize, 1) . 'inch' ?>" class="form-check-label"><?= number_format($screensize->screensize, 1) . 'inch' ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <!-- <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#resolutionFilter" aria-expanded="true" aria-controls="collapseOne">
                    By Resolution
                  </button>
                </h2>
                <div id="resolutionFilter" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <?php foreach ($resolutions as $resolution) : ?>
                      <div class="form-check">
                        <input type="checkbox" name="resolution[]" id="<?= $resolution->resolution ?>" class="form-check-input" value="<?= $resolution->resolution ?>" <?= in_array($resolution->resolution, $_GET['resolution'] ?? []) ? 'checked' : '' ?>>
                        <label for="<?= $resolution->resolution ?>" class="form-check-label"><?= $resolution->resolution ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div> -->
            </div>
            <a type="reset" class="btn btn-secondary" href="<?= assetPath('categories/' . $category->category_id) ?>">Reset</a>
            <button type="submit" class="btn btn-primary">Apply</button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</main>

<?= loadPartial('footer') ?>