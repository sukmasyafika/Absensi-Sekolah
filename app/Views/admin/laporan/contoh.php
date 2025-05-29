<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-3">
    <div class="card-body">
      <h5 class="card-title text-primary mb-3">Laporan Siswa</h5>

      <!-- Filter Form -->
      <form action="<?= base_url('laporan/siswa'); ?>" method="GET" class="mb-3">
        <div class="mb-2">
          <label for="kelasRombel" class="form-label small fw-bold">Kelas + Rombel</label>
          <select name="kelas_rombel" id="kelasRombel" class="form-select form-select-sm">
            <option value="">-- Semua Kelas + Rombel --</option>
            <?php foreach ($kelasRombelList as $kr): ?>
              <option value="<?= esc($kr['id']); ?>" <?= set_select('kelas_rombel', $kr['id']); ?>>
                <?= esc($kr['nama_kelas']) . ' - ' . esc($kr['rombel']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="jurusan" class="form-label small fw-bold">Jurusan</label>
          <select name="jurusan" id="jurusan" class="form-select form-select-sm">
            <option value="">-- Semua Jurusan --</option>
            <?php foreach ($jurusanList as $jurusan): ?>
              <option value="<?= esc($jurusan['id']); ?>" <?= set_select('jurusan', $jurusan['id']); ?>>
                <?= esc($jurusan['nama_jurusan']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm w-100 mb-3">Terapkan Filter</button>
      </form>

      <!-- Export Buttons -->
      <div class="d-flex justify-content-between">
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

<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100">
    <div class="card-header bg-primary text-white fw-bold">
      Laporan Siswa
    </div>
    <div class="card-body">

      <!-- Filter Form -->
      <form action="<?= base_url('laporan/siswa'); ?>" method="GET" class="mb-3">
        <div class="mb-2">
          <label for="kelasRombel" class="form-label small fw-bold">Kelas + Rombel</label>
          <select name="kelas_rombel" id="kelasRombel" class="form-select form-select-sm">
            <option value="">-- Semua Kelas + Rombel --</option>
            <?php foreach ($kelasRombelList as $kr): ?>
              <option value="<?= esc($kr['id']); ?>" <?= set_select('kelas_rombel', $kr['id']); ?>>
                <?= esc($kr['nama_kelas']) . ' - ' . esc($kr['rombel']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="jurusan" class="form-label small fw-bold">Jurusan</label>
          <select name="jurusan" id="jurusan" class="form-select form-select-sm">
            <option value="">-- Semua Jurusan --</option>
            <?php foreach ($jurusanList as $jurusan): ?>
              <option value="<?= esc($jurusan['id']); ?>" <?= set_select('jurusan', $jurusan['id']); ?>>
                <?= esc($jurusan['nama_jurusan']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-sm w-100 mb-3">Terapkan Filter</button>
      </form>

      <!-- Export Buttons -->
      <div class="d-flex justify-content-between">
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

<div class="card shadow mb-4">
  <div class="card-header">
    <h5 class="card-title text-success mb-0">Laporan Absensi</h5>
  </div>
  <div class="card-body">
    <!-- Filter Form -->
    <form method="GET" action="<?= base_url('laporan/absensi'); ?>" class="mb-4 row g-3 align-items-center">
      <!-- Filter kelas/rombel/jurusan -->
      <div class="col-md-4">
        <label for="rombel_id" class="form-label">Kelas / Rombel / Jurusan</label>
        <select name="rombel_id" id="rombel_id" class="form-select">
          <option value="">-- Semua Kelas / Rombel / Jurusan --</option>
          <?php foreach ($rombelList as $rombel) : ?>
            <option value="<?= $rombel['id']; ?>" <?= ($rombel['id'] == old('rombel_id', $filter['rombel_id'] ?? '')) ? 'selected' : '' ?>>
              <?= $rombel['nama_lengkap']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Filter semester -->
      <div class="col-md-2">
        <label for="semester" class="form-label">Semester</label>
        <select name="semester" id="semester" class="form-select">
          <option value="">-- Semua Semester --</option>
          <option value="1" <?= (old('semester', $filter['semester'] ?? '') == '1') ? 'selected' : '' ?>>1</option>
          <option value="2" <?= (old('semester', $filter['semester'] ?? '') == '2') ? 'selected' : '' ?>>2</option>
        </select>
      </div>

      <!-- Filter bulan -->
      <div class="col-md-2">
        <label for="bulan" class="form-label">Bulan</label>
        <select name="bulan" id="bulan" class="form-select">
          <option value="">-- Semua Bulan --</option>
          <?php
          for ($b = 1; $b <= 12; $b++):
            $bulanText = date('F', mktime(0, 0, 0, $b, 10));
          ?>
            <option value="<?= $b; ?>" <?= (old('bulan', $filter['bulan'] ?? '') == $b) ? 'selected' : '' ?>><?= $bulanText; ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
      </div>
    </form>

    <!-- Export Buttons -->
    <div class="btn-group" role="group" aria-label="Export Buttons">
      <!-- Export dengan filter aktif -->
      <a href="<?= base_url('laporan/absensi/excel?' . http_build_query($filter ?? [])); ?>" class="btn btn-sm btn-success" title="Export Excel">
        <i class="bi bi-file-earmark-excel-fill"></i>
      </a>
      <a href="<?= base_url('laporan/absensi/pdf?' . http_build_query($filter ?? [])); ?>" class="btn btn-sm btn-danger" title="Export PDF">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </a>
      <a href="<?= base_url('laporan/absensi/print?' . http_build_query($filter ?? [])); ?>" target="_blank" class="btn btn-sm btn-secondary" title="Cetak">
        <i class="bi bi-printer-fill"></i>
      </a>

      <!-- Export semua data tanpa filter -->
      <a href="<?= base_url('laporan/absensi/excel?all=1'); ?>" class="btn btn-sm btn-outline-success" title="Export Semua Excel">
        <i class="bi bi-file-earmark-excel"></i> Semua
      </a>
      <a href="<?= base_url('laporan/absensi/pdf?all=1'); ?>" class="btn btn-sm btn-outline-danger" title="Export Semua PDF">
        <i class="bi bi-file-earmark-pdf"></i> Semua
      </a>
    </div>
  </div>
</div>

<div class="mb-3">
  <label for="mapel" class="form-label small fw-bold">Mata Pelajaran</label>
  <select name="mapel" id="mapel" class="form-select form-select-sm">
    <option value="">-- Semua Mata Pelajaran --</option>
    <?php foreach ($mapelList as $mapel): ?>
      <option value="<?= esc($mapel['id']); ?>" <?= set_select('mapel', $mapel['id']); ?>>
        <?= esc($mapel['nama_mapel']); ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>