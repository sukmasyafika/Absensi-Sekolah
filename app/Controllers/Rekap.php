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

class Rekap extends BaseController
{
    protected $absensiModel, $mapelModel, $kelasModel, $siswaModel, $jadwalModel, $ketAbsenModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jadwalModel = new JadwalModel();
        $this->siswaModel = new SiswaModel();
        $this->ketAbsenModel = new KetAbsenModel();
    }

    public function index()
    {
        $guruId = session()->get('id_guru');

        $id_kelas  = $this->request->getGet('id_kelas');
        $id_mapel  = $this->request->getGet('id_mapel');
        $semester  = $this->request->getGet('semester');
        $dari      = $this->request->getGet('dari');
        $sampai    = $this->request->getGet('sampai');

        $kelas = $this->jadwalModel->getKelasRekap($guruId);
        $mapel = $this->jadwalModel->getMapelRekap($guruId);
        $rekap = [];

        if ($id_kelas && $id_mapel) {
            $jadwal = $this->jadwalModel->getCekJadwal($id_mapel, $id_kelas);

            if (!$jadwal) {
                session()->setFlashdata('error', 'Jadwal tidak ditemukan untuk kelas dan mata pelajaran yang dipilih.');
            } else {
                $rekap = $this->absensiModel->getRekapAbsensi($id_kelas, $id_mapel, $semester, $dari, $sampai);

                if (empty($rekap)) {
                    session()->setFlashdata('error', 'Tidak ada data siswa yang ditemukan untuk filter yang dipilih.');
                }
            }
        }

        $data = [
            'title'     => 'Rekap Absensi',
            'mapel'     => $mapel,
            'kelas'     => $kelas,
            'id_mapel'  => $id_mapel,
            'id_kelas'  => $id_kelas,
            'semester'  => $semester,
            'dari'      => $dari,
            'sampai'    => $sampai,
            'rekap'     => $rekap
        ];

        return view('users/rekap/index', $data);
    }
}
