<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .kop {
            text-align: center;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .kop h1,
        .kop h2,
        .kop h3,
        .kop p {
            margin: 0;
            padding: 0;
        }

        hr {
            border: 0;
            border-top: 2px solid #000;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10pt;
        }

        thead {
            background-color: #f2f2f2;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: center;
        }

        td.nama {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="kop">
        <h3>PEMERINTAH KOTA JAYAPURA</h3>
        <h3>DINAS PENDIDIKAN DAN KEBUDAYAAN</h3>
        <h2>SMK NEGERI 5 SENI DAN INDUSTRI KREATIF KOTA JAYAPURA</h2>
        <p>Jalan Baru Pasar Yotefa, Wai Mhorock, Abepura 99351</p>
        <p>Telp. (0967) 582201, E-mail: smkn5jpr@gmail.com</p>
    </div>

    <hr>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nisn ?></td>
                    <td class="nama"><?= ucwords(strtolower($row->nama)) ?></td>
                    <td><?= date('d F Y', strtotime($row->tanggal_lahir)); ?></td>
                    <td><?= ($row->jenis_kelamin == 'Laki-laki') ? 'L' : 'P' ?></td>
                    <td><?= $row->agama ?></td>
                    <td><?= esc($row->kelas_name . ' ' . $row->jurusan_name . ' ' . $row->rombel); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>

</html>