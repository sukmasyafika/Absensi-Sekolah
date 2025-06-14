<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Laporan Absensi Siswa</h2>

    <p><strong>Kelas:</strong> <?= $kelas->nama_kls . ' ' . $kelas->rombel ?></p>
    <p><strong>Mata Pelajaran:</strong> <?= $mapel->nama_mapel ?></p>
    <p><strong>Guru Pengajar:</strong> <?= $guru->nama_guru ?></p>
    <p><strong>Tahun Ajaran:</strong> <?= $tahun_ajaran ?></p>
    <p><strong>Tanggal Cetak:</strong> <?= $tgl_cetak ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Nama Siswa</th>
                <th>JK</th>
                <?php foreach ($tanggalPertemuan as $t): ?>
                    <th>P<?= $t->pertemuan_ke ?><br><small><?= date('d/m', strtotime($t->tanggal)) ?></small></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-left"><?= esc($row->nama) ?></td>
                    <td><?= esc($row->jk) ?></td>
                    <?php foreach ($tanggalPertemuan as $t): ?>
                        <td><?= $row->kehadiran[$t->pertemuan_ke] ?? '-' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>