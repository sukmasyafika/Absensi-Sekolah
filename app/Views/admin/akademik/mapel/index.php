<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
                <i class="bi bi-house-door-fill"></i> Home
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
    </ol>

    <div class="card shadow-lg mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Mata Pelajaran</h6>
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
                <a href="<?= site_url('mapel/create'); ?>" class="btn btn-primary">
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
                            <th>Jenis Mapel</th>
                            <th>Tahun Ajaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mapel)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data mapel.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($mapel as $m): ?>
                                <tr class="text-center">
                                    <td class="align-middle"><?= $no++; ?></td>
                                    <td class="text-start align-middle"><?= esc($m->kode_mapel); ?></td>
                                    <td class="align-middle"><?= esc($m->nama_mapel); ?></td>
                                    <td class="align-middle">
                                        <?= empty($m->nama_jurusan) ? 'Umum' : esc($m->nama_jurusan); ?>
                                    </td>
                                    <td class="align-middle"><?= esc($m->semester); ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <a href="<?= site_url('mapel/edit/' . $m->id); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form class="form-hapus d-inline" method="post" action="<?= base_url('mapel/delete/' . $m->id); ?>">
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