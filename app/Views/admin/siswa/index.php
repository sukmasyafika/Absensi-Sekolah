<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">Data Siswa</h1>

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Siswa</h6>
            <a href="<?= site_url('siswa/tambah'); ?>" class="btn btn-sm btn-success shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import Excel
            </a>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('siswa/tambah'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatabel">
                    <thead class="bg-primary text-white text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th>Tahun Masuk</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($siswa)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data siswa.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($siswa as $s): ?>
                                <tr class="text-center">
                                    <th class="align-middle"><?= $no++; ?></th>
                                    <td class="text-start align-middle"><?= esc($s->nama); ?></td>
                                    <td class="align-middle"><?= esc($s->nisn); ?></td>
                                    <td class="align-middle"><?= esc($s->jenis_kelamin); ?></td>
                                    <td class="align-middle"><?= esc($s->kelas_name); ?> - <?= esc($s->jurusan_name); ?></td>
                                    <td class="align-middle"><?= esc($s->thn_masuk); ?></td>
                                    <td class="align-middle">
                                        <?php if ($s->status == 'Aktif'): ?>
                                            <span class="badge bg-success"><?= esc($s->status); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= esc($s->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <a href="<?= site_url('siswa/detail/' . $s->id); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="<?= site_url('siswa/edit/' . $s->id); ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="<?= site_url('siswa/delete/' . $s->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>