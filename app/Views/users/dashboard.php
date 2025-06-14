<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">
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

  <div class="container-fluid px-4">
    <h3 class="mb-4 text-dark fw-bold">
      <i class="fas fa-calendar-alt me-2 text-primary"></i>Jadwal Mengajar Hari Ini <?= date('l, d F Y'); ?>
    </h3>

    <?php if (!empty($libur)): ?>
      <div class="col-md-12">
        <div class="card shadow border-0 rounded-4 bg-white position-relative overflow-hidden">
          <div class="position-absolute top-0 start-50 translate-middle-x bg-danger text-white p-3 rounded-bottom shadow-sm" style="width: max-content;">
            <i class="fas fa-calendar-times fa-lg me-2"></i> Tanggal Merah <?= esc($libur->nama_libur) ?>
          </div>
          <div class="card-body text-center mt-5">
            <h4 class="fw-bold text-danger mb-3">Yeay! Hari ini libur</h4>
            <p class="text-muted fs-6 mb-4">Tidak ada jadwal yang aktif karena <?= esc($libur->keterangan) ?></p>
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
    <?php else: ?>

      <?php if (!empty($jadwalHariIni)): ?>
        <div class="row g-4">
          <?php $warnaList = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
          $i = 0; ?>
          <?php foreach ($jadwalHariIni as $jadwal): ?>
            <?php $warna = $warnaList[$i++ % count($warnaList)]; ?>
            <div class="col-xl-4 col-md-6">
              <div class="card border-start-<?= $warna ?> shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                  <div>
                    <div class="text-<?= $warna ?> text-uppercase fw-bold mb-1"><?= esc($jadwal->nama_mapel) ?></div>
                    <h6 class="fw-semibold mb-2">Kelas : <?= esc("{$jadwal->nama_kls} {$jadwal->jurusan} {$jadwal->rombel}") ?></h6>
                    <div class="text-dark fw-semibold mb-1">
                      Jam: <?= date('H:i', strtotime($jadwal->jam_mulai)) ?> - <?= date('H:i', strtotime($jadwal->jam_selesai)) ?>
                    </div>
                    <div class="text-dark fw-semibold">Ruangan : <?= esc($jadwal->ruangan) ?></div>
                  </div>
                  <i class="fas fa-book-open fa-3x text-<?= $warna ?>"></i>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center my-3">
          <div class="card shadow border-0 rounded-4 p-4 bg-light-subtle">
            <div class="card-body">
              <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
              <h4 class="fw-bold text-success">Tidak Ada Jadwal Hari Ini</h4>
              <p class="text-muted mb-2">Silakan gunakan waktu ini untuk beristirahat dan mempersiapkan hari esok</p>
              <span class="badge bg-success-subtle text-success fw-semibold rounded-pill px-3 py-2">
                <?= date('l, d F Y'); ?>
              </span>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($rekapAbsensi)): ?>
        <h3 class="mt-5 ps-3 fw-bold border-bottom pb-2">Rekap Absensi Hari Ini</h3>
        <div class="row g-4">
          <?php foreach ($jadwalHariIni as $jadwal): ?>
            <div class="col-md-6 col-xl-4">
              <div class="card shadow h-100 border-start-primary">
                <div class="card-body">
                  <h5 class="fw-bold mb-2 text-primary"><?= esc($jadwal->nama_mapel) ?></h5>
                  <p class="mb-2 text-muted">Kelas: <?= esc("{$jadwal->nama_kls} {$jadwal->jurusan} {$jadwal->rombel}") ?></p>

                  <?php if (isset($rekapAbsensi[$jadwal->id])): ?>
                    <?php $rekap = $rekapAbsensi[$jadwal->id]; ?>
                    <div class="d-flex flex-wrap gap-2 justify-content-start mt-3">
                      <span class="badge bg-success fs-6 d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Hadir: <?= $rekap->Hadir ?>
                      </span>
                      <span class="badge bg-warning text-dark fs-6 d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-user-clock me-2"></i> Izin: <?= $rekap->Izin ?>
                      </span>
                      <span class="badge bg-info text-dark fs-6 d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-notes-medical me-2"></i> Sakit: <?= $rekap->Sakit ?>
                      </span>
                      <span class="badge bg-danger fs-6 d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-times-circle me-2"></i> Alpa: <?= $rekap->Alpa ?>
                      </span>
                      <span class="badge bg-secondary fs-6 d-flex align-items-center px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-users me-2"></i> Total Siswa: <?= $rekap->total ?>
                      </span>
                    </div>
                  <?php else: ?>
                    <div class="alert alert-light mt-3 mb-0 text-center fs-6">
                      <i class="fas fa-info-circle me-2"></i> Belum Di Absen untuk jadwal hari ini. Silahkan Absen Terlebih Dahulu
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>

</div>

<?= $this->endSection(); ?>