<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Siswa</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
  </ol>

  <h1 class="h3 mb-4 text-gray-800 fw-bold"><?= $title ?></h1>

  <div class="card shadow mb-4 border-0">
    <div class="card-header py-3 bg-primary text-white">
      <h5 class="m-0 fw-bold text-uppercase"><i class="bi bi-person-fill"></i> Detail Siswa</h5>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <p><strong>Nama Lengkap:</strong> <?= esc($siswa->nama); ?></p>
          <p><strong>NISN:</strong> <?= esc($siswa->nisn); ?></p>
          <p><strong>Tanggal Lahir:</strong> <?= esc($siswa->tanggal_lahir); ?></p>
          <p><strong>Jenis Kelamin:</strong> <?= esc($siswa->jenis_kelamin); ?></p>
        </div>
        <div class="col-md-6">
          <p><strong>Kelas:</strong> <?= esc($siswa->kelas_name . ' ' . $siswa->jurusan_name . ' ' . $siswa->rombel); ?></p>
          <p><strong>Agama:</strong> <?= esc($siswa->agama); ?></p>
          <p><strong>Tahun Masuk:</strong> <?= esc($siswa->thn_masuk); ?></p>
          <p><strong>Status:</strong> <?= esc($siswa->status); ?></p>
        </div>
      </div>

      <a href="<?= base_url('/siswa'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left-square"></i> Kembali
      </a>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>