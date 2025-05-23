<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Siswa</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
  </ol>

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header py-4 bg-primary text-white rounded-top-4">
      <h5 class="m-0 fw-bold text-uppercase"><i class="bi bi-person-badge-fill me-2"></i> <?= $title; ?></h5>
    </div>
    <div class="card-body">
      <div class="row g-4">
        <div class="col-md-6 text-capitalize">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <strong>Nama Lengkap:</strong> <?= esc($siswa->nama); ?>
            </li>
            <li class="list-group-item">
              <strong>NISN:</strong> <?= esc($siswa->nisn); ?>
            </li>
            <li class="list-group-item">
              <strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($siswa->tanggal_lahir)); ?>
            </li>
            <li class="list-group-item">
              <strong>Jenis Kelamin:</strong> <?= esc($siswa->jenis_kelamin); ?>
            </li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <strong>Kelas:</strong> <?= esc($siswa->kelas_name . ' ' . $siswa->jurusan_name . ' ' . $siswa->rombel); ?>
            </li>
            <li class="list-group-item">
              <strong>Agama:</strong> <?= esc($siswa->agama); ?>
            </li>
            <li class="list-group-item">
              <strong>Tahun Masuk:</strong> <?= esc($siswa->thn_masuk); ?>
            </li>
            <li class="list-group-item">
              <strong>Status:</strong> <?= esc($siswa->status); ?>
            </li>
          </ul>
        </div>
      </div>

      <div class="text-end mt-4">
        <a href="<?= base_url('/siswa'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left-square me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>


</div>

<?= $this->endSection(); ?>