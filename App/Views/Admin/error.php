<?= loadPartial('header') ?>
<?= loadPartial('navbar-admin') ?>
<main>
  <div class="container py-4">
    <h2><?= $status . ": " . $message ?></h2>
    <p></p>
    <a type="button" class="btn btn-primary" href="<?= assetPath("admin/dashboard") ?>">Back to Dashboard</a>

  </div>
</main>
<?= loadPartial('footer') ?>