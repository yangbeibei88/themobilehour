<?= loadPartial('header') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('breadcrumb') ?>
<main>
  <div class="container py-4">
    <h2><?= $status . ": " . $message ?></h2>
    <p></p>
    <a type="button" class="btn btn-primary" href="<?= assetPath("home") ?>">Go back
      home</a>

  </div>
</main>
<?= loadPartial('footer') ?>