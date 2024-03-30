<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('breadcrumb') ?>
<?php


?>

<!-- <?php inspect($products) ?> -->

<main id="product-list-main">
  <div class="container-fluid py-3">
    <div class="row">
      <section class="col-12 col-md-9 order-2" id="productlist-and-sort">
        <div class="container" id="product-sort-and-count">
          <div class="row align-items-center">
            <div class="col">20 Products</div>
            <div class="col">
              Sort by:
              <select class="form-select" aria-label="Default select example">
                <option selected>Best Sellers
                </option>
                <option value="1">Newest to
                  Oldest
                </option>
                <option value="2">Oldest to
                  Newest
                </option>
                <option value="3">Price Low to
                  High
                </option>
                <option value="4">Price High to
                  Low
                </option>
              </select>
            </div>
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

                  <a href="product?id=<?= $product->product_id ?>">
                    <?php if (!is_null($product->image_gallery_id) && !is_null($product->imgpath1)) : ?>
                      <img src="<?= $product->imgpath1 ?>" alt="<?= $product->alt1 ?>" class="card-img-top p-4">
                    <?php else : ?>
                      <img src="uploads/images/product-placeholder.jpeg" alt="<?= $product->product_name ?>" class="card-img-top p-4">
                    <?php endif; ?>
                  </a>
                  <div class="card-body">
                    <h5 class="card-title">
                      <a href="product?id=<?= $product->product_id ?>" class="link-underline link-underline-opacity-0">
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
                    <?php if ($product->stock_on_hand > 0) : ?>
                      <a href="#" class="btn btn-primary w-100" role="button">Add to
                        Cart</a>
                    <?php else : ?>
                      <a href="#" class="btn btn-secondary w-100 disabled" role="button" aria-disabled="true">Unavailable</a>
                    <?php endif; ?>
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
          <div class="accordion accordion-flush" id="productfilters">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryFilter" aria-expanded="true" aria-controls="collapseOne">
                  By Brand
                </button>
              </h2>
              <div id="categoryFilter" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <div class="form-check">
                    <input type="checkbox" name="brandfilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">Apple
                      (5)</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="brandfilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">Apple
                      (5)</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="brandfilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">Apple
                      (5)</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryFilter" aria-expanded="true" aria-controls="collapseOne">
                  By Storage
                </button>
              </h2>
              <div id="categoryFilter" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <div class="form-check">
                    <input type="checkbox" name="storagefilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">64GB
                      (5)</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="storagefilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">128GB
                      (5)</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="storagefilter" id="apple" class="form-check-input">
                    <label for="apple" class="form-check-label">256GB
                      (5)</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</main>

<?= loadPartial('footer') ?>