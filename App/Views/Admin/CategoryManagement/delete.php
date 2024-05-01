<?= loadPartial('header', [
  'pageTitle' => 'Delete Category'
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial(
  'pagetitle',
  [
    'pageTitle' => 'Delete Category'
  ]
) ?>
<main id="category-delete">
  <div class="container my-4">
    <div class="d-flex flex-column justify-content-center border rounded">
      <form method="POST" action="<?= urlPath('admin/category-management/destroy/') . $category->category_id ?>" id="category-delete-form" class="d-flex flex-column justify-content-center align-items-center p-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="80" fill="red"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
          <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
        </svg>
        <br>
        <p>Click confirm to delete the Category:
        </p>
        <p>Category Name: <strong><?= $category->category_name ?></strong></p>
        <p>Remove all products under the category before deletion.</p>
        <div class="d-flex gap-3">
          <a href="<?= assetPath('admin/category-management') ?>" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</main>
<?= loadPartial('footer') ?>