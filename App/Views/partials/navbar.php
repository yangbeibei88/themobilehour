<?php

use Framework\Session;
use App\Models\Category;

$categoryModel = new Category();
$categories = $categoryModel->getAllActiveCategories();
?>
<!-- top nav for user login / register -->
<div class="bg-dark border-bottom">
  <!-- top-navbar -->
  <nav class="navbar navbar-expand-md bg-dark border-bottom py-0 top-navbar" data-bs-theme="dark">
    <div class="container">
      <ul class="navbar-nav d-flex flex-row flex-grow-1 justify-content-end">
        <?php if (Session::has('adminUser')) : ?>
          <li class="nav-item"><a href="<?= assetPath("admin/auth/account/show/" . Session::get('adminUser')['id']) ?>" class="nav-link"><?= Session::get('adminUser')['firstname'] ?></a>
          </li>
          <div class="vr"></div>
          <li class="nav-item"><a href="<?= assetPath('admin/dashboard') ?>" class="nav-link"><?= Session::get('adminUser')['role'] ?></a>
          </li>
          <div class="vr"></div>
          <!-- <li class="nav-item"><a href="" class="nav-link">Logout</a> -->
          <form method="POST" action="/themobilehour/admin/auth/logout" class="nav-item mb-0">
            <button type="submit" class="nav-link">Logout</button>
          </form>
        <?php else : ?>
          <li class="nav-item"><a href="<?= assetPath('admin/auth/login') ?>" class="nav-link">Admin Login</a>
          <?php endif; ?>
      </ul>
    </div>
  </nav>
  <!-- main nav -->
  <nav class="navbar navbar-expand-md bg-dark border-bottom border-body main-navbar" data-bs-theme="dark">
    <div class="container">
      <a href="<?= assetPath('home') ?>" class="navbar-brand"><img src="<?= assetPath('assets/logo/the mobile hour logo-3-logo.png') ?>" alt="logo" width="100" height="auto"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasLabel">The Mobile
            Hour
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center me-3">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                All Brands</a>
              <ul class="dropdown-menu">
                <?php foreach ($categories as $category) : ?>
                  <li><a href="#" class="dropdown-item"><?= $category->category_name ?></a></li>
                <?php endforeach; ?>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="<?= assetPath('products') ?>"> Shop</a>
            </li>
          </ul>
          <form method="GET" action="<?= assetPath("products/search") ?>" class="d-flex flex-grow-1 justify-content-center" data-bs-theme="light" role="search">
            <input type="search" class="form-control" name="term" placeholder="Search by product name or SKU" aria-label="Search" value="<?= $term ?? '' ?>">
          </form>
        </div>
      </div>
    </div>
  </nav>
</div>