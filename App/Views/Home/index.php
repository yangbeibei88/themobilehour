<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('home-sliders') ?>

<!-- categories -->
<section id="categories">

  <div class="container my-5 text-center">
    <h2>Shop By Brand</h2>
    <div class="row row-cols-1 row-cols-sm-2 g-5">
      <div class="col">
        <div class="card">
          <a href="#">
            <img src="assets/images/apple.jpg" class="card-img" alt="">
            <div class="card-img-overlay">
              <h3 class="card-title">Apple</h3>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <a href="#">
            <img src="assets/images/samsung.jpg" class="card-img" alt="">
            <div class="card-img-overlay">
              <h3 class="card-title">Samsung
              </h3>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <a href="#">
            <img src="assets/images/motorola.jpg" class="card-img" alt="">
            <div class="card-img-overlay">
              <h3 class="card-title">Motorola
              </h3>
            </div>
          </a>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <a href="#">
            <img src="assets/images/googlePixel.jpg" class="card-img" alt="">
            <div class="card-img-overlay">
              <h3 class="card-title">Google</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
    <a href="$" class="btn btn-primary d-block my-5" role="button">All
      Products</a>
  </div>
</section>
<?= loadPartial('footer') ?>