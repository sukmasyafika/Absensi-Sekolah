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
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Absensi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Mata Pelajaran</th>
                <th>Semester</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row->nama) ?></td>
                    <td><?= esc($row->jenis_kelamin) ?></td>
                    <td><?= esc($row->nama_kls . ' ' . $row->rombel) ?></td>
                    <td><?= esc($row->kode_jurusan) ?></td>
                    <td><?= esc($row->nama_mapel) ?></td>
                    <td><?= esc($row->semester) ?></td>
                    <td><?= $row->hadir ?></td>
                    <td><?= $row->sakit ?></td>
                    <td><?= $row->izin ?></td>
                    <td><?= $row->alpa ?></td>
                    <td><?= $row->total ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>