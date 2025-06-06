<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
  <h1 class="h3 mb-4 text-gray-800 fw-bold"><?= $title; ?></h1>

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
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow border-0 rounded-4 bg-white position-relative overflow-hidden">
          <div class="position-absolute top-0 start-50 translate-middle-x bg-danger text-white p-3 rounded-bottom shadow-sm" style="width: max-content;">
            <i class="fas fa-calendar-times fa-lg me-2"></i> Hari Libur
          </div>
          <div class="card-body text-center mt-5">
            <h4 class="fw-bold text-danger mb-3">Yeay! Hari ini libur 🎉</h4>
            <p class="text-muted fs-6 mb-4">Tidak ada jadwal yang aktif karena saat ini adalah hari libur.</p>
            <div class="badge bg-success-subtle text-success fs-6 px-4 py-2 rounded-pill">
              Gunakan waktu ini untuk beristirahat & recharge semangatmu 💖
            </div>
          </div>
          <div class="card-footer text-center bg-white border-0 mt-3">
            <small class="text-muted">
              <?= date('l, d F Y'); ?>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<?= $this->endSection(); ?>