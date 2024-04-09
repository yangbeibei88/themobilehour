<?php

use Framework\Session; ?>

<div class="container">
  <?php $successMessage = Session::getFlashMessage('success_message'); ?>
  <?php if ($successMessage !== null) : ?>
    <div class="alert alert-success" role="alert">
      <?= $successMessage ?>
    </div>
  <?php endif; ?>
  <?php $errorMessage = Session::getFlashMessage('error_message'); ?>
  <?php if ($errorMessage !== null) : ?>
    <div class="alert alert-danger" role="alert">
      <?= $errorMessage ?>
    </div>
  <?php endif; ?>
</div>