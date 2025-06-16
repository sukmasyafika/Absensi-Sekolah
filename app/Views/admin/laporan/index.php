<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

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

    <div class="col-xl-8 col-md-6 mb-4 d-flex">
      <div class="card shadow mb-4">
        <div class="card-header">
          <h5 class="card-title text-success mb-0 fw-bold">Laporan Absensi</h5>
        </div>
        <div class="card-body">

          <form method="GET" action="<?= base_url('laporan/absenPdf'); ?>" class="mb-4 row g-3 align-items-center">
            <div class="col-md-6">
              <label for="kelas" class="form-label fw-bold">Kelas</label>
              <select name="id_kelas" id="kelas" class="form-select">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $kls) : ?>
                  <option value="<?= $kls->id; ?>" <?= ($id_kelas == $kls->id) ? 'selected' : '' ?>>
                    <?= esc("{$kls->nama_kls} {$kls->kd_jurusan} {$kls->rombel}"); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="mapel" class="form-label fw-bold">Mata Pelajaran</label>
              <select name="id_mapel" id="mapel" class="form-select">
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m) : ?>
                  <option value="<?= $m->id; ?>" <?= ($id_mapel == $m->id) ? 'selected' : '' ?>>
                    <?= esc($m->kode_mapel); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="row mb-3 g-3">
              <div class="col-md-4">
                <label for="semester" class="form-label fw-bold">Semester</label>
                <select name="semester" id="semester" class="form-select form-select">
                  <option value="Genap" <?= (old('semester', $filter['semester'] ?? '') == 'Genap') ? 'selected' : '' ?>>Genap</option>
                  <option value="Gajil" <?= (old('semester', $filter['semester'] ?? '') == 'Gajil') ? 'selected' : '' ?>>Gajil</option>
                </select>
              </div>

              <div class="col-md-4">
                <label for="dari" class="form-label fw-semibold">Dari Tanggal</label>
                <input type="date" class="form-control" id="dari" name="dari">
              </div>
              <div class="col-md-4">
                <label for="sampai" class="form-label fw-semibold">Sampai Tanggal</label>
                <input type="date" class="form-control" id="sampai" name="sampai">
              </div>
            </div>

            <div class="float-end">
              <button type="submit" name="download_pdf" value="1" class="btn btn-danger" title="Export PDF"> <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card shadow-lg">
        <div class="card-header">
          <h5 class="card-title text-primary mb-0 fw-bold">Laporan Siswa</h5>
        </div>
        <div class="card-body">

          <form action="<?= base_url('laporan/siswaPdf'); ?>" method="GET" class="mb-4 row g-3 align-items-center">
            <div class="col-md-6 mb-3">
              <label for="kelasRombel" class="form-label fw-bold">Kelas</label>
              <select name="kelas_rombel" id="kelasRombel" class="form-select form-select">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <?php
                  $value = $k->nama_kls . '|' . $k->rombel . '|' . $k->kd_jurusan;
                  $selected = ($value == ($_GET['kelas_rombel'] ?? '')) ? 'selected' : '';
                  $label = $k->nama_kls . ' ' . $k->kd_jurusan . ' ' . $k->rombel;
                  ?>
                  <option value="<?= $value ?>" <?= $selected ?>>
                    <?= $label ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="jurusan" class="form-label fw-bold">Jurusan</label>
              <select name="jurusan" id="jurusan" class="form-select form-select">
                <option value="">-- Semua Jurusan --</option>
                <?php foreach ($jurusan as $j) : ?>
                  <option value="<?= $j->id; ?>" <?= ($id_jurusan == $j->id) ? 'selected' : '' ?>>
                    <?= esc($j->kode_jurusan); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="float-end">
              <button type="submit" class="btn btn-danger" name="download" value="1">
                <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection(); ?>