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
use App\Models\KalenderModel;

class Absensi extends BaseController
{
    protected $absensiModel, $mapelModel, $kelasModel, $siswaModel, $jadwalModel, $ketAbsenModel, $hariLiburModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->ketAbsenModel = new KetAbsenModel();
        $this->hariLiburModel = new KalenderModel();
    }

    public function index()
    {
        $guruId = session()->get('id_guru');
        $tanggal = date('Y-m-d');
        $pertemuan = 1;
        $id_jadwal = null;

        $kelas = $this->jadwalModel->getKelasHariIni($guruId);
        $mapel = $this->jadwalModel->getMapelHariIni($guruId);
        $id_kelas = $this->request->getGet('id_kelas');
        $id_mapel = $this->request->getGet('id_mapel');

        $mapelData = $id_mapel ? $this->mapelModel->find($id_mapel) : null;
        $nama_mapel = $mapelData ? $mapelData->kode_mapel : '-';
        $kelasData = $id_kelas ? $this->kelasModel->find($id_kelas) : null;
        $nama_kelas = $kelasData ? $kelasData->nama_kls : '-';

        if ($id_kelas && $id_mapel) {
            $jadwal = $this->jadwalModel->getHariJadwal($id_mapel, $id_kelas);
            if ($jadwal) {
                $id_jadwal = $jadwal->id;
                $pertemuan = $this->absensiModel->getJumlahPertemuan($id_jadwal) + 1;

                $cekTidakMasuk = $this->ketAbsenModel->isGuruTidakMasuk($guruId, $tanggal, $id_jadwal);
                if ($cekTidakMasuk) {
                    return redirect()->back()->with('error', 'Anda tidak dapat melakukan absen hari ini karena tercatat sebagai tidak masuk.');
                }

                $libur = $this->hariLiburModel->where('tanggal', $tanggal)->first();
                if ($libur) {
                    return redirect()->back()->with('error', 'Hari ini Tanggal Merah ' . $libur->nama_libur . ' - ' . $libur->keterangan);
                }
            } else {
                return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
            }
        }

        if ($id_kelas && !is_numeric($id_kelas)) {
            return redirect()->back()->with('error', 'ID Kelas tidak valid.');
        }
        if ($id_mapel && !is_numeric($id_mapel)) {
            return redirect()->back()->with('error', 'ID Mapel tidak valid.');
        }

        $siswa = $this->siswaModel->where('kelas_id', $id_kelas)->where('status', 'Aktif')->findAll();
        if ($id_kelas && empty($siswa)) {
            return redirect()->back()->with('error', 'Tidak ada data siswa di kelas ini.');
        }

        $data = [
            'title' => 'Absensi',
            'mapel' => $mapel,
            'kelas' => $kelas,
            'absensi' => $siswa,
            'id_mapel' => $id_mapel,
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal,
            'nama_mapel' => $nama_mapel,
            'nama_kelas' => $nama_kelas,
            'pertemuan' => $pertemuan,
            'jadwalGuru' => $this->jadwalModel->getJadwalToday($guruId)
        ];

        return view('users/absensi/index', $data);
    }

    public function save()
    {
        $id_kelas    = $this->request->getPost('id_kelas');
        $id_mapel    = $this->request->getPost('id_mapel');
        $tanggal     = $this->request->getPost('tanggal');
        $pertemuan   = $this->request->getPost('pertemuan');
        $statusAbsen = $this->request->getPost('status');

        $jadwal = $this->jadwalModel->getHariJadwal($id_mapel, $id_kelas);
        if (!$jadwal) {
            return redirect()->to('/absensi')->with('error', 'Jadwal tidak ditemukan.');
        }

        $cekAbsen = $this->absensiModel->getCekAbsen($jadwal, $tanggal);
        if ($cekAbsen > 0) {
            return redirect()->to('/absensi')->with('error', 'Jadwal ini sudah diabsen sebelumnya. Absen hanya bisa dilakukan satu kali.');
        }

        foreach ($statusAbsen as $id_siswa => $status) {
            $this->absensiModel->save([
                'id_siswa'     => $id_siswa,
                'id_jadwal'    => $jadwal->id,
                'tanggal'      => $tanggal,
                'pertemuan_ke' => $pertemuan,
                'status'       => $status,
            ]);
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil disimpan.');
    }

    public function savegurutidakmasuk()
    {
        $guruId = user()->id_guru;
        $tanggalHariIni = date('Y-m-d');
        $id_jadwal = $this->request->getPost('id_jadwal');

        $sudahIsi = $this->ketAbsenModel->getGuruTidakMasuk($guruId, $tanggalHariIni);
        if ($sudahIsi) {
            return redirect()->back()->with('error', 'Anda sudah mengisi form tidak masuk hari ini.');
        }

        foreach ($id_jadwal as $jadwalId) {
            $this->ketAbsenModel->insert([
                'id_guru' => $guruId,
                'id_jadwal' => $jadwalId,
                'tanggal' => $tanggalHariIni,
                'keterangan' => 'Tidak Masuk'
            ]);
        }

        return redirect()->to('/absensi')->with('success', 'Data ketidakhadiran berhasil disimpan.');
    }
}
