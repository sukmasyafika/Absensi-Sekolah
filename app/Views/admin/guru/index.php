<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Guru</li>
    </ol>

    <h1 class="h3 mb-4 text-gray-800 fw-bold">Data Guru</h1>

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Manajemen Guru</h5>
            <a href="<?= site_url('guru/create'); ?>" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import Excel
            </a>
        </div>

        <div class="card-body">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-start mb-3">
                <a href="<?= site_url('guru/create'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatabel">
                    <thead class="bg-primary text-white text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIP</th>
                            <th>Jenis Kelamin</th>
                            <th>Jabatan</th>
                            <th>Tahun Masuk</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($guru)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data guru.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($guru as $g): ?>
                                <tr class="text-center">
                                    <th class="align-middle"><?= $no++; ?></th>
                                    <td class="text-start align-middle"><?= esc($g->nama); ?></td>
                                    <td class="align-middle"><?= esc($g->nip); ?></td>
                                    <td class="align-middle"><?= esc($g->jenis_kelamin); ?></td>
                                    <td class="align-middle"><?= esc($g->jabatan); ?></td>
                                    <td class="align-middle"><?= esc($g->thn_masuk); ?></td>
                                    <td class="align-middle">
                                        <?php if ($g->status == 'Aktif'): ?>
                                            <span class="badge bg-success"><?= esc($g->status); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= esc($g->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <a href="<?= base_url('guru/detail/' . $g->slug); ?>" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="<?= base_url('guru/edit/' . $g->slug); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form class="form-hapus d-inline" method="post" action="<?= base_url('guru/delete/' . $g->id); ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-delete btn-sm" onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
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