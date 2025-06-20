<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('siswa'); ?>" class="text-decoration-none">Mata Pelajaran</a></li>
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
                            <label for="kode_mapel" class="form-label fw-semibold">Kode Mata Pelajaran</label>
                            <input type="text" name="kode_mapel" id="kode_mapel" class="form-control <?= (session('errors.kode_mapel')) ? 'is-invalid' : ''; ?>" value="<?= old('kode_mapel', $mapel->kode_mapel ?? ''); ?>" placeholder="Masukan Kode Mapel">
                            <div class="invalid-feedback">
                                <?= session('errors.kode_mapel'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_mapel" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control <?= (session('errors.nama_mapel')) ? 'is-invalid' : ''; ?>" value="<?= old('nama_mapel', $mapel->nama_mapel ?? ''); ?>" placeholder="Masukan Nama Mapel">
                            <div class="invalid-feedback">
                                <?= session('errors.nama_mapel'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_jurusan" class="form-label fw-semibold">Jenis Mata Pelajaran</label>
                            <select name="id_jurusan" id="id_jurusan" class="form-select <?= (session('errors.id_jurusan')) ? 'is-invalid' : ''; ?>">
                                <option value="">Umum</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j->id ?>" <?= old('id_jurusan', $mapel->id_jurusan ?? '') == $j->id ? 'selected' : '' ?>>
                                        <?= esc($j->nama_jurusan); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= session('errors.id_jurusan'); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_thnAjaran" class="form-label fw-semibold">Semester</label>
                            <input type="hidden" name="id_thnAjaran" value="<?= $tahun->id ?>">
                            <input type="text" class="form-control" value="<?= esc($tahun->semester); ?>" readonly>
                            <div class="invalid-feedback">
                                <?= session('errors.id_thnAjaran'); ?>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?= base_url('/mapel'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($mapel) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>