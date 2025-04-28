<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">Data Jadwal Mengajar</h1>

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Jadwal</h6>
            <a href="<?= site_url('jadwal/tambah'); ?>" class="btn btn-sm btn-success shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import Excel
            </a>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('jadwal/tambah'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatabel">
                    <thead class="bg-primary text-white text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Hari & Jam</th>
                            <th>Ruangan</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($jadwal)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data jadwal.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($jadwal as $j): ?>
                                <tr class="text-center">
                                    <th class="align-middle"><?= $no++; ?></th>
                                    <td class="text-start align-middle"><?= esc($j->guru); ?></td>
                                    <td class="align-middle"><?= esc($j->mapel); ?></td>
                                    <td class="align-middle"><?= esc($j->kelas . ' ' . $j->jurusan); ?></td>
                                    <td class="align-middle"><?= esc($j->hari . ', (' . $j->jam_mulai . '-' . $j->jam_selesai . ')'); ?></td>
                                    <td class="align-middle"><?= esc($j->ruangan); ?></td>
                                    <td class="align-middle"><?= esc($j->semester . ' - ' . $j->tahun); ?></td>
                                    <td class="align-middle">
                                        <?php if ($j->status == 'Aktif'): ?>
                                            <span class="badge bg-success"><?= esc($j->status); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= esc($j->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <a href="<?= site_url('jadwal/detail/' . $j->id); ?>" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="<?= site_url('jadwal/edit/' . $j->id); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="<?= site_url('jadwal/delete/' . $j->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </div>
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