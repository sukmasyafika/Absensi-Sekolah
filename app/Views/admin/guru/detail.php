<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Guru</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
  </ol>

  <h1 class="h3 mb-3 text-gray-800 fw-bold"><?= $title ?></h1>

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body text-center">
      <img src="<?= base_url('assets/img/guru/' . (!empty($guru->foto) ? $guru->foto : 'default.png')); ?>"
        alt="<?= esc($guru->nama); ?>"
        class="img-thumbnail rounded-circle mb-3"
        style="width: 150px; height: 150px; object-fit: cover;">

      <h4 class="text-primary text-uppercase fw-bold"><?= esc($guru->nama); ?></h4>
      <p class="text-muted mb-4"><?= esc($guru->jabatan); ?></p>
    </div>

    <div class="card-body">
      <div class="row g-4">
        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>NIP:</strong> <?= esc($guru->nip); ?></li>
            <li class="list-group-item"><strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($guru->tanggal_lahir)); ?></li>
            <li class="list-group-item"><strong>Jenis Kelamin:</strong> <?= esc($guru->jenis_kelamin); ?></li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Agama:</strong> <?= esc($guru->agama); ?></li>
            <li class="list-group-item"><strong>Tahun Masuk:</strong> <?= esc($guru->thn_masuk); ?></li>
            <li class="list-group-item"><strong>Status:</strong> <?= esc($guru->status); ?></li>
          </ul>
        </div>
      </div>

      <div class="mt-4 text-end">
        <a href="<?= base_url('/guru'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left-square me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>


</div>

<?= $this->endSection(); ?>