<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
  <h1 class="h3 mb-4 text-gray-800 fw-bold">Dashboard</h1>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="position-fixed top-0 end-0 pe-3 pt-4 mt-5" style="z-index: 1055">
      <div id="toastPesan" class="toast align-items-center text-bg-danger border shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body flex-grow-1">
            <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error'); ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 my-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="position-fixed top-0 end-0 pe-3 pt-4 mt-5" style="z-index: 1055">
      <div id="toastPesan" class="toast align-items-center text-bg-success border shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body flex-grow-1">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success'); ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 my-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-bottom-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Guru</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalGuru; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-person-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Siswa</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalSiswa; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-people-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pengguna</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUser; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-clipboard2-check-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Kelas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalKelas; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-journal-bookmark-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jadwal</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalJadwal; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-calendar-week-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Jurusan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalJurusan; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-diagram-3-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Mata Pelajaran</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalMapel; ?></div>
            </div>
            <div class="col-auto">
              <i class="bi bi-book-fill fs-2 text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>