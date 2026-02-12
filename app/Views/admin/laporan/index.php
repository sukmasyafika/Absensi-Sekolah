<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<?php
$title       = $title       ?? '';
$kelas       = $kelas       ?? [];
$mapel       = $mapel       ?? [];
$list_kelas  = $list_kelas  ?? [];
$jurusan     = $jurusan     ?? [];

$id_kelas    = $id_kelas    ?? '';
$id_mapel    = $id_mapel    ?? '';
$id_jurusan  = $id_jurusan  ?? '';

$semester = $_GET['semester'] ?? '';
$dari     = $_GET['dari'] ?? '';
$sampai  = $_GET['sampai'] ?? '';
?>

<div class="container-fluid mt-5 pt-5">
  <h1 class="h3 mb-4 text-gray-800"><?= esc($title); ?></h1>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="position-fixed top-0 end-0 pe-3 pt-4 mt-5" style="z-index: 1055">
      <div class="toast align-items-center text-bg-danger show">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <?= session()->getFlashdata('error'); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="position-fixed top-0 end-0 pe-3 pt-4 mt-5" style="z-index: 1055">
      <div class="toast align-items-center text-bg-success show">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success'); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="row">

    <!-- ================= LAPORAN ABSENSI ================= -->
    <div class="col-xl-8 col-md-6 mb-4">
      <div class="card shadow">
        <div class="card-header">
          <h5 class="fw-bold text-success mb-0">Laporan Absensi</h5>
        </div>

        <div class="card-body">
          <form method="GET" action="<?= base_url('laporan/absenPdf'); ?>" class="row g-3">

            <div class="col-md-6">
              <label class="fw-bold">Kelas</label>
              <select name="id_kelas" class="form-select">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $kls): ?>
                  <option value="<?= $kls->id ?>"
                    <?= ($id_kelas == $kls->id) ? 'selected' : '' ?>>
                    <?= esc($kls->nama_kls . ' ' . $kls->kd_jurusan . ' ' . $kls->rombel) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="fw-bold">Mata Pelajaran</label>
              <select name="id_mapel" class="form-select">
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m): ?>
                  <option value="<?= $m->id ?>"
                    <?= ($id_mapel == $m->id) ? 'selected' : '' ?>>
                    <?= esc($m->kode_mapel) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="fw-bold">Semester</label>
              <select name="semester" class="form-select">
                <option value="">-- Semua --</option>
                <option value="Ganjil" <?= ($semester == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                <option value="Genap" <?= ($semester == 'Genap') ? 'selected' : '' ?>>Genap</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="fw-bold">Dari Tanggal</label>
              <input type="date" name="dari" class="form-control" value="<?= $dari ?>">
            </div>

            <div class="col-md-4">
              <label class="fw-bold">Sampai Tanggal</label>
              <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>">
            </div>

            <div class="text-end">
              <button type="submit" name="download_pdf" value="1" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- ================= LAPORAN SISWA ================= -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card shadow">
        <div class="card-header">
          <h5 class="fw-bold text-primary mb-0">Laporan Siswa</h5>
        </div>

        <div class="card-body">
          <form action="<?= base_url('laporan/siswaPdf'); ?>" method="GET" class="row g-3">

            <div class="col-md-6">
              <label class="fw-bold">Kelas</label>
              <select name="kelas_rombel" class="form-select">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($list_kelas as $k): ?>
                  <?php
                  $value = "{$k->nama_kls}|{$k->rombel}|{$k->kd_jurusan}";
                  ?>
                  <option value="<?= $value ?>"
                    <?= (($value == ($_GET['kelas_rombel'] ?? ''))) ? 'selected' : '' ?>>
                    <?= esc($k->nama_kls . ' ' . $k->kd_jurusan . ' ' . $k->rombel) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="fw-bold">Jurusan</label>
              <select name="jurusan" class="form-select">
                <option value="">-- Semua Jurusan --</option>
                <?php foreach ($jurusan as $j): ?>
                  <option value="<?= $j->id ?>"
                    <?= ($id_jurusan == $j->id) ? 'selected' : '' ?>>
                    <?= esc($j->kode_jurusan) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="text-end">
              <button type="submit" name="download" value="1" class="btn btn-danger">
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