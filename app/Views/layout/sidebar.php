<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
  <div class="sidebar-brand sidebar-brand-text align-items-center justify-content-center">SMKN5</div>

  <!-- Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="bi bi-speedometer2 fs-6"></i>
      <span>Dashboard</span></a>
  </li>

  <hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      aria-expanded="true" aria-controls="collapseTwo">
      <i class="bi bi-gear-fill fs-6"></i>
      <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Components:</h6>
        <a class="collapse-item" href="buttons.html">Buttons</a>
        <a class="collapse-item" href="cards.html">Cards</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
      aria-expanded="true" aria-controls="collapsePages">
      <i class="bi bi-folder-fill fs-6"></i>
      <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Login Screens:</h6>
        <a class="collapse-item" href="login.html">Login</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider my-0">
  <li class="nav-item">
    <a class="nav-link" href="<?= base_url('#'); ?>">
      <i class="bi bi-box-arrow-left fs-6"></i>
      <span>Logout</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>