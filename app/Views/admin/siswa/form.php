<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-3 text-primary fw-bold"><?= $title; ?></h1>

    <div class="row mb-5">
        <div class="col-lg-6">

            <div class="card shadow-lg">
                <div class="card-body">

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>

                    <form action="<?= $action; ?>" method="POST">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control <?= isset($validatio->nama) ? 'is-invalid' : ''; ?>" value="<?= old('nama', $siswa->nama ?? ''); ?>" placeholder="Masukkan nama lengkap">
                            <?php if (isset($validation->nama)) : ?>
                                <div class="invalid-feedback"><?= $validation->nama; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" name="nisn" id="nisn" class="form-control <?= isset($validation->nisn) ? 'is-invalid' : ''; ?>" value="<?= old('nisn', $siswa->nisn ?? ''); ?>" placeholder="Masukkan NISN 10 digit">
                            <?php if (isset($validation->nisn)) : ?>
                                <div class="invalid-feedback"><?= $validation->nisn; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select <?= isset($validation->kelas_id) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($kelas_id as $kls) : ?>
                                    <option value="<?= $kls->id; ?>" <?= old('kelas_id', $siswa->kelas_id ?? '') == $kls->id ? 'selected' : ''; ?>>
                                        <?= esc($kls->nama_kls); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($validation->kelas_id)) : ?>
                                <div class="invalid-feedback"><?= $validation->kelas_id; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control <?= isset($validation->tanggal_lahir) ? 'is-invalid' : ''; ?>" value="<?= old('tanggal_lahir', $siswa->tanggal_lahir ?? ''); ?>">
                            <?php if (isset($validation->tanggal_lahir)) : ?>
                                <div class="invalid-feedback"><?= $validation->tanggal_lahir; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select <?= isset($validation->jenis_kelamin) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" <?= old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?= old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                            <?php if (isset($validation->jenis_kelamin)) : ?>
                                <div class="invalid-feedback"><?= $validation->jenis_kelamin; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select name="agama" id="agama" class="form-select <?= isset($validation->agama) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="Islam" <?= old('agama', $siswa->agama ?? '') == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                                <option value="Kristen" <?= old('agama', $siswa->agama ?? '') == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                                <option value="Katolik" <?= old('agama', $siswa->agama ?? '') == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                                <option value="Hindu" <?= old('agama', $siswa->agama ?? '') == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                                <option value="Buddha" <?= old('agama', $siswa->agama ?? '') == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                                <option value="Konghucu" <?= old('agama', $siswa->agama ?? '') == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                            </select>
                            <?php if (isset($validation->agama)) : ?>
                                <div class="invalid-feedback"><?= $validation->agama; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="thn_masuk" class="form-label">Tahun Masuk</label>
                            <input type="number" name="thn_masuk" id="thn_masuk" class="form-control <?= isset($validation->thn_masuk) ? 'is-invalid' : ''; ?>" value="<?= old('thn_masuk', $siswa->thn_masuk ?? ''); ?>" placeholder="Contoh: 2024">
                            <?php if (isset($validation->thn_masuk)) : ?>
                                <div class="invalid-feedback"><?= $validation->thn_masuk; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select <?= isset($validation->status) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="Aktif" <?= old('status', $siswa->status ?? '') == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= old('status', $siswa->status ?? '') == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                            <?php if (isset($validation->status)) : ?>
                                <div class="invalid-feedback"><?= $validation->status; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="text-end">
                            <a href="<?= base_url('/siswa'); ?>" class="btn btn-secondary me-3">
                                <i class="bi bi-arrow-left-square"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?= isset($siswa) ? 'Update' : 'Save'; ?> Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>