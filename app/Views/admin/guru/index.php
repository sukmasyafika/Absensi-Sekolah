<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

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
            <div class="dropdown-center ms-3">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Import Excel
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('Guru-Example.xlsx'); ?>">Contoh format File <i class="bi bi-download ms-3"></i></a></li>
                    <li><a class="dropdown-item fw-bold" data-bs-toggle="modal" data-bs-target="#modal-import">Upload File</a></li>
                </ul>
            </div>
        </div>

        <!-- Modal Import Data guru -->
        <div class="modal fade" id="modal-import" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content shadow-lg border-0 rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalImportLabel">
                            <i class="bi bi-upload me-2"></i>Import Data guru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= base_url('guru/import'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="formFile" class="form-label fw-semibold">Pilih File Excel</label>
                                <input type="file" name="file_excel" class="form-control" id="formFile" required>
                                <div class="form-text text-muted mt-1">
                                    Hanya mendukung format <strong>.xlsx</strong> atau <strong>.xls</strong>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

            <div class="d-flex justify-content-start mb-3">
                <a href="<?= site_url('guru/create'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
            </div>

            <form action="<?= site_url('guru/hapus'); ?>" method="post" class="form-hapus" id="formHapusBanyak">
                <?= csrf_field(); ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatabel">
                        <thead class="bg-primary text-white text-center ">
                            <tr>
                                <th style="width: 2%;" class="align-middle"><input type="checkbox" id="selectAll"></th>
                                <th style="width: 5%;" class="align-middle">No</th>
                                <th style="width: 15%;" class="align-middle">Nama Lengkap</th>
                                <th style="width: 8%;" class="align-middle">NIP</th>
                                <th style="width: 10%;" class="align-middle">Kategori</th>
                                <th style="width: 10%;" class="align-middle">Jabatan</th>
                                <th style="width: 5%;" class="align-middle">Tahun Masuk</th>
                                <th style="width: 10%;" class="align-middle">Status</th>
                                <th style="width: 20%;" class="align-middle">Action</th>
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
                                    <tr class="text-capitalize">
                                        <td><input type="checkbox" class="data-checkbox align-middle" name="ids[]" value="<?= $g->id ?>"></td>
                                        <td class="align-middle"><?= $no++; ?></td>
                                        <td class="text-start align-middle"><?= esc($g->nama); ?></td>
                                        <td class="align-middle"><?= esc($g->nip); ?></td>
                                        <td class="align-middle"><?= esc($g->kategori); ?></td>
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
                <div class="mt-3">
                    <button type="button" class="btn-delete btn btn-danger" id="btnHapusBanyak" disabled>
                        <i class="bi bi-trash3-fill me-1"></i> Hapus Data
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>