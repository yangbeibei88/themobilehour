<?= loadPartial('header', ['pageTitle' => 'Shop | The Mobile Hours']) ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Shop']) ?>


<main id="product-list-main">
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
                  <div class="card-body d-flex flex-column justify-content-between">
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
                  </div>
                  <div class="card-footer">
                    <?php if ($product->stock_on_hand > 0) : ?>
                      <p class="text-success text-center mt-2">
                        In Stock</p>
                    <?php else : ?>
                      <p class="text-danger text-center mt-2">
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
          <form method="GET" action="<?= assetPath("products/filter") ?>" id="product-filters">
            <h5>Filters</h5>
            <div class="accordion accordion-flush" id="productfilters">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryFilter" aria-expanded="true" aria-controls="collapseOne">
                    By Brand
                  </button>
                </h2>
                <div id="categoryFilter" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <?php foreach ($categories as $category) : ?>
                      <div class="form-check">
                        <input type="checkbox" name="category_id[]" id="<?= $category->category_name ?>" class="form-check-input" value="<?= $category->category_id  ?>" <?= in_array($category->category_id, $_GET['category_id'] ?? []) ? 'checked' : '' ?>>
                        <label for="<?= $category->category_name ?>" class="form-check-label"><?= $category->category_name . ' (' . $category->productCount . ')' ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
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
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#priceFilter" aria-expanded="true" aria-controls="collapseOne">
                    By Price
                  </button>
                </h2>
                <div id="priceFilter" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <?php foreach ($priceRanges as $key => $range) : ?>
                      <div class="form-check">
                        <input type="checkbox" name="priceRange[]" id="<?= $key ?>" class="form-check-input" value="<?= $key ?>" <?= in_array($key, $_GET['priceRange'] ?? []) ? 'checked' : '' ?>>
                        <label for="<?= $key ?>" class="form-check-label"><?= "{$range['label']} ({$range['count']})" ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
            <a type="reset" class="btn btn-secondary" href="<?= assetPath('products') ?>">Reset</a>
            <button type="submit" class="btn btn-primary">Apply</button>
          </form>
        </div>
      </aside>
    </div>
  </div>
</main>

<?= loadPartial('footer') ?>