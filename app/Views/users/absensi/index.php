<?= $this->extend('layout/template'); ?>
<?= $this->section('admin-content'); ?>

<div class="container-fluid mb-5">

  <h1 class="h3 mb-4 text-gray-800 fw-bold"><i class="bi bi-clipboard-check"></i> Daftar Hadir Siswa</h1>

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

  <div class="row justify-content-center mb-4 g-3">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 bg-white">
        <div class="card-body p-3">
          <form action="<?= base_url('absensi') ?>" method="get" class="row g-3">
            <div class="col-md-6 mb-3">
              <label for="kelas" class="form-label fw-semibold">Pilih Kelas</label>
              <select name="id_kelas" id="kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $kls) : ?>
                  <option value="<?= $kls->id; ?>" <?= ($id_kelas == $kls->id) ? 'selected' : '' ?>>
                    <?= esc("{$kls->nama_kls} {$kls->kd_jurusan} {$kls->rombel}"); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="mapel" class="form-label fw-semibold">Pilih Mata Pelajaran</label>
              <select name="id_mapel" id="mapel" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($mapel as $m) : ?>
                  <option value="<?= $m->id; ?>" <?= ($id_mapel == $m->id) ? 'selected' : '' ?>>
                    <?= esc($m->kode_mapel); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center">
              <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalGuruTidakMasuk">
                <i class="bi bi-person-x-fill"></i> Guru Tidak Masuk?
              </button>
              <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-search"></i> Tampilkan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Guru Tidak Masuk -->
  <div class="modal fade" id="modalGuruTidakMasuk" tabindex="-1" aria-labelledby="modalGuruTidakMasukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content shadow-lg rounded-4 border-0">
        <div class="modal-header bg-danger text-white rounded-top-4">
          <h5 class="modal-title fw-semibold d-flex align-items-center" id="modalGuruTidakMasukLabel">
            <i class="bi bi-person-x-fill me-2 fs-4"></i> Form Guru Tidak Masuk
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <form action="<?= base_url('absensi/savegurutidakmasuk'); ?>" method="post">
          <div class="modal-body px-4 py-3">
            <div class="mb-3">
              <label for="alasan" class="form-label fw-semibold text-dark">Alasan <span class="text-danger">*</span></label>
              <input type="text" name="alasan" id="alasan" class="form-control" maxlength="150" placeholder="Contoh: Sakit" required>
            </div>
            <div class="mb-3">
              <label for="jadwal" class="form-label fw-semibold text-dark">Pilih Jadwal Hari Ini <span class="text-danger">*</span></label>
              <select name="id_jadwal[]" id="jadwal" class="form-select" multiple required>
                <option disabled>-- Pilih Jadwal --</option>
                <?php foreach ($jadwalGuru as $jadwal) : ?>
                  <?php
                  $jamMulai = date('H:i', strtotime($jadwal->jam_mulai));
                  $jamSelesai = date('H:i', strtotime($jadwal->jam_selesai));
                  ?>
                  <option value="<?= $jadwal->id ?>">
                    <?= esc("{$jadwal->mapel} - {$jadwal->kelas} {$jadwal->jurusan} {$jadwal->rombel} ({$jamMulai} - {$jamSelesai})") ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted d-block mt-1">Gunakan <kbd>Ctrl</kbd> / <kbd>Cmd</kbd> untuk pilih lebih dari satu jadwal</small>
            </div>
            <div class="mb-3">
              <label for="keterangan" class="form-label fw-semibold text-dark">Keterangan Tambahan</label>
              <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tulis keterangan lain jika perlu..."></textarea>
            </div>
          </div>
          <div class="modal-footer bg-light border-0 rounded-bottom-4 px-4 py-3">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> Tutup
            </button>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-save me-1"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-12 col-md-10">
      <div class="card shadow border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2">
              <span class="badge bg-secondary px-3 py-2 fs-6"><i class="bi bi-calendar-event"></i> Tanggal: <strong><?= $tanggal; ?></strong></span>
              <span class="badge bg-primary px-3 py-2 fs-6"><i class="bi bi-journal-bookmark-fill"></i> Mapel: <strong><?= esc($nama_mapel); ?></strong></span>
              <span class="badge bg-info px-3 py-2 fs-6"><i class="bi bi-people-fill"></i> Kelas: <strong><?= esc($nama_kelas); ?></strong></span>
              <span class="badge bg-warning px-3 py-2 fs-6"><i class="bi bi-calendar-check-fill"></i> Pertemuan Ke - <strong><?= esc($pertemuan); ?></strong></span>
            </div>
          </div>

          <form action="<?= base_url('absensi/save') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_kelas" value="<?= esc($id_kelas) ?>">
            <input type="hidden" name="id_mapel" value="<?= esc($id_mapel) ?>">
            <input type="hidden" name="tanggal" value="<?= date('Y-m-d'); ?>">
            <input type="hidden" name="pertemuan" value="<?= esc($pertemuan) ?>">

            <?php
            $status = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Alpa'];

            if (empty($absensi)) : ?>
              <div class="alert alert-warning text-center fw-semibold shadow-sm">
                <i class="bi bi-exclamation-circle me-2"></i> Tidak ada data absensi yang tersedia. Silahkan pilih Jadwal terlebih Dahulu
              </div>
              <?php else :
              $no = 1;
              foreach ($absensi as $a) : ?>
                <div class="mb-3 p-3 rounded border shadow-sm">
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="fw-semibold fs-6 mb-2 mb-md-0">
                      <?= $no++ ?>. <?= esc($a->nama); ?>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                      <?php foreach ($status as $key => $label) : ?>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="status[<?= $a->id ?>]" id="status_<?= $a->id ?>_<?= $key ?>" value="<?= $label ?>" required>
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
            <div class="mt-4 d-flex gap-3 justify-content-end">
              <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-circle-fill me-1"></i> Selesai
              </button>
              <!-- <button type="submit" name="update" value="1" class="btn btn-warning px-4">
                    <i class="bi bi-arrow-repeat me-1"></i> Update Absensi
                  </button> -->
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>


</div>

<?= $this->endSection(); ?>