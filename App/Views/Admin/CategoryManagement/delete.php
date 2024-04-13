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

    <form method="POST" action="/themobilehour/admin/category-management/destroy/<?= $category->category_id ?>" id="category-delete-form">
      <!-- <h1>Delete Category</h1> -->
      <p>Click confirm to delete the Category:
      </p>
      <p>Category Name: <strong><?= $category->category_name ?></strong></p>
      <div class="border border-danger rounded my-3">
        <p>Deleting the category won't delete products.</p>
      </div>

      <a href="<?= assetPath('admin/category-management') ?>" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-danger">Confirm</button>
    </form>
  </div>
</main>
<?= loadPartial('footer') ?>