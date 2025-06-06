<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">

    <div class="col-xl-8 col-md-6 mb-4 d-flex">
      <div class="card shadow mb-4">
        <div class="card-header">
          <h5 class="card-title text-success mb-0 fw-bold">Laporan Absensi</h5>
        </div>
        <div class="card-body">

          <form method="GET" action="<?= base_url('laporan/absensi'); ?>" class="mb-4 row g-3 align-items-center">

            <div class="col-md-6">
              <label for="rombel_id" class="form-label small fw-bold">Kelas</label>
              <select name="rombel_id" id="rombel_id" class="form-select form-select-sm">
                <option value="">-- Semua Kelas --</option>

              </select>
            </div>

            <div class="col-md-6">
              <label for="mapel" class="form-label small fw-bold">Mata Pelajaran</label>
              <select name="mapel" id="mapel" class="form-select form-select-sm">
                <option value="">-- Semua Mapel --</option>

              </select>
            </div>

            <div class="col-md-6">
              <label for="semester" class="form-label small fw-bold">Semester</label>
              <select name="semester" id="semester" class="form-select form-select-sm">
                <option value="">-- Semua Semester --</option>
                <option value="1" <?= (old('semester', $filter['semester'] ?? '') == '1') ? 'selected' : '' ?>>1</option>
                <option value="2" <?= (old('semester', $filter['semester'] ?? '') == '2') ? 'selected' : '' ?>>2</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="bulan" class="form-label small fw-bold">Bulan</label>
              <select name="bulan" id="bulan" class="form-select form-select-sm">
                <option value="">-- Semua Bulan --</option>

              </select>
            </div>

            <div class="mb-3 align-self-end">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </form>

          <div class="justify-content-between">
            <a href="<?= base_url('laporan/siswa/excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-success btn-sm" title="Export Excel">
              <i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel
            </a>
            <a href="<?= base_url('laporan/siswa/pdf?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-danger btn-sm" title="Export PDF">
              <i class="bi bi-file-earmark-pdf-fill"></i> PDF
            </a>
            <a href="<?= base_url('laporan/siswa/print?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="btn btn-secondary btn-sm" title="Cetak">
              <i class="bi bi-printer-fill"></i> Cetak
            </a>
          </div>

          <!-- <div class="btn-group" role="group" aria-label="Export Buttons">
            <a href="<?= base_url('laporan/absensi/excel?' . http_build_query($filter ?? [])); ?>" class="btn btn-sm btn-success" title="Export Excel">
              <i class="bi bi-file-earmark-excel-fill"></i>
            </a>
            <a href="<?= base_url('laporan/absensi/pdf?' . http_build_query($filter ?? [])); ?>" class="btn btn-sm btn-danger" title="Export PDF">
              <i class="bi bi-file-earmark-pdf-fill"></i>
            </a>
            <a href="<?= base_url('laporan/absensi/print?' . http_build_query($filter ?? [])); ?>" target="_blank" class="btn btn-sm btn-secondary" title="Cetak">
              <i class="bi bi-printer-fill"></i>
            </a>
          </div> -->
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-header">
          <h5 class="card-title text-primary mb-0 fw-bold">Laporan Siswa</h5>
        </div>
        <div class="card-body">

          <form action="<?= base_url('laporan/siswa'); ?>" method="GET" class="mb-4 row g-3 align-items-center">
            <div class="col-md-6 mb-3">
              <label for="kelasRombel" class="form-label fw-bold small fw-bold">Kelas</label>
              <select name="kelas_rombel" id="kelasRombel" class="form-select form-select-sm">
                <option value="">-- Semua Kelas --</option>

              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="jurusan" class="form-label small fw-bold">Jurusan</label>
              <select name="jurusan" id="jurusan" class="form-select form-select-sm">
                <option value="">-- Semua Jurusan --</option>

              </select>
            </div>

            <button type="submit" class="btn btn-primary btn-sm mb-3">Terapkan Filter</button>
          </form>

          <div class="justify-content-between">
            <a href="<?= base_url('laporan/siswa/excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-success btn-sm" title="Export Excel">
              <i class="bi bi-file-earmark-spreadsheet-fill"></i> Excel
            </a>
            <a href="<?= base_url('laporan/siswa/pdf?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-danger btn-sm" title="Export PDF">
              <i class="bi bi-file-earmark-pdf-fill"></i> PDF
            </a>
            <a href="<?= base_url('laporan/siswa/print?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="btn btn-secondary btn-sm" title="Cetak">
              <i class="bi bi-printer-fill"></i> Cetak
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>