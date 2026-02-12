<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\GuruModel;
use App\Models\JurusanModel;
use App\Models\ThnAjaranModel;
use Dompdf\Dompdf;

class Laporan extends BaseController
{
    protected $siswaModel, $jadwalModel, $absensiModel;
    protected $kelasModel, $mapelModel, $guruModel;
    protected $jurusanModel, $thnAjaranModel;

    public function __construct()
    {
        $this->siswaModel     = new SiswaModel();
        $this->jadwalModel    = new JadwalModel();
        $this->absensiModel   = new AbsensiModel();
        $this->kelasModel     = new KelasModel();
        $this->mapelModel     = new MapelModel();
        $this->guruModel      = new GuruModel();
        $this->jurusanModel   = new JurusanModel();
        $this->thnAjaranModel = new ThnAjaranModel();
    }

    /* ===================== INDEX ===================== */
    public function index()
    {
        $data = [
            'title'      => 'Laporan',
            'kelas'      => $this->kelasModel->getKelas(),
            'mapel'      => $this->mapelModel->findAll(),
            'list_kelas' => $this->kelasModel->getKelas(),
            'jurusan'    => $this->jurusanModel->findAll(),
            'id_kelas'   => $this->request->getGet('id_kelas'),
            'id_mapel'   => $this->request->getGet('id_mapel'),
            'id_jurusan' => $this->request->getGet('id_jurusan'),
            'filter' => [
                'semester' => $this->request->getGet('semester'),
                'dari'     => $this->request->getGet('dari'),
                'sampai'   => $this->request->getGet('sampai'),
            ]
        ];

        return view('admin/laporan/index', $data);
    }

    /* ===================== PDF ABSENSI ===================== */
    public function absenPdf()
    {
        $id_kelas = $this->request->getGet('id_kelas');
        $id_mapel = $this->request->getGet('id_mapel');
        $semester = $this->request->getGet('semester');
        $dari     = $this->request->getGet('dari');
        $sampai   = $this->request->getGet('sampai');

        $siswa = $this->siswaModel->where('kelas_id', $id_kelas)->findAll();
        if (!$siswa) {
            return redirect()->back()->with('error', 'Tidak ada siswa.');
        }

        $jadwal = $this->jadwalModel
            ->where('id_kelas', $id_kelas)
            ->where('id_mapel', $id_mapel)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        $tanggalQuery = $this->absensiModel->select('pertemuan_ke, tanggal');

        $idJadwalList = [$jadwal->id];

        if ($semester) {
            $jadwalSemester = $this->jadwalModel->getJadwalWithSemester($semester);
            $idJadwalList = array_map(fn($j) => $j->id, $jadwalSemester);
        }

        $tanggalQuery->whereIn('id_jadwal', $idJadwalList);

        if ($dari) {
            $tanggalQuery->where('tanggal >=', $dari);
        }
        if ($sampai) {
            $tanggalQuery->where('tanggal <=', $sampai);
        }

        $tanggalPertemuan = $tanggalQuery
            ->groupBy('pertemuan_ke, tanggal')
            ->orderBy('pertemuan_ke', 'ASC')
            ->findAll();

        if (!$tanggalPertemuan) {
            return redirect()->back()->with('error', 'Data absensi kosong.');
        }

        $rekapAbsensi = [];

        foreach ($siswa as $s) {
            $rekap = (object)[
                'id' => $s->id,
                'nama' => $s->nama,
                'jenis_kelamin' => $s->jenis_kelamin,
                'kehadiran' => [],
                'H' => 0,
                'I' => 0,
                'S' => 0,
                'A' => 0,
            ];

            foreach ($tanggalPertemuan as $t) {
                $absen = $this->absensiModel
                    ->whereIn('id_jadwal', $idJadwalList)
                    ->where('id_siswa', $s->id)
                    ->where('pertemuan_ke', $t->pertemuan_ke)
                    ->first();

                $map = ['Hadir' => 'H', 'Izin' => 'I', 'Sakit' => 'S', 'Alpa' => 'A'];
                $kode = $map[$absen->status ?? ''] ?? '-';

                $rekap->kehadiran[$t->pertemuan_ke] = $kode;
                if (isset($rekap->$kode)) $rekap->$kode++;
            }

            $rekapAbsensi[] = $rekap;
        }

        $kelas = $this->kelasModel->find($id_kelas);
        $wali  = ($kelas && $kelas->wali_kelas_id)
            ? $this->guruModel->find($kelas->wali_kelas_id)
            : null;

        $dompdf = new Dompdf();
        $html = view('admin/laporan/pdf_absen', [
            'siswa' => $rekapAbsensi,
            'tanggalPertemuan' => $tanggalPertemuan,
            'kelas' => $kelas,
            'mapel' => $this->mapelModel->find($id_mapel),
            'wali_kelas' => $wali,
            'tgl_cetak' => date('d-m-Y'),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-absensi.pdf', ['Attachment' => false]);
    }
}
