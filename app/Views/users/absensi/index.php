<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Absensi</li>
  </ol>

  <h1 class="h3 mb-4 text-gray-800 fw-bold">Daftar Hadir Siswa</h1>

  <div class="card p-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-dark btn-sm">Kelas</button>
      <span class="badge bg-primary">Pertemuan Ke: 2</span>
    </div>

    <form action="<?= base_url('absensi/simpan') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <input type="date" name="tanggal" class="form-control bg-dark text-white" value="<?= date('Y-m-d') ?>">
      </div>

      <div class="mb-3">
        <strong class="text-success">ADORA ANNIDITA SALSABILA</strong>
        <div class="d-flex gap-3 mt-2">
          <?php
          $status = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];
          foreach ($status as $key => $label) :
          ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="keterangan" value="<?= $label ?>" id="status_<?= $key ?>">
              <label class="form-check-label" for="status_<?= $key ?>"><?= $key ?></label>
            </div>
          <?php endforeach ?>
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Selesai</button>
        <button type="submit" name="update" value="1" class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> Update Absensi</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>