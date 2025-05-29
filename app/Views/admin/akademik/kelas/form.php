<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('kelas'); ?>" class="text-decoration-none">Kelas</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>

    <h1 class="h3 mb-3 text-primary fw-bold"><?= $title; ?></h1>

    <div class="row mb-5">
        <div class="col-lg-6">

            <div class="card shadow-lg">
                <div class="card-body">

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Terjadi Kesalahan Mohon Di cek kembali:</strong>
                            <p class="ps-5"><?= session()->getFlashdata('error'); ?></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="nama_kls" class="form-label fw-semibold input-nama_kls">Masukan Kelas</label>
                            <select name="nama_kls" id="nama_kls" class="form-select <?= (session('errors.nama_kls')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="X" <?= old('nama_kls', $kelas->nama_kls ?? '') == 'X' ? 'selected' : ''; ?>>X</option>
                                <option value="XI" <?= old('nama_kls', $kelas->nama_kls ?? '') == 'XI' ? 'selected' : ''; ?>>XI</option>
                                <option value="XII" <?= old('nama_kls', $kelas->nama_kls ?? '') == 'XII' ? 'selected' : ''; ?>>XII</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.nama_kls'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rombel" class="form-label fw-semibold">Rombel</label>
                            <select name="rombel" id="rombel" class="form-select <?= (session('errors.rombel')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="A" <?= old('rombel', $kelas->rombel ?? '') == 'A' ? 'selected' : ''; ?>>A</option>
                                <option value="B" <?= old('rombel', $kelas->rombel ?? '') == 'B' ? 'selected' : ''; ?>>B</option>
                                <option value="C" <?= old('rombel', $kelas->rombel ?? '') == 'C' ? 'selected' : ''; ?>>C</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.rombel'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label fw-semibold">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-select <?= (session('errors.jurusan_id')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j->id; ?>" <?= old('jurusan_id', $kelas->jurusan_id ?? '') == $j->id ? 'selected' : ''; ?>>
                                        <?= esc($j->nama_jurusan); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.jurusan_id'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="wali_kelas_id" class="form-label fw-semibold">Wali Kelas</label>
                            <select name="wali_kelas_id" id="wali_kelas_id" class="form-select <?= (session('errors.wali_kelas_id')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <?php foreach ($wakel as $w) : ?>
                                    <option class="text-capitalize" value="<?= $w->id; ?>" <?= old('wali_kelas_id', $kelas->wali_kelas_id ?? '') == $w->id ? 'selected' : ''; ?>>
                                        <?= esc($w->nama); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.wali_kelas_id'); ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?= base_url('/kelas'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($kelas) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>