<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<div class="container-fluid">
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

  <div class="container mt-4">
    <div class="card mb-4 shadow-sm">
      <div class="card-body ">
        <form method="GET" action="<?= base_url('rekap') ?>">
          <div class="row mb-3 g-3">
            <div class="col-md-6">
              <label for="kelas" class="form-label fw-semibold">Kelas</label>
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
              <label for="mapel" class="form-label fw-semibold">Mata Pelajaran</label>
              <select name="id_mapel" id="mapel" class="form-select">
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m) : ?>
                  <option value="<?= $m->id; ?>" <?= ($id_mapel == $m->id) ? 'selected' : '' ?>>
                    <?= esc($m->kode_mapel); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mb-3 g-3">
            <div class="col-md-6">
              <label for="dari" class="form-label fw-semibold">Dari Tanggal</label>
              <input type="date" class="form-control" id="dari" name="dari">
            </div>
            <div class="col-md-6">
              <label for="sampai" class="form-label fw-semibold">Sampai Tanggal</label>
              <input type="date" class="form-control" id="sampai" name="sampai">
            </div>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-search"></i> Tampilkan Rekap
            </button>
            <a href="<?= base_url('rekap'); ?>" class="btn btn-warning">
              <i class="bi bi-x-octagon-fill"></i> Reset
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body shadow-lg">
        <h3 class="fw-semibold mb-3">Tabel Rekap Siswa</h3>
        <div class="table-responsive">
          <?php if (empty($rekap)) : ?>
            <div class="alert alert-warning text-center fw-semibold shadow-sm">
              <i class="bi bi-exclamation-circle me-2"></i> Tidak ada data Siswa yang tersedia. Silakan memilih filter.
            </div>
          <?php else : ?>
            <table class="table table-bordered" id="datatabel">
              <thead class="table-danger text-center">
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Hadir</th>
                  <th>Izin</th>
                  <th>Sakit</th>
                  <th>Alpha</th>
                  <th>Total Pertemuan</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php $no = 1;
                foreach ($rekap as $r) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($r->nama) ?></td>
                    <td><?= $r->hadir ?></td>
                    <td><?= $r->izin ?></td>
                    <td><?= $r->sakit ?></td>
                    <td><?= $r->alpa ?></td>
                    <td><?= $r->total ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>

        <div class="mt-3">
          <div class="d-grid d-md-flex justify-content-md-end gap-2">
            <a href="<?= base_url('rekap/cetakLaporan?id_kelas=' . $id_kelas . '&id_mapel=' . $id_mapel . '&dari=' . $dari . '&sampai=' . $sampai); ?>" class="btn btn-danger">
              <i class="bi bi-box-arrow-in-down"></i> Export PDF
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<?= $this->endSection(); ?>