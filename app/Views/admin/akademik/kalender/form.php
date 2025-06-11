<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">kalender</a></li>
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
                            <label for="tanggal" class="form-label fw-semibold">Tanggal Libur</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control <?= (session('errors.tanggal')) ? 'is-invalid' : ''; ?>" value="<?= old('tanggal', $kalender->tanggal ?? ''); ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.tanggal'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_libur" class="form-label fw-semibold">Nama Libur</label>
                            <input type="text" name="nama_libur" id="nama_libur" class="form-control <?= (session('errors.nama_libur')) ? 'is-invalid' : ''; ?>" value="<?= old('nama_libur', $kalender->nama_libur ?? ''); ?>" placeholder="Contoh: Hari Pahlawan">
                            <div class="invalid-feedback">
                                <?= session('errors.nama_libur'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" id="keterangan"
                                class="form-control <?= (session('errors.keterangan')) ? 'is-invalid' : ''; ?>" rows="3" placeholder="Contoh: Libur nasional untuk memperingati hari kemerdekaan Indonesia"><?= old('keterangan', $kalender->keterangan ?? '') ?></textarea>
                            <div class="invalid-feedback">
                                <?= session('errors.keterangan'); ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?= base_url('/kalender'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($kalender) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>