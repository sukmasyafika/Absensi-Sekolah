<?php

use App\Controllers\Siswa;
?>
<?= $this->extend('layout/template'); ?>

<?= $this->section('admin-content'); ?>

<div class="container-fluid">


  <h1 class="h3 mb-3 text-gray-800 fw-bold"><?= $title ?></h1>

  <h3 class="text-uppercase">Nama lengkap <?= esc($siswa->nama); ?></h3>
  <h3 class="text-uppercase">nisn: <?= esc($siswa->nisn); ?></h3>
  <h3 class="text-uppercase">tanggal lahir: <?= esc($siswa->tanggal_lahir); ?></h3>
  <h3 class="text-uppercase">jenis Kelamin: <?= esc($siswa->jenis_kelamin); ?></h3>
  <h3 class="text-uppercase">Kelas: <?= esc($siswa->kelas_name . ' ' . $siswa->jurusan_name . ' ' . $siswa->rombel); ?></h3>
  <h3 class="text-uppercase">agama: <?= esc($siswa->agama); ?></h3>
  <h3 class="text-uppercase">tahun masuk: <?= esc($siswa->thn_masuk); ?></h3>
  <h3 class="text-uppercase">status: <?= esc($siswa->status); ?></h3>

  <a href="<?= base_url('/siswa'); ?>" class="btn btn-secondary me-3">
    <i class="bi bi-arrow-left-square"></i> Kembali
  </a>

</div>

<?= $this->endSection(); ?>