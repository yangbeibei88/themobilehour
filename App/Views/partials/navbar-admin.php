<div class="bg-dark border-bottom">
  <nav class="navbar navbar-expand-md bg-dark border-bottom py-0 top-navbar" data-bs-theme="dark">
    <div class="container">
      <ul class="navbar-nav d-flex flex-row flex-grow-1 justify-content-end">
        <li class="nav-item"><a href="" class="nav-link">Beibei</a>
        </li>
        <div class="vr"></div>
        <li class="nav-item"><a href="" class="nav-link">Admin</a>
        </li>
        <div class="vr"></div>
        <li class="nav-item"><a href="" class="nav-link">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- main nav -->
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col order-1">
        <a href="#" class="navbar-brand">
          <img src="<?= assetPath('assets/logo/the mobile hour logo-3-logo.png') ?>" alt="logo" width="120" height="auto">
        </a>
      </div>
      <div class="col order-2">
        <nav class="navbar navbar-expand-md bg-dark" data-bs-theme="dark">
          <div class="container d-flex justify-content-end">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasLabel">The Mobile
                  Hour Admin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav flex-grow-1 justify-content-center">
                  <li class="nav-item"><a class="nav-link" href="#">Administrators</a>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="#">Customers</a>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Categories</a>
                  </li>
                  <li class="nav-item"><a class="nav-link" href="#">Orders</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Changelogs</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</div>