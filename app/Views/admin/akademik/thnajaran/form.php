<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('kelas'); ?>" class="text-decoration-none">Tahun Ajaran</a></li>
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
                            <label for="semester" class="form-label fw-semibold input-semester">Masukan Semester</label>
                            <select name="semester" id="semester" class="form-select <?= (session('errors.semester')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Genap" <?= old('semester', $thnajaran->semester ?? '') == 'Genap' ? 'selected' : ''; ?>>Genap</option>
                                <option value="Ganjil" <?= old('semester', $thnajaran->semester ?? '') == 'Ganjil' ? 'selected' : ''; ?>>Ganjil</option>

                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.semester'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tahun" class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun" id="tahun" class="form-control <?= (session('errors.tahun')) ? 'is-invalid' : ''; ?>" value="<?= old('tahun', $thnajaran->tahun ?? ''); ?>" placeholder="Contoh: 2023/2024">
                            <div class="invalid-feedback">
                                <?= session('errors.tahun'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold input-status">Masukan status</label>
                            <select name="status" id="status" class="form-select <?= (session('errors.status')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih status --</option>
                                <option value="Aktif" <?= old('status', $thnajaran->status ?? '') == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= old('status', $thnajaran->status ?? '') == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>

                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.status'); ?>
                            </div>
                        </div>


                        <div class="text-end">
                            <a href="<?= base_url('/thnajaran'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($thnajaran) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>