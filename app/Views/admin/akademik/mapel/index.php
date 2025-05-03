<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">Data Mata Pelajaran</h1>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= site_url('/'); ?>"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">Kelas</a></li>
            <li class="breadcrumb-item"><a href="#">Jurusan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
        </ol>
    </nav>
    <!-- End Breadcrumb -->

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Mata Pelajaran</h6>
            <a href="<?= site_url('mapel/tambah'); ?>" class="btn btn-sm btn-success shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import Excel
            </a>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('mapel/tambah'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatabel">
                    <thead class="bg-primary text-white text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Kode Mapel</th>
                            <th>Nama Mapel</th>
                            <th>Tahun Ajaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mapel)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data mapel.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($mapel as $m): ?>
                                <tr class="text-center">
                                    <th class="align-middle"><?= $no++; ?></th>
                                    <td class="text-start align-middle"><?= esc($m->kode_mapel); ?></td>
                                    <td class="align-middle"><?= esc($m->nama_mapel); ?></td>
                                    <td class="align-middle"><?= esc($m->semester . ' - ' . $m->tahun); ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <a href="<?= site_url('mapel/edit/' . $m->id); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a href="<?= site_url('mapel/delete/' . $m->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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