<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Siswa</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
  </ol>

  <h1 class="h3 mb-3 text-gray-800 fw-bold"><?= $title ?></h1>

  <img src="<?= base_url('assets/img/guru/' . $guru->foto); ?>" alt="<?= $guru->nama; ?>">

  <h3 class="text-uppercase">Nama lengkap <?= esc($guru->nama); ?></h3>
  <h3 class="text-uppercase">NIP: <?= esc($guru->nip); ?></h3>
  <h3 class="text-uppercase">Jabatan: <?= esc($guru->jabatan); ?></h3>
  <h3 class="text-uppercase">Tanggal Lahir: <?= esc($guru->tanggal_lahir); ?></h3>
  <h3 class="text-uppercase">jenis Kelamin: <?= esc($guru->jenis_kelamin); ?></h3>
  <h3 class="text-uppercase">agama: <?= esc($guru->agama); ?></h3>
  <h3 class="text-uppercase">tahun masuk: <?= esc($guru->thn_masuk); ?></h3>
  <h3 class="text-uppercase">status: <?= esc($guru->status); ?></h3>

  <a href="<?= base_url('/guru'); ?>" class="btn btn-secondary me-3">
    <i class="bi bi-arrow-left-square"></i> Kembali
  </a>

</div>

<?= $this->endSection(); ?>