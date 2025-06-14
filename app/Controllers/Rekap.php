<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AbsensiModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\SiswaModel;
use App\Models\KetAbsenModel;
use App\Models\GuruModel;
use Dompdf\Dompdf;

class Rekap extends BaseController
{
    protected $absensiModel, $mapelModel, $kelasModel, $siswaModel, $jadwalModel, $ketAbsenModel, $guruModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->ketAbsenModel = new KetAbsenModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $guruId = session()->get('id_guru');

        $id_kelas  = $this->request->getGet('id_kelas');
        $id_mapel  = $this->request->getGet('id_mapel');
        $dari      = $this->request->getGet('dari');
        $sampai    = $this->request->getGet('sampai');

        $kelas = $this->jadwalModel->getKelasRekap($guruId);
        $mapel = $this->jadwalModel->getMapelRekap($guruId);
        $rekap = [];

        if ($id_kelas && $id_mapel) {
            $jadwal = $this->jadwalModel->getCekJadwal($id_mapel, $id_kelas, $guruId);

            if (!$jadwal) {
                session()->setFlashdata('error', 'Jadwal tidak ditemukan untuk kelas dan mata pelajaran yang dipilih.');
            } else {

                if (!$jadwal) {
                    session()->setFlashdata('error', 'Kombinasi kelas & mapel tidak ditemukan dalam jadwal Anda.');
                    return redirect()->back()->withInput();
                }

                $rekap = $this->absensiModel->getRekapAbsensiLengkap($id_kelas, $id_mapel, $dari, $sampai);

                if (empty($rekap)) {
                    session()->setFlashdata('error', 'Jadwal tidak ditemukan sesuai filter yang dipilih.');
                }
            }
        }

        $data = [
            'title'     => 'Rekap Absensi',
            'mapel'     => $mapel,
            'kelas'     => $kelas,
            'id_mapel'  => $id_mapel,
            'id_kelas'  => $id_kelas,
            'dari'      => $dari,
            'sampai'    => $sampai,
            'rekap'     => $rekap,
        ];

        return view('users/rekap/index', $data);
    }

    public function cetakLaporan()
    {
        $dompdf = new Dompdf();

        $id_kelas  = $this->request->getGet('id_kelas');
        $id_mapel  = $this->request->getGet('id_mapel');
        $dari      = $this->request->getGet('dari');
        $sampai    = $this->request->getGet('sampai');

        $siswa = $this->siswaModel->where('kelas_id', $id_kelas)->findAll();

        $jadwal = $this->jadwalModel
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan untuk kelas dan mapel yang dipilih.');
        }

        $id_jadwal = $jadwal->id;

        $tanggalQuery = $this->absensiModel
            ->select('pertemuan_ke, tanggal')
            ->where('id_jadwal', $id_jadwal);

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
                $absen = $this->absensiModel
                    ->where('id_jadwal', $id_jadwal)
                    ->where('id_siswa', $s->id)
                    ->where('pertemuan_ke', $t->pertemuan_ke)
                    ->first();

                $mapStatus = [
                    'Hadir' => 'H',
                    'Izin' => 'I',
                    'Sakit' => 'S',
                    'Alpa' => 'A',
                    'H' => 'H',
                    'I' => 'I',
                    'S' => 'S',
                    'A' => 'A'
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
            'tahun_ajaran' => $this->jadwalModel->getTahunAjaranByJadwal($id_jadwal),
            'tgl_cetak' => date('d-m-Y'),
            'periode' => (!empty($dari) && !empty($sampai))
                ? date('d/m/Y', strtotime($dari)) . ' - ' . date('d/m/Y', strtotime($sampai))
                : null,
            'wali_kelas' => [
                'nama' => $waliKelas->nama,
                'nip' => $waliKelas->nip,
            ]
        ];

        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);

        $html = view('users/rekap/absensi_rekap', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan-absensi.pdf', ['Attachment' => false]);
    }
}
