<div class="container">
  <?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success" role="alert">
      <?= $_SESSION['success_message'] ?>
    </div>
    <?php unset($_SESSION['success_message']) ?>
  <?php endif; ?>
  <?php if (isset($_SESSION['error_message'])) : ?>
    <div class="alert alert-danger" role="alert">
      <?= $_SESSION['error_message'] ?>
    </div>
    <?php unset($_SESSION['error_message']) ?>
  <?php endif; ?>
</div>