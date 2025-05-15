<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('jadwal'); ?>" class="text-decoration-none">jadwal</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>

    <h1 class="h3 mb-3 text-primary fw-bold"><?= $title; ?></h1>

    <div class="card shadow-lg">
        <div class="card-body">

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi Kesalahan:</strong>
                    <ul>
                        <li><?= session()->getFlashdata('error'); ?></li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= $action; ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="id_guru" class="form-label fw-semibold">Guru Pengajar</label>
                        <select name="id_guru" id="id_guru" class="form-select <?= (session('errors.id_guru')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Guru --</option>
                            <?php foreach ($guru as $g) : ?>
                                <option value="<?= $g->id; ?>" <?= old('id_guru', $jadwal->id_guru ?? '') == $g->id ? 'selected' : ''; ?>>
                                    <?= esc($g->nama); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.id_guru'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_mapel" class="form-label fw-semibold">Mata Pelajaran</label>
                        <select name="id_mapel" id="id_mapel" class="form-select <?= (session('errors.id_mapel')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Mapel --</option>
                            <?php foreach ($mapel as $m) : ?>
                                <option value="<?= $m->id; ?>" <?= old('id_mapel', $jadwal->id_mapel ?? '') == $m->id ? 'selected' : ''; ?>>
                                    <?= esc($m->nama_mapel); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.id_mapel'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_kelas" class="form-label fw-semibold">Kelas</label>
                        <select name="id_kelas" id="id_kelas" class="form-select <?= (session('errors.id_kelas')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($id_kelas as $kls) : ?>
                                <option value="<?= $kls->id; ?>" <?= old('id_kelas', $jadwal->id_kelas ?? '') == $kls->id ? 'selected' : ''; ?>>
                                    <?= esc($kls->nama_kls . ' ' .  $kls->kd_jurusan . ' ' . $kls->rombel); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.id_kelas'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_thnajaran" class="form-label fw-semibold">Tahun Ajaran</label>
                        <select name="id_thnajaran" id="id_thnajaran" class="form-select <?= (session('errors.id_thnajaran')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Tahun --</option>
                            <?php foreach ($tahun as $t) : ?>
                                <option value="<?= $t->id; ?>" <?= old('id_thnajaran', $jadwal->id_thnajaran ?? '') == $t->id ? 'selected' : ''; ?>>
                                    <?= esc($t->tahun); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.id_thnajaran'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ruangan" class="form-label fw-semibold">Ruangan</label>
                        <input type="text" name="ruangan" id="ruangan" class="form-control <?= (session('errors.ruangan')) ? 'is-invalid' : ''; ?>" value="<?= old('ruangan', $jadwal->ruangan ?? ''); ?>" placeholder="Contoh: Lab-3">
                        <div class="invalid-feedback">
                            <?= session('errors.ruangan'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jam_ke" class="form-label fw-semibold">Jam Ke</label>
                        <input type="number" name="jam_ke" id="jam_ke" class="form-control  <?= (session('errors.jam_ke')) ? 'is-invalid' : ''; ?>" value="<?= old('jam_ke', $jadwal->jam_ke ?? ''); ?>" placeholder="Contoh: 1">
                        <div class="invalid-feedback">
                            <?= session('errors.jam_ke'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="hari" class="form-label fw-semibold">Hari</label>
                        <select name="hari" class="form-select <?= (session('errors.hari')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Hari --</option>
                            <?php
                            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                            foreach ($hariList as $h): ?>
                                <option value="<?= $h; ?>" <?= old('hari', $jadwal->hari ?? '') == $h ? 'selected' : ''; ?>>
                                    <?= $h; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.hari'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select <?= (session('errors.status')) ? 'is-invalid' : ''; ?>">
                            <option value="">-- Pilih Status --</option>
                            <option value="Aktif" <?= old('status', $jadwal->status ?? '') == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Tidak Aktif" <?= old('status', $jadwal->status ?? '') == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('errors.status'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jam_mulai" class="form-label fw-semibold">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control <?= (session('errors.jam_mulai')) ? 'is-invalid' : ''; ?>" value="<?= old('jam_mulai', isset($jadwal->jam_mulai) ? substr($jadwal->jam_mulai, 0, 5) : ''); ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.jam_mulai'); ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jam_selesai" class="form-label fw-semibold">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control <?= (session('errors.jam_selesai')) ? 'is-invalid' : ''; ?>" value="<?= old('jam_selesai', isset($jadwal->jam_selesai) ? substr($jadwal->jam_selesai, 0, 5) : ''); ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.jam_selesai'); ?>
                        </div>
                    </div>

                    <div class="text-start mt-3">
                        <a href="<?= base_url('/jadwal'); ?>" class="btn btn-secondary me-3">
                            <i class="bi bi-arrow-left-square"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> <?= isset($jadwal) ? 'Update' : 'Save'; ?> Data
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>