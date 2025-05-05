<?php $uri = service('uri');
$segment1 = $uri->getSegment(1, '');
$segment2 = $uri->getSegment(2, '');
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <div class="sidebar-brand sidebar-brand-text align-items-center justify-content-center">SI - ABSENSI</div>
  <hr class="sidebar-divider">

  <li class="nav-item fw-bold <?= $segment1 == 'dashboard' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('dashboard'); ?>">
      <i class="bi bi-speedometer2 fs-5"></i>
      <span class="fs-6">Dashboard</span></a>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'user' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('user'); ?>">
      <i class="bi bi-person-plus-fill fs-5"></i>
      <span class="fs-6">Pengguna</span></a>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'guru' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('guru'); ?>">
      <i class="bi bi-person-workspace fs-5"></i>
      <span class="fs-6">Guru</span></a>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'siswa' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('siswa'); ?>">
      <i class="bi bi-people fs-5"></i>
      <span class="fs-6">Siswa</span></a>
  </li>

  <?php $akademikOpen = ($segment1 == 'akademik'); ?>
  <li class="nav-item fw-bold <?= $akademikOpen ? 'active' : '' ?>">
    <a class="nav-link <?= $akademikOpen ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
      aria-expanded="<?= $akademikOpen ? 'true' : 'false' ?>" aria-controls="collapseTwo">
      <i class="bi bi-book-half fs-5"></i>
      <span class="fs-6">Akademik</span>
    </a>
    <div id="collapseTwo" class="collapse  <?= $akademikOpen ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Data Utama:</h6>
        <a class="collapse-item <?= $segment2 == 'kelas' ? 'active' : '' ?>" href="<?= base_url('akademik/kelas'); ?>">Kelas</a>
        <a class="collapse-item <?= $segment2 == 'thnajaran' ? 'active' : '' ?>" href="<?= base_url('akademik/thnajaran'); ?>">Tahun Pelajaran</a>
        <a class="collapse-item <?= $segment2 == 'mapel' ? 'active' : '' ?>" href="<?= base_url('akademik/mapel'); ?>">Mata Pelajaran</a>
        <a class="collapse-item <?= $segment2 == 'jurusan' ? 'active' : '' ?>" href="<?= base_url('akademik/jurusan'); ?>">Jurusan</a>
      </div>
    </div>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'jadwal' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('jadwal'); ?>">
      <i class="bi bi-calendar-week fs-5"></i>
      <span class="fs-6">Jadwal Mengajar</span></a>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'laporan' ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('laporan'); ?>">
      <i class="bi bi-file-earmark-text fs-5"></i>
      <span class="fs-6">Laporan</span></a>
  </li>

  <li class="nav-item fw-bold <?= $segment1 == 'setting' ? 'active' : '' ?>">
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