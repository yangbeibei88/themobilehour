<div class="container">
  <?php if (isset($_SESSION['success_product_delete_message'])) : ?>
    <div class="alert alert-success" role="alert" id="product-success-delete-message">
      <?= $_SESSION['success_product_delete_message'] ?>
    </div>
    <?php unset($_SESSION['success_product_delete_message']) ?>
  <?php endif; ?>
  <?php if (isset($_SESSION['error_message'])) : ?>
    <div class="alert alert-danger" role="alert" id="error-message">
      <?= $_SESSION['error_message'] ?>
    </div>
    <?php unset($_SESSION['error_message']) ?>
  <?php endif; ?>
</div>