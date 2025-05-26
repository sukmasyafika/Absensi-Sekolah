<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid mb-5">
  <h1 class="h3 mb-4 text-gray-800 fw-bold">My Profil</h1>
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="d-flex justify-content-end mb-3">
        <a href="" class="btn btn-primary shadow-sm rounded-pill px-4">
          <i class="bi bi-pencil-square me-2"></i> Edit Profil
        </a>
      </div>
      <div class="card mb-3 shadow-lg">
        <div class="row g-0">
          <div class="col-md-4 d-flex align-items-center justify-content-center bg-danger  text-white rounded">
            <img src="<?= base_url('assets/img/guru/' . (!empty($userProfile->foto) ? $userProfile->foto : 'default.png')); ?>" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <h5 class="text-dark"><strong>Nama Lengkap :</strong> <?= esc($userProfile->nama); ?></h5>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">NIP :</strong> <?= !empty(esc($userProfile->nip)) ? esc($userProfile->nip) : '-'; ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Email :</strong> <?= esc($userProfile->email); ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Jabatan :</strong> <?= esc($userProfile->jabatan); ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Tanggal Lahir :</strong> <?= date('d F Y', strtotime($userProfile->tanggal_lahir)); ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Jenis Kelamin :</strong> <?= esc($userProfile->jenis_kelamin); ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Agama :</strong> <?= esc($userProfile->agama); ?>
                </li>
                <li class="list-group-item">
                  <strong class="text-dark">Tahun Masuk :</strong> <?= esc($userProfile->thn_masuk); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>