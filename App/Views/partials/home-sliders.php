<!-- Home sliders, using BS carousel -->
<section id="homeCarousel" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/images/Apple-iPhone-15-Pro-lineup-hero-230912.jpg.landing-big_2x.jpg" class="d-block w-100" height="500" alt="">
      <div class="carousel-caption text-start" style="bottom: 30%;">
        <h1>iPhone 15 Pro Max Arrival</h1>
        <a href="<?= assetPath('products/1') ?>" class="btn btn-primary">Buy Now &gt;</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/images/hero-image_go-epic-with-samsungs-new-galaxy-s24-range.jpg" class="d-block w-100" height="500" alt="...">
      <div class="carousel-caption text-start" style="bottom: 30%;">
        <h1>New Galaxy S24 Series</h1>
        <a href="<?= assetPath('products/29') ?>" class="btn btn-primary">Buy Now &gt;</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</section>