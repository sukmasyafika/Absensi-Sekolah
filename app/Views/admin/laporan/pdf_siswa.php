<!-- app/Views/laporan/pdf_siswa.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Siswa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">LAPORAN DATA SISWA</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Rombel</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nisn'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= $row['agama'] ?></td>
                    <td><?= $row['kelas_name'] ?></td>
                    <td><?= $row['jurusan_name'] ?></td>
                    <td><?= $row['rombel'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>