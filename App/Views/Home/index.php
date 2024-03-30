<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('home-sliders') ?>

<!-- categories -->
<section id="categories">

  <div class="container my-5 text-center">
    <h2>Shop By Brand</h2>
    <div class="row row-cols-1 row-cols-sm-2 g-5">
      <?php foreach ($categories as $category) : ?>
        <div class="col">
          <div class="card">
            <a href="#">
              <img src="<?= $category->category_img_path ?>" class="card-img" alt="<?= $category->category_img_alt ?>">
              <div class="card-img-overlay">
                <h3 class="card-title"><?= $category->category_name ?></h3>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <a href="products" class="btn btn-primary d-block my-5" role="button">All
      Products</a>
  </div>
</section>
<?= loadPartial('footer') ?>