<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<div class="container-fluid mb-5">

  <ol class="breadcrumb mb-4 bg-light p-3 rounded shadow-sm">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item active">Absensi</li>
  </ol>

  <h1 class="h3 mb-4 text-gray-800 fw-bold"><i class="bi bi-clipboard-check"></i> Daftar Hadir Siswa</h1>

  <div class="row justify-content-center mb-4">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 p-4 bg-white">
        <form action="<?= base_url('absensi') ?>" method="get" class="row g-3">
          <div class="col-md-6">
            <label for="kelas" class="form-label fw-semibold">Pilih Kelas</label>
            <select name="kelas" id="kelas" class="form-select <?= (session('errors.kelas')) ? 'is-invalid' : ''; ?>" required>
              <option selected disabled>-- Pilih Kelas --</option>
              <?php foreach ($kelas as $kls) : ?>
                <option value="<?= $kls->id; ?>" <?= old('kelas') == $kls->id ? 'selected' : ''; ?>>
                  <?= esc("{$kls->nama_kls} {$kls->kd_jurusan} {$kls->rombel}"); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (session('errors.kelas')) : ?>
              <div class="invalid-feedback">
                <?= session('errors.kelas'); ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-6">
            <label for="mapel" class="form-label fw-semibold">Pilih Mata Pelajaran</label>
            <select name="mapel" id="mapel" class="form-select <?= (session('errors.mapel')) ? 'is-invalid' : ''; ?>" required>
              <option selected disabled>-- Pilih Mapel --</option>
              <?php foreach ($mapel as $m) : ?>
                <option value="<?= $m->id; ?>" <?= old('mapel') == $m->id ? 'selected' : ''; ?>>
                  <?= esc($m->kode_mapel); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (session('errors.mapel')) : ?>
              <div class="invalid-feedback">
                <?= session('errors.mapel'); ?>
              </div>
            <?php endif; ?>
          </div>

          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-search"></i> Tampilkan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-10 col-md-10">
      <div class="card shadow border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <span class="badge bg-secondary px-3 py-2 fs-6"><i class="bi bi-calendar-event"></i> Tanggal: <strong>12 Januari 2025</strong></span>
              <span class="badge bg-primary px-3 py-2 fs-6"><i class="bi bi-journal-bookmark-fill"></i> Mapel: <strong>Matematika</strong></span>
              <span class="badge bg-info px-3 py-2 fs-6"><i class="bi bi-people-fill"></i> Kelas: X MM A</span>
              <span class="badge bg-warning px-3 py-2 fs-6"><i class="bi bi-calendar-check-fill"></i> Pertemuan Ke-2</span>
            </div>
          </div>

          <!-- Form Absensi -->
          <form action="<?= base_url('') ?>" method="post">
            <?= csrf_field() ?>

            <?php
            $status = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];

            if (empty($absensi)) : ?>
              <div class="alert alert-warning text-center fw-semibold shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i> Tidak ada data absensi yang tersedia.
              </div>
              <?php else :
              $no = 1;
              foreach ($absensi as $a) : ?>
                <div class="mb-3 p-3 rounded border shadow-sm bg-light">
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="fw-semibold fs-6 mb-2 mb-md-0">
                      <?= $no++ ?>. <?= esc($a->namaSiswa); ?>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                      <?php foreach ($status as $key => $label) : ?>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="keterangan[<?= $a->id ?>]" id="status_<?= $a->id ?>_<?= $key ?>" value="<?= $label ?>" required>
                          <label class="form-check-label" for="status_<?= $a->id ?>_<?= $key ?>">
                            <?= $key ?>
                          </label>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
            <?php endforeach;
            endif; ?>

            <!-- Tombol Aksi -->
            <div class="mt-4 d-flex gap-3 justify-content-end">
              <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-circle-fill me-1"></i> Selesai
              </button>
              <button type="submit" name="update" value="1" class="btn btn-warning px-4">
                <i class="bi bi-arrow-repeat me-1"></i> Update Absensi
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>


</div>

<?= $this->endSection(); ?>