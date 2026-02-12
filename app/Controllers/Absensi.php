<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\SiswaModel;
use App\Models\KetAbsenModel;
use App\Models\KalenderModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $jadwalModel;
    protected $siswaModel;
    protected $ketAbsenModel;
    protected $hariLiburModel;


    public function __construct()
    {
        $this->absensiModel   = new AbsensiModel();
        $this->mapelModel     = new MapelModel();
        $this->kelasModel     = new KelasModel();
        $this->jadwalModel    = new JadwalModel();
        $this->siswaModel     = new SiswaModel();
        $this->ketAbsenModel  = new KetAbsenModel();
        $this->hariLiburModel = new KalenderModel();
    }

    public function index()
    {
        $guruId   = session()->get('id_guru');
        $tanggal  = date('Y-m-d');

        $id_kelas = $this->request->getGet('id_kelas');
        $id_mapel = $this->request->getGet('id_mapel');

        $kelas = $this->jadwalModel->getKelasHariIni($guruId);
        $mapel = $this->jadwalModel->getMapelHariIni($guruId);

        $pertemuan  = 1;
        $id_jadwal  = null;
        $siswa      = [];
        $nama_mapel = '-';
        $nama_kelas = '-';

        if ($id_kelas && !is_numeric($id_kelas)) {
            return redirect()->back()->with('error', 'ID kelas tidak valid.');
        }

        if ($id_mapel && !is_numeric($id_mapel)) {
            return redirect()->back()->with('error', 'ID mapel tidak valid.');
        }

        if ($id_kelas && $id_mapel) {

            $jadwal = $this->jadwalModel->getHariJadwal($id_mapel, $id_kelas);

            if (!$jadwal) {
                return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
            }

            $id_jadwal = $jadwal->id;
            $pertemuan = $this->absensiModel->getJumlahPertemuan($id_jadwal) + 1;


            if ($this->ketAbsenModel->isGuruTidakMasuk($guruId, $tanggal, $id_jadwal)) {
                return redirect()->back()->with('error', 'Anda tercatat tidak masuk hari ini.');
            }

            $libur = $this->hariLiburModel->where('tanggal', $tanggal)->first();
            if ($libur) {
                return redirect()->back()->with(
                    'error',
                    'Hari ini libur: ' . $libur->nama_libur
                );
            }

            $siswa = $this->siswaModel
                ->where('kelas_id', $id_kelas)
                ->where('status', 'Aktif')
                ->findAll();

            if (empty($siswa)) {
                return redirect()->back()->with('error', 'Tidak ada siswa aktif di kelas ini.');
            }

            $mapelData = $this->mapelModel->find($id_mapel);
            $kelasData = $this->kelasModel->find($id_kelas);

            $nama_mapel = $mapelData->kode_mapel ?? '-';
            $nama_kelas = $kelasData->nama_kls ?? '-';
        }


        $data = [
            'title'        => 'Absensi',
            'kelas'        => $kelas,
            'mapel'        => $mapel,
            'absensi'      => $siswa,
            'id_kelas'     => $id_kelas,
            'id_mapel'     => $id_mapel,
            'tanggal'      => $tanggal,
            'nama_kelas'   => $nama_kelas,
            'nama_mapel'   => $nama_mapel,
            'pertemuan'    => $pertemuan,
            'jadwalGuru'   => $this->jadwalModel->getJadwalToday($guruId),
        ];

        return view('users/absensi/index', $data);
    }


    public function save()
    {
        $id_kelas  = $this->request->getPost('id_kelas');
        $id_mapel  = $this->request->getPost('id_mapel');
        $tanggal   = $this->request->getPost('tanggal');
        $pertemuan = $this->request->getPost('pertemuan');
        $status    = $this->request->getPost('status');

        $jadwal = $this->jadwalModel->getHariJadwal($id_mapel, $id_kelas);
        if (!$jadwal) {
            return redirect()->to('/absensi')->with('error', 'Jadwal tidak ditemukan.');
        }

        // Cek apakah sudah pernah absen
        $cekAbsen = $this->absensiModel->getCekAbsen($jadwal->id, $tanggal, $pertemuan);
        if ($cekAbsen > 0) {
            return redirect()->to('/absensi')->with(
                'error',
                'Jadwal ini sudah diabsen sebelumnya. Absen hanya bisa dilakukan satu kali.'
            );
        }

        // Simpan absensi
        foreach ($status as $id_siswa => $stat) {
            $this->absensiModel->insert([
                'id_siswa'     => $id_siswa,
                'id_jadwal'    => $jadwal->id,
                'tanggal'      => $tanggal,
                'pertemuan_ke' => $pertemuan,
                'status'       => $stat,
            ]);
        }

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil disimpan.');
    }
}
