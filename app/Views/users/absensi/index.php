<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Absensi</li>
  </ol>

  <h1 class="h3 mb-4 text-gray-800 fw-bold">Daftar Hadir Siswa</h1>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card p-4 shadow-sm border border-dark">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
          <span class="badge bg-warning rounded-pill px-3 py-2 fs-6">Kelas X MM A</span>
          <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">Pertemuan Ke: 2</span>
        </div>

        <form action="<?= base_url('absensi/save') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <input type="date" name="tanggal" class="form-control bg-dark text-white" value="<?= date('Y-m-d') ?>">
          </div>

          <div class="mb-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
              <strong class="fs-6">1. ADORA ANNIDITA SALSABILA</strong>

              <div class="d-flex gap-3 flex-wrap">
                <?php
                $status = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
                foreach ($status as $key => $label) :
                ?>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="keterangan" value="<?= $label ?>" id="status_<?= $key ?>">
                    <label class="form-check-label" for="status_<?= $key ?>"><?= $key ?></label>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Selesai</button>
            <button type="submit" name="update" value="1" class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> Update Absensi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>