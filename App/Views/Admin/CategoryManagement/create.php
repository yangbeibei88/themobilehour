<?= loadPartial('header', [
  'pageTitle' => 'Create Category'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', [
  'pageTitle' => 'Create Category'
]) ?>
<?= loadPartial('message') ?>
<main id="add-category">
  <div class="container my-4">
    <?php if (isset($errors)) : ?>
      <?php foreach ($errors as $error) : ?>
        <?php if (!empty($error)) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    <form action="/themobilehour/admin/category-management" method="POST" enctype="multipart/form-data" id="form-category">
      <div class="accordion" id="categoryAccordion">
        <div class="accordion-item">
          <div class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#categoryPanel" aria-expanded="true" aria-controls="categoryPanel">
              <h2 class="fs-5">Category
                Information</h2>
            </button>
          </div>
          <div id="categoryPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="row mb-3">
                <label for="category-name" class="col-2 col-form-label">Category
                  Name</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="category_name" id="category-name" class="form-control" value="<?= $categoryData['category_name'] ?? '' ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="category-desc" class="col-2 col-form-label">Category
                  Description</label>
                <div class="col-10 col-md-6">
                  <textarea name="category_desc" id="category-desc" rows="15" class="form-control"><?= $categoryData['category_desc'] ?? '' ?></textarea>
                </div>
              </div>
              <div class="row mb-3 form-check form-switch">
                <div class="col-10">
                  <label for="displayOnNav" class="form-check-label">Display on navigation</label>
                  <input type="checkbox" class="form-check-input" role="switch" id="displayOnNav" name="is_active" value="1" <?= isset($categoryData['is_active']) && ($categoryData['is_active'] == 1) ? 'checked' : '' ?>>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-10">
                  <div class="input-group">
                    <label for="category-image" class="input-group-text">Upload Category Image</label>
                    <input type="file" name="category_img_path" id="category-image" accept="image/*" class="form-control">
                    <label class="input-group-text" for="category_img_alt">Alt-text</label>
                    <input type="text" name="category_img_alt" id="category_img_alt" class="form-control" value="<?= $categoryData['category_img_alt'] ?? '' ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center my-5 action-buttons">
        <div class="col-6 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary w-25">Submit</button>
        </div>
        <div class="col-6 d-flex justify-content-start">
          <a href="<?= assetPath("admin/category-management") ?>" class="btn btn-secondary w-25">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</main>
<?= loadPartial('footer') ?>