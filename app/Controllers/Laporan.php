<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\JurusanModel;
use App\Controllers\BaseController;
use App\Models\ThnAjaranModel;
use Dompdf\Dompdf;

class Laporan extends BaseController
{
    protected $siswaModel, $jadwalModel, $absensiModel, $kelasModel, $mapelModel, $guruModel, $jurusanModel, $thnAjaranModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->jadwalModel = new JadwalModel();
        $this->absensiModel = new AbsensiModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new MapelModel();
        $this->guruModel = new GuruModel();
        $this->jurusanModel = new JurusanModel();
        $this->thnAjaranModel = new ThnAjaranModel();
    }

    public function index()
    {
        $id_kelas  = $this->request->getGet('id_kelas');
        $id_mapel  = $this->request->getGet('id_mapel');

        $kelas = $this->kelasModel->getKelas();
        $mapel = $this->mapelModel->findAll();

        $list_kelas = $this->kelasModel->getKelas();
        $jurusan    = $this->jurusanModel->findAll();

        $data = [
            'title'         => 'Laporan',
            'mapel'         => $mapel,
            'kelas'         => $kelas,
            'list_kelas'    => $list_kelas,
            'jurusan'       => $jurusan,
            'id_mapel'      => $id_mapel,
            'id_kelas'      => $id_kelas,
        ];

        return view('admin/laporan/index', $data);
    }

    public function siswaPdf()
    {
        $kelas_rombel = $this->request->getGet('kelas_rombel');
        $jurusan = $this->request->getGet('jurusan');

        $siswaQuery = $this->siswaModel->getSiswaQuery();

        if (!empty($kelas_rombel)) {
            $parts = explode('|', $kelas_rombel);
            if (count($parts) === 3) {
                [$nama_kls, $rombel, $kode_jurusan] = $parts;
                $siswaQuery = $siswaQuery
                    ->where('kelas.nama_kls', $nama_kls)
                    ->where('kelas.rombel', $rombel)
                    ->where('jurusan.kode_jurusan', $kode_jurusan);
            }
        }

        $dataSiswa = $siswaQuery->findAll();

        if ($this->request->is('get') && isset($_GET['download'])) {
            $dompdf = new \Dompdf\Dompdf();
            $html = view('admin/laporan/pdf_siswa', ['siswa' => $dataSiswa]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream('laporan-siswa-' . date('YmdHis') . '.pdf', ['Attachment' => false]);
        }

        $data = [
            'list_kelas' => $this->kelasModel->findAll(),
            'siswa' => $dataSiswa,
        ];

        return view('admin/laporan/pdf_siswa', $data);
    }

    public function absenPdf()
    {
        $dompdf = new \Dompdf\Dompdf();

        $id_kelas = $this->request->getGet('id_kelas');
        $id_mapel = $this->request->getGet('id_mapel');
        $semester = $this->request->getGet('semester');
        $dari     = $this->request->getGet('dari');
        $sampai   = $this->request->getGet('sampai');
        $semester   = $this->request->getGet('semester');

        $siswa = $this->siswaModel->where('kelas_id', $id_kelas)->findAll();

        $jadwal = $this->jadwalModel
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan untuk kelas dan mapel yang dipilih.');
        }

        $tanggalQuery = $this->absensiModel
            ->select('pertemuan_ke, tanggal');

        if (!empty($semester)) {
            $jadwalSemester = $this->jadwalModel->getJadwalWithSemester($semester);
            $idJadwalList = array_map(fn($obj) => $obj->id, $jadwalSemester);

            if (empty($idJadwalList)) {
                return redirect()->back()->with('error', 'Tidak ada jadwal untuk semester tersebut.');
            }

            $tanggalQuery->whereIn('id_jadwal', $idJadwalList);
        }

        if (!empty($dari)) {
            $tanggalQuery->where('tanggal >=', date('Y-m-d', strtotime($dari)));
        }

        if (!empty($sampai)) {
            $tanggalQuery->where('tanggal <=', date('Y-m-d', strtotime($sampai)));
        }

        $tanggalPertemuan = $tanggalQuery
            ->groupBy('pertemuan_ke, tanggal')
            ->orderBy('pertemuan_ke', 'ASC')
            ->findAll();

        $rekapAbsensi = [];

        foreach ($siswa as $s) {
            $rekap = new \stdClass();
            $rekap->id = $s->id;
            $rekap->nama = $s->nama;
            $rekap->jenis_kelamin = $s->jenis_kelamin;
            $rekap->kehadiran = [];
            $rekap->H = 0;
            $rekap->I = 0;
            $rekap->S = 0;
            $rekap->A = 0;

            foreach ($tanggalPertemuan as $t) {
                if (!empty($semester) && !empty($idJadwalSemester)) {
                    $absen = $this->absensiModel
                        ->whereIn('id_jadwal', $idJadwalList)
                        ->where('id_siswa', $s->id)
                        ->where('pertemuan_ke', $t->pertemuan_ke)
                        ->first();
                } else {
                    $absen = $this->absensiModel
                        ->where('id_jadwal', $jadwal->id)
                        ->where('id_siswa', $s->id)
                        ->where('pertemuan_ke', $t->pertemuan_ke)
                        ->first();
                }

                $mapStatus = [
                    'Hadir' => 'H',
                    'Izin'  => 'I',
                    'Sakit' => 'S',
                    'Alpa'  => 'A',
                    'H'     => 'H',
                    'I'     => 'I',
                    'S'     => 'S',
                    'A'     => 'A'
                ];

                $status = $absen->status ?? '-';
                $singkat = $mapStatus[$status] ?? '-';

                $rekap->kehadiran[$t->pertemuan_ke] = $singkat;

                if (in_array($singkat, ['H', 'I', 'S', 'A'])) {
                    $rekap->{$singkat}++;
                }
            }

            $rekapAbsensi[] = $rekap;
        }

        $kelas = $this->kelasModel->find($id_kelas);
        $waliKelas = $this->guruModel->find($kelas->wali_kelas_id);

        $data = [
            'siswa' => $rekapAbsensi,
            'tanggalPertemuan' => $tanggalPertemuan,
            'kelas' => $this->kelasModel->getKelas($id_kelas),
            'mapel' => $this->mapelModel->find($id_mapel),
            'guru' => $this->guruModel->find($jadwal->id_guru),
            'tahun_ajaran' => $this->jadwalModel->getTahunAjaranByJadwal($jadwal->id),
            'tgl_cetak' => date('d-m-Y'),
            'periode' => (!empty($dari) && !empty($sampai))
                ? date('d/m/Y', strtotime($dari)) . ' - ' . date('d/m/Y', strtotime($sampai))
                : null,
            'wali_kelas' => [
                'nama' => $waliKelas->nama ?? '',
                'nip' => $waliKelas->nip ?? '',
            ]
        ];

        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);

        $html = view('admin/laporan/pdf_absen', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan-absensi' . date('Ymd_His') . '.pdf', ['Attachment' => false]);
    }
}
