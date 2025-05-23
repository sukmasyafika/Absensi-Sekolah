<nav class="navbar navbar-expand navbar-light <?= in_groups('admin') ? 'bg-primary' : 'bg-light' ?> topbar mb-4 static-top shadow-lg <?= in_groups('admin') ? 'fixed-top' : '' ?>">

  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <a class="navbar-brand d-none d-md-block" href="https://smkn5jpr.sch.id/">
    <img src="<?= base_url('/assets/img/profil/LOGO-SEKOLAH.png'); ?>" alt="SMKN5" width="280">
  </a>

  <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-bell-fill <?= in_groups('admin') ? 'text-white' : 'text-dark' ?>"></i>
        <span class="badge badge-danger badge-counter">0</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notifikasi Pesan Masuk</h6>

        <div class="dropdown-item d-flex align-items-center">
          <div class="mr-3">
            <div class="icon-circle bg-info">
              <i class="fas fa-envelope text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">fdbfbd</div>
            <span class="font-weight-bold">fdbf</span>
          </div>
        </div>
        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Tidak ada pesan baru</a> -->
        <a class="dropdown-item text-center small text-gray-500" href="#">Tampilkan Semua Pesan</a>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline <?= in_groups('admin') ? 'text-white' : 'text-dark' ?> small"><?= user()->username; ?></span>
        <img class="img-profile rounded-circle"
          src=" <?= base_url('/assets/img/profil/random_profile.svg'); ?>">
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Settings
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>