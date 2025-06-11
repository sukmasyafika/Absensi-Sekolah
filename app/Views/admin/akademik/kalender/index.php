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

  <h1 class="h3 mb-4 text-gray-800 fw-bold"><?= $title; ?></h1>

  <div class="card shadow-lg mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Manajemen Hari Libur</h6>
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
        <a href="<?= site_url('kalender/create'); ?>" class="btn btn-primary">
          <i class="bi bi-plus-circle"></i> Tambah Data
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover" id="datatabel">
          <thead class="bg-primary text-white text-center align-middle">
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Libur</th>
              <th>Keterangan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($kalender)): ?>
              <tr>
                <td colspan="5" class="text-center">Tidak ada data Hari Libur.</td>
              </tr>
            <?php else: ?>
              <?php $no = 1; ?>
              <?php foreach ($kalender as $k): ?>
                <tr class="text-center">
                  <td class="align-middle"><?= $no++; ?></td>
                  <td class="text-start align-middle"><?= esc($k->tanggal); ?></td>
                  <td class="align-middle"><?= esc($k->nama_libur); ?></td>
                  <td class="align-middle"><?= esc($k->keterangan); ?></td>
                  <td class="align-middle">
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                      <a href="<?= site_url('kalender/edit/' . $k->id); ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit
                      </a>
                      <form class="form-hapus d-inline" method="post" action="<?= base_url('kalender/delete/' . $k->id); ?>">
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