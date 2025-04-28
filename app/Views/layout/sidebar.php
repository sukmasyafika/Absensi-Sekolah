<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <div class="sidebar-brand sidebar-brand-text align-items-center justify-content-center">SI - ABSENSI</div>
  <hr class="sidebar-divider">

  <!-- Dashboard -->
  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('/'); ?>">
      <i class="bi bi-speedometer2 fs-5"></i>
      <span class="fs-6">Dashboard</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('user'); ?>">
      <i class="bi bi-person-plus-fill fs-5"></i>
      <span class="fs-6">Pengguna</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('guru'); ?>">
      <i class="bi bi-person-workspace fs-5"></i>
      <span class="fs-6">Guru</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('siswa'); ?>">
      <i class="bi bi-people fs-5"></i>
      <span class="fs-6">Siswa</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
      aria-expanded="true" aria-controls="collapseTwo">
      <i class="bi bi-book-half fs-5"></i>
      <span class="fs-6">Akademik</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Utama:</h6>
        <a class="collapse-item" href="<?= base_url('kelas'); ?>">Kelas</a>
        <a class="collapse-item" href="<?= base_url('thnajaran'); ?>">Tahun Pelajaran</a>
        <a class="collapse-item" href="<?= base_url('mapel'); ?>">Mata Pelajaran</a>
        <a class="collapse-item" href="<?= base_url('wakel'); ?>">Wali Kelas</a>
      </div>
    </div>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('jadwal'); ?>">
      <i class="bi bi-calendar-week fs-5"></i>
      <span class="fs-6">Jadwal Mengajar</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('laporan'); ?>">
      <i class="bi bi-file-earmark-text fs-5"></i>
      <span class="fs-6">Laporan</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('setting'); ?>">
      <i class="bi bi-gear-fill fs-5"></i>
      <span class="fs-6">Setting</span></a>
  </li>

  <li class="nav-item fw-bold">
    <a class="nav-link" href="<?= base_url('logout'); ?>">
      <i class="bi bi-box-arrow-left fs-5"></i>
      <span class="fs-6">Logout</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>