<?= loadPartial('header', ['pageTitle' => 'The Mobile Hour']) ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('home-sliders') ?>

<!-- categories -->
<section id="categories">

  <div class="container my-5 text-center">
    <h2>Shop By Brand</h2>
    <div class="row row-cols-1 row-cols-sm-2 g-5 py-3">
      <?php foreach ($categories as $category) : ?>
        <div class="col">
          <div class="card">
            <a href="<?= assetPath('categories/' . $category->category_id) ?>">
              <?php if (!empty($category->category_img_path)) : ?>
                <img src="<?= $category->category_img_path ?>" class="card-img" alt="<?= $category->category_img_alt ?>">
              <?php else : ?>
                <img src="<?= assetPath('uploads/images/product-placeholder.jpeg') ?>" class="card-img" alt="<?= $category->category_name ?>">
              <?php endif; ?>
              <div class="card-img-overlay">
                <h3 class="card-title"><?= $category->category_name ?></h3>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <a href="categories" class="btn btn-primary d-block my-5" role="button">All
      Brands</a>
  </div>
</section>
<?= loadPartial('footer') ?>