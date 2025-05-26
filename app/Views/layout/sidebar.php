<?php $uri = service('uri');
$segment1 = $uri->getSegment(1);
?>

<ul class="navbar-nav   <?php if (in_groups('admin')) : ?> 
    bg-gradient-primary 
  <?php else : ?> 
    bg-gradient-danger 
  <?php endif; ?>  sidebar sidebar-dark accordion <?php if (in_groups('admin')) : ?>  mt-5 pt-5 <?php endif; ?> " id="accordionSidebar">

  <?php if (in_groups('admin')) : ?>
    <li class="nav-item <?= $segment1 == 'dashboard' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('dashboard'); ?>">
        <i class="bi bi-speedometer fs-5"></i>
        <span class="fs-6">Dashboard</span></a>
    </li>

    <li class="nav-item <?= $segment1 == 'user' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('user'); ?>">
        <i class="bi bi-person-plus-fill fs-5"></i>
        <span class="fs-6">Pengguna</span></a>
    </li>

    <li class="nav-item <?= $segment1 == 'guru' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('guru'); ?>">
        <i class="bi bi-person-workspace fs-5"></i>
        <span class="fs-6">Guru</span></a>
    </li>

    <li class="nav-item <?= $segment1 == 'siswa' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('siswa'); ?>">
        <i class="bi bi-people fs-5"></i>
        <span class="fs-6">Siswa</span></a>
    </li>

    <?php $akademikOpen = in_array($segment1, ['kelas', 'thnajaran', 'mapel', 'jurusan']); ?>
    <li class="nav-item <?= $akademikOpen ? 'active fw-bold' : '' ?>">
      <a class="nav-link <?= $akademikOpen ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="<?= $akademikOpen ? 'true' : 'false' ?>" aria-controls="collapseTwo">
        <i class="bi bi-book-half fs-5"></i>
        <span class="fs-6">Akademik</span>
      </a>
      <div id="collapseTwo" class="collapse <?= $akademikOpen ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Data Utama:</h6>
          <a class="collapse-item <?= $segment1 == 'kelas' ? 'active fw-bold' : '' ?>" href="<?= base_url('kelas'); ?>">Kelas</a>
          <a class="collapse-item <?= $segment1 == 'thnajaran' ? 'active fw-bold' : '' ?>" href="<?= base_url('thnajaran'); ?>">Tahun Pelajaran</a>
          <a class="collapse-item <?= $segment1 == 'mapel' ? 'active fw-bold' : '' ?>" href="<?= base_url('mapel'); ?>">Mata Pelajaran</a>
          <a class="collapse-item <?= $segment1 == 'jurusan' ? 'active fw-bold' : '' ?>" href="<?= base_url('jurusan'); ?>">Jurusan</a>
        </div>
      </div>
    </li>

    <li class="nav-item <?= $segment1 == 'jadwal' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('jadwal'); ?>">
        <i class="bi bi-calendar-week fs-5"></i>
        <span class="fs-6">Jadwal Mengajar</span></a>
    </li>

    <li class="nav-item <?= $segment1 == 'laporan' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('laporan'); ?>">
        <i class="bi bi-file-earmark-text fs-5"></i>
        <span class="fs-6">Laporan</span></a>
    </li>
  <?php endif; ?>

  <?php if (in_groups('guru')) : ?>
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-user-shield"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Guru</div>
    </a>

    <li class="nav-item <?= $segment1 == 'dashguru' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('dashguru'); ?>">
        <i class="bi bi-speedometer fs-5"></i>
        <span class="fs-6">Dashboard</span></a>
    </li>

    <li class="nav-item <?= $segment1 == 'profil' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('profil'); ?>">
        <i class="bi bi-person-circle fs-5"></i>
        <span class="fs-6">Profil</span>
      </a>
    </li>

    <li class="nav-item <?= $segment1 == 'absensi' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('absensi'); ?>">
        <i class="bi bi-calendar-check fs-5"></i>
        <span class="fs-6">Absensi Siswa</span>
      </a>
    </li>

    <li class="nav-item <?= $segment1 == 'laporan' ? 'active fw-bold' : '' ?>">
      <a class="nav-link" href="<?= base_url('laporan'); ?>">
        <i class="bi bi-clipboard-data fs-5"></i>
        <span class="fs-6">Rekap Absensi</span>
      </a>
    </li>
  <?php endif; ?>

  <li class="nav-item">
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