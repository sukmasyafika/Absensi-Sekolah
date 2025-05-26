<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AbsensiModel;
use App\Models\MapelModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $mapelModel;
    protected $kelasModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Absensi',
            'absensi' => $this->absensiModel->findAll(),
            'mapel' => $this->jadwalModel->getMapelHariIni(),
            'kelas' => $this->jadwalModel->getKelasHariIni(),

        ];

        return view('users/absensi/index', $data);
    }
}
