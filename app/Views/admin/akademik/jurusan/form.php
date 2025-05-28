<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Jurusan</a></li>
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
                            <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                            <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control <?= (session('errors.kode_jurusan')) ? 'is-invalid' : ''; ?>" value="<?= old('kode_jurusan', $jurusan->kode_jurusan ?? ''); ?>" placeholder="Contoh: MM">
                            <div class="invalid-feedback">
                                <?= session('errors.kode_jurusan'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control <?= (session('errors.nama_jurusan')) ? 'is-invalid' : ''; ?>" value="<?= old('nama_jurusan', $jurusan->nama_jurusan ?? ''); ?>" placeholder="Contoh: TKJ">
                            <div class="invalid-feedback">
                                <?= session('errors.nama_jurusan'); ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?= base_url('/jurusan'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($jurusan) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>