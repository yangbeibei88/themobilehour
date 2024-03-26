<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('breadcrumb') ?>

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
                <option value="3">Price High to
                  Low
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="container" id="product-list">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 my-4">
            <article class="col">
              <div class="card">
                <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                  ON SALE
                </span>
                <a href="#">
                  <img src="uploads/images/639220.jpg" alt="" class="card-img-top p-4">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#" class="link-underline link-underline-opacity-0">
                      iPhone 15
                      Pro Max 256GB Natural
                      Titanium
                    </a>
                  </h5>
                  <p class="card-text fs-3 fw-bold">
                    $1987
                  </p>
                  <a href="#" class="btn btn-primary w-100" role="button">Add to
                    Cart</a>
                  <p class="card-text text-success text-center mt-2">
                    In Stock</p>
                </div>
              </div>
            </article>
            <article class="col">
              <div class="card">
                <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                  ON SALE
                </span>
                <a href="#">
                  <img src="uploads/images/639220.jpg" alt="" class="card-img-top p-4">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#" class="link-underline link-underline-opacity-0">
                      iPhone 15
                      Pro Max 256GB Natural
                      Titanium
                    </a>
                  </h5>
                  <p class="card-text fs-3 fw-bold">
                    $1987
                  </p>
                  <a href="#" class="btn btn-primary w-100" role="button">Add to
                    Cart</a>
                  <p class="card-text text-success text-center mt-2">
                    In Stock</p>
                </div>
              </div>
            </article>
            <article class="col">
              <div class="card">
                <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                  ON SALE
                </span>
                <a href="#">
                  <img src="uploads/images/639220.jpg" alt="" class="card-img-top p-4">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#" class="link-underline link-underline-opacity-0">
                      iPhone 15
                      Pro Max 256GB Natural
                      Titanium
                    </a>
                  </h5>
                  <p class="card-text fs-3 fw-bold">
                    $1987
                  </p>
                  <a href="#" class="btn btn-primary w-100" role="button">Add to
                    Cart</a>
                  <p class="card-text text-success text-center mt-2">
                    In Stock</p>
                </div>
              </div>
            </article>
            <article class="col">
              <div class="card">
                <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                  ON SALE
                </span>
                <a href="#">
                  <img src="uploads/images/639220.jpg" alt="" class="card-img-top p-4">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#" class="link-underline link-underline-opacity-0">
                      iPhone 15
                      Pro Max 256GB Natural
                      Titanium
                    </a>
                  </h5>
                  <p class="card-text fs-3 fw-bold">
                    $1987
                  </p>
                  <a href="#" class="btn btn-primary w-100" role="button">Add to
                    Cart</a>
                  <p class="card-text text-success text-center mt-2">
                    In Stock</p>
                </div>
              </div>
            </article>
            <article class="col">
              <div class="card">
                <span class="position-absolute top-0 start-0 badge rounded-pill bg-danger">
                  ON SALE
                </span>
                <a href="#">
                  <img src="uploads/images/639220.jpg" alt="" class="card-img-top p-4">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="#" class="link-underline link-underline-opacity-0">
                      iPhone 15
                      Pro Max 256GB Natural
                      Titanium
                    </a>
                  </h5>
                  <p class="card-text fs-3 fw-bold">
                    $1987
                  </p>
                  <a href="#" class="btn btn-primary w-100" role="button">Add to
                    Cart</a>
                  <p class="card-text text-success text-center mt-2">
                    In Stock</p>
                </div>
              </div>
            </article>
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