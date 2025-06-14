<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Rekap Absensi</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11px;
      margin: 10px;
    }

    .kop {
      text-align: center;
      margin-bottom: 10px;
    }

    .kop h3 {
      margin: 0;
      font-size: 13pt;
      font-weight: bold;
    }

    .kop h4 {
      margin: 2px 0;
      font-size: 12pt;
      font-weight: normal;
    }

    .kop .alamat {
      font-size: 9pt;
      margin: 4px 0;
      line-height: 1.3;
    }

    hr {
      border: 1px solid #000;
      margin-top: 8px;
      margin-bottom: 8px;
    }

    .info {
      margin-top: 10px;
      margin-bottom: 15px;
    }

    .info p {
      margin: 3px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th {
      font-size: 8pt;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 5px;
      text-align: center;
      vertical-align: middle;
    }

    td:nth-child(2) {
      text-align: left;
    }

    .footer-ttd {
      margin-top: 60px;
      text-align: right;
    }
  </style>
</head>

<body>

  <div class="kop">
    <h3>PEMERINTAH KOTA JAYAPURA</h3>
    <h3>DINAS PENDIDIKAN DAN KEBUDAYAAN</h3>
    <h3>SMK NEGERI 5 SENI DAN INDUSTRI KREATIF KOTA JAYAPURA</h3>
    <p class="alamat">
      Jalan Baru Pasar Yotefa, Wai Mhorock, Abepura 99351<br>
      Telp. (0967) 582201, E-mail: <i>smkn5jpr@gmail.com</i>
    </p>
    <hr>
  </div>


  <div class="info">
    <p><strong>Kelas</strong> : <?= $kelas->nama_kls . ' ' . $kelas->kd_jurusan . ' ' . $kelas->rombel; ?></p>
    <p><strong>Mata Pelajaran</strong> : <?= $mapel->nama_mapel; ?></p>
    <p><strong>Guru Pengajar</strong> : <?= $guru->nama; ?></p>
    <p><strong>Tahun Ajaran</strong> : <?= $tahun_ajaran->semester . ' - ' . $tahun_ajaran->tahun; ?></p>
    <?php if (!empty($periode)): ?>
      <p><strong>Periode</strong> : <?= $periode; ?></p>
    <?php endif; ?>
  </div>

  <table>
    <thead>
      <tr>
        <th rowspan="3">No</th>
        <th rowspan="3">Nama Siswa</th>
        <th rowspan="3">JK</th>
        <th colspan="<?= count($tanggalPertemuan); ?>">Pertemuan Ke-</th>
        <th colspan="4">TOTAL</th>
      </tr>
      <tr>
        <?php if (!empty($tanggalPertemuan)): ?>
          <?php foreach ($tanggalPertemuan as $i => $t): ?>
            <th><?= $i + 1 ?></th>
          <?php endforeach; ?>
        <?php endif; ?>
        <th rowspan="2">H</th>
        <th rowspan="2">I</th>
        <th rowspan="2">S</th>
        <th rowspan="2">A</th>
      </tr>
      <tr>
        <?php if (!empty($tanggalPertemuan)): ?>
          <?php foreach ($tanggalPertemuan as $t): ?>
            <th><?= date('d/m', strtotime($t->tanggal)) ?></th>
          <?php endforeach; ?>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($siswa as $i => $s): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= $s->nama ?></td>
          <td><?= ($s->jenis_kelamin == 'Laki-laki') ? 'L' : 'P' ?></td>
          <?php foreach ($tanggalPertemuan as $t): ?>
            <td>
              <?php
              $status = $s->kehadiran[$t->pertemuan_ke] ?? '-';
              if ($status == 'H') {
                echo '✓';
              } elseif (in_array($status, ['I', 'S', 'A'])) {
                echo $status;
              } else {
                echo '-';
              }
              ?>
            </td>
          <?php endforeach; ?>
          <td><?= $s->H ?></td>
          <td><?= $s->I ?></td>
          <td><?= $s->S ?></td>
          <td><?= $s->A ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer-ttd">
    <p>Jayapura, <?= $tgl_cetak; ?></p>
    <p>Wali Kelas,</p>
    <div style="height: 80px;"></div>
    <p><strong><u><?= $wali_kelas['nama']; ?></u></strong><br>
      NIP. <?= $wali_kelas['nip']; ?></p>
  </div>


</body>

</html>