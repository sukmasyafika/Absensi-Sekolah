<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mt-5 pt-5">

  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
      <a href="<?= base_url('dashboard'); ?>" class="text-decoration-none text-primary">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
  </ol>

  <h1 class="h3 mb-4 text-gray-800 fw-bold">Daftar Pengguna</h1>

  <div class="card shadow-lg mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h5 class="m-0 font-weight-bold text-primary">Manajemen Pengguna</h5>
    </div>

    <div class="card-body">
      <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-striped table-hover" id="datatabel">
          <thead class="bg-primary text-white text-center align-middle">
            <tr>
              <th style="width: 5%;">No</th>
              <th style="width: 20%;">Nama Guru</th>
              <th style="width: 15%;">Role</th>
              <th style="width: 20%;">Username</th>
              <th style="width: 20%;">Email</th>
              <th style="width: 10%;">Status</th>
              <th style="width: 10%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($pengguna)): ?>
              <tr>
                <td colspan="7" class="text-center">Tidak ada data pengguna.</td>
              </tr>
            <?php else: ?>
              <?php $no = 1; ?>
              <?php foreach ($pengguna as $p): ?>
                <tr class="text-center text-capitalize">
                  <td class="align-middle"><?= $no++; ?></td>
                  <td class="align-middle"><?= esc($p->namaguru); ?></td>
                  <td class="align-middle">
                    <?php
                    $badgeClass = 'secondary';
                    switch (strtolower($p->group_name)) {
                      case 'admin':
                        $badgeClass = 'success';
                        break;
                      case 'guru':
                        $badgeClass = 'primary';
                        break;
                      case 'kajur':
                        $badgeClass = 'danger';
                        break;
                      case 'wali kelas':
                        $badgeClass = 'warning';
                        break;
                    }
                    ?>
                    <span class="badge bg-<?= $badgeClass; ?> text-uppercase"><?= esc($p->group_name); ?></span>
                  </td>
                  <td class="align-middle"><?= esc($p->username); ?></td>
                  <td class="align-middle"><?= esc($p->email); ?></td>
                  <td class="align-middle">
                    <?php if ($p->active == '1'): ?>
                      <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                      <span class="badge bg-danger">Tidak Aktif</span>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle">
                    <a href="<?= site_url('user/edit/' . $p->userid); ?>" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square"></i> Edit
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