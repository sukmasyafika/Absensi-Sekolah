<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('guru'); ?>" class="text-decoration-none">Guru</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>

    <h1 class="h3 mb-3 text-primary fw-bold"><?= $title; ?></h1>

    <div class="card shadow-lg">
        <div class="card-body">

            <form action="<?= $action; ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row">

                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="slug" name="slug" value="<?= old('slug', $guru->slug ?? ''); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label fw-semibold input-nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control  <?= (session('errors.nama')) ? 'is-invalid' : ''; ?> " value="<?= old('nama', $guru->nama ?? ''); ?>" placeholder="Masukkan nama lengkap">
                        <div class="invalid-feedback">
                            <?= session('errors.nama'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nip" class="form-label fw-semibold">NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control <?= (session('errors.nip')) ? 'is-invalid' : ''; ?>" value="<?= old('nip', $guru->nip ?? ''); ?>" placeholder="Masukkan NIP 18 digit">
                        <div class="invalid-feedback">
                            <?= session('errors.nip'); ?>
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control <?= (session('errors.jabatan')) ? 'is-invalid' : ''; ?>" value="<?= old('jabatan', $guru->jabatan ?? ''); ?>" placeholder="Masukkan jabatan">
                        <div class="invalid-feedback">
                            <?= session('errors.jabatan'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control <?= (session('errors.tanggal_lahir')) ? 'is-invalid' : ''; ?>" value="<?= old('tanggal_lahir', isset($guru->tanggal_lahir) ? date('Y-m-d', strtotime($guru->tanggal_lahir)) : ''); ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.tanggal_lahir'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select <?= (session('errors.jenis_kelamin')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" <?= old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.jenis_kelamin'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="agama" class="form-label fw-semibold">Agama</label>
                        <select name="agama" id="agama" class="form-select <?= (session('errors.agama')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih --</option>
                            <option value="Islam" <?= old('agama', $guru->agama ?? '') == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                            <option value="Kristen" <?= old('agama', $guru->agama ?? '') == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                            <option value="Katolik" <?= old('agama', $guru->agama ?? '') == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                            <option value="Hindu" <?= old('agama', $guru->agama ?? '') == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                            <option value="Buddha" <?= old('agama', $guru->agama ?? '') == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                            <option value="Konghucu" <?= old('agama', $guru->agama ?? '') == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.agama'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="thn_masuk" class="form-label fw-semibold">Tahun Masuk</label>
                        <input type="number" name="thn_masuk" id="thn_masuk" class="form-control  <?= (session('errors.thn_masuk')) ? 'is-invalid' : ''; ?>" value="<?= old('thn_masuk', $guru->thn_masuk ?? ''); ?>" placeholder="Contoh: 2024">
                        <div class="invalid-feedback">
                            <?= session('errors.thn_masuk'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select <?= (session('errors.status')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih --</option>
                            <option value="Aktif" <?= old('status', $guru->status ?? '') == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Tidak Aktif" <?= old('status', $guru->status ?? '') == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.status'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="hidden" name="fotoLama" value="<?= $guru->foto ?? ''; ?>">
                        <label for="foto" class="form-label fw-semibold">Pilih Foto</label>
                        <input class="form-control <?= (session('errors.foto')) ? 'is-invalid' : ''; ?>" type="file" id="foto" name="foto" onchange="previewImg()">

                        <div class="invalid-feedback">
                            <?= session('errors.foto'); ?>
                        </div>

                        <div class="mt-3">
                            <img id="img-preview"
                                src="<?= isset($guru->foto) && $guru->foto ? base_url('assets/img/guru/' . $guru->foto) : ''; ?>"
                                class="img-thumbnail border border-info img-preview shadow-sm"
                                style="max-width: 150px; height: auto; <?= (isset($guru->foto) && $guru->foto) ? '' : 'display: none;'; ?>">
                        </div>
                    </div>

                    <div class="text-start mt-3">
                        <a href="<?= base_url('/guru'); ?>" class="btn btn-secondary me-3">
                            <i class="bi bi-arrow-left-square"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> <?= isset($guru) ? 'Update' : 'Save'; ?> Data
                        </button>

                    </div>
                </div>
            </form>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>