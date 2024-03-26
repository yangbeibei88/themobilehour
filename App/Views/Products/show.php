<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('breadcrumb') ?>
<main id="single-product-page-detail">
  <div class="container py-4">
    <section class="row product-info">
      <div class="col order-1 order-md-2 product-title">
        <h1 class="fs-2">iPhone 15 Pro Max
          256GB
          Natural Titanium</h1>
        <p>SKU: 639220</p>
      </div>
      <div class="col product-img-gallery order-2 order-md-1">
        <div id="productGalleryCarousel" class="carousel slide">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="0" class="active img-thumnail">
              <img src="uploads/images/639220.jpg" alt="" class="d-block w-100">
            </button>
            <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="1" class="img-thumnail">
              <img src="uploads/images/639220.jpg" alt="" class="d-block w-100">
            </button>
            <button type="button" data-bs-target="#productGalleryCarousel" data-bs-slide-to="2" class="img-thumnail">
              <img src="uploads/images/639220.jpg" alt="" class="d-block w-100">
            </button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="uploads/images/639220.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="uploads/images/639220.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="uploads/images/639220.jpg" class="d-block w-100" alt="...">
            </div>
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
      <div class="col product-short-desc order-3">
        <p class="mb-0">RRP: <s>$2,199</s></p>
        <p class="fs-2 fw-bold">$1987
          <span class="fs-4">($212 OFF)</span>
        </p>
        <p>Colour: Natural Titanium</p>
        <p>Storage: 256GB</p>
        <input type="number" name="product-qty" class="form-control w-auto my-4" value="1">
        <a href="#" class="btn btn-primary d-block w-100" role="button">Add to Cart</a>
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
          <p>iPhone 15 Pro Max. Forged in
            titanium and featuring the
            groundbreaking A17 Pro chip, a
            customisable Action button and the
            most powerful iPhone camera system
            ever.</p>
          <ul>
            <li>Forged In Titanium. iPhone 15
              Pro Max has a strong and light
              aerospace-grade titanium design
              with a textured matt glass back.
              It also features a Ceramic Shield
              front that’s tougher than any
              smartphone glass. And it’s
              splash-, water- and dust-resistant
            </li>
          </ul>
        </div>
        <div class="tab-pane fade" id="specs-tab-pane" role="tabpanel" aria-labelledby="specs-tab" tabindex="0">
          <table class="table table-striped my-4">
            <tbody>
              <tr>
                <th scope="row">SKU</th>
                <td>639220</td>
              </tr>
              <tr>
                <th scope="row">Brand</th>
                <td>Apple</td>
              </tr>
              <tr>
                <th scope="row">Model</th>
                <td>iPhone 15 Pro Max</td>
              </tr>
              <tr>
                <th scope="row">MPN</th>
                <td>MU793ZP/A</td>
              </tr>
              <tr>
                <th scope="row">OS</th>
                <td>IOS 17</td>
              </tr>
              <tr>
                <th scope="row">Screen Size
                  (Inches)</th>
                <td>6.7</td>
              </tr>
              <tr>
                <th scope="row">Resolution
                  (Pixels)</th>
                <td>2796 x 1260</td>
              </tr>
              <tr>
                <th scope="row">Storage (GB)
                </th>
                <td>256</td>
              </tr>
              <tr>
                <th scope="row">RAM (GB)</th>
                <td>8</td>
              </tr>
              <tr>
                <th scope="row">Colour</th>
                <td>Natural Titanium</td>
              </tr>
              <tr>
                <th scope="row">CPU</th>
                <td>A17 Pro Chip with 6-core GPU
                </td>
              </tr>
              <tr>
                <th scope="row">Battery (mAh)
                </th>
                <td>4422</td>
              </tr>
              <tr>
                <th scope="row">Rear Camera (MP)
                </th>
                <td>48MP + 12MP + 12MP</td>
              </tr>
              <tr>
                <th scope="row">Front Camera
                  (MP)</th>
                <td>12MP</td>
              </tr>
              <tr>
                <th scope="row">Weight (kg)</th>
                <td>0.221</td>
              </tr>
              <tr>
                <th scope="row">Dimensions (mm)
                </th>
                <td>76.7W x 82.5D x 159.9H</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</main>
<?= loadPartial('footer') ?>