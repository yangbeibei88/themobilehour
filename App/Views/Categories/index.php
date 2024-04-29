<?= loadPartial('header', ['pageTitle' => 'All Brands | The Mobile Hour']) ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'All Brands']) ?>

<!-- categories -->
<main id="categories" class="flex-fill">
  <div class="container my-5 text-center">
    <div class="row row-cols-2 row-cols-md-3 g-5">
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
  </div>
</main>
<?= loadPartial('footer') ?>