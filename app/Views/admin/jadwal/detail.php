<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item"><a href="<?= base_url('jadwal'); ?>" class="text-decoration-none">Jadwal</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
  </ol>

  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="m-0 fw-bold text-uppercase">
        <i class="bi bi-calendar-week-fill me-2"></i> <?= $title; ?>
      </h5>
    </div>

    <div class="card-body">
      <div class="row g-4">
        <div class="col-md-6 text-capitalize">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class="bi bi-person-fill text-primary me-2"></i>
              <strong>Guru Pengajar:</strong> <?= esc($jadwal->guru); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-journal-text text-success me-2"></i>
              <strong>Mata Pelajaran:</strong> <?= esc($jadwal->mapel); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-people-fill text-warning me-2"></i>
              <strong>Kelas:</strong> <?= esc($jadwal->kelas . ' ' . $jadwal->jurusan . ' ' . $jadwal->rombel); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-calendar-range text-danger me-2"></i>
              <strong>Tahun Ajaran:</strong> <?= esc($jadwal->semester . ' - ' . $jadwal->tahun); ?>
            </li>
          </ul>
        </div>

        <div class="col-md-6">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class="bi bi-door-open-fill text-secondary me-2"></i>
              <strong>Ruangan:</strong> <?= esc($jadwal->ruangan); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-calendar-day-fill text-info me-2"></i>
              <strong>Hari:</strong> <?= esc($jadwal->hari); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-clock-history text-dark me-2"></i>
              <strong>Jam Ke:</strong> <?= esc($jadwal->jam_ke); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-alarm-fill text-danger me-2"></i>
              <strong>Waktu:</strong> <?= esc(date('H:i', strtotime($jadwal->jam_mulai)) . ' - ' . date('H:i', strtotime($jadwal->jam_selesai))); ?>
            </li>
            <li class="list-group-item">
              <i class="bi bi-check-circle-fill text-success me-2"></i>
              <strong>Status:</strong> <?= esc($jadwal->status); ?>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-4 text-end">
        <a href="<?= base_url('/jadwal'); ?>" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left-square me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>