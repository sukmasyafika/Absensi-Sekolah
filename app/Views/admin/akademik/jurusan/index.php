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

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen jurusan</h6>
        </div>

        <div class="card-body">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi Kesalahan Mohon Di cek kembali:</strong>
                    <p class="ps-5"><?= session()->getFlashdata('error'); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-end mb-3">
                <a href="<?= site_url('jurusan/create'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatabel">
                    <thead class="bg-primary text-white text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Kode jurusan</th>
                            <th>Nama Jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($jurusan)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data jurusan.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($jurusan as $j): ?>
                                <tr class="text-center">
                                    <th class="align-middle"><?= $no++; ?></th>
                                    <td class="text-start align-middle"><?= esc($j->kode_jurusan); ?></td>
                                    <td class="align-middle"><?= esc($j->nama_jurusan); ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <a href="<?= site_url('jurusan/edit/' . $j->id); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form class="form-hapus d-inline" method="post" action="<?= base_url('jurusan/delete/' . $j->id); ?>">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn-delete btn btn-danger btn-sm">
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