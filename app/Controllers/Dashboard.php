<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\JurusanModel;
use App\Models\MapelModel;
use App\Models\UsersModel;

class Dashboard extends BaseController
{
  protected $guruModel, $siswaModel, $kelasModel, $jadwalModel, $jurusanModel, $mapelModel, $userModel;

  public function __construct()
  {
    $this->guruModel = new GuruModel();
    $this->siswaModel = new SiswaModel();
    $this->kelasModel = new KelasModel();
    $this->jadwalModel = new JadwalModel();
    $this->jurusanModel = new JurusanModel();
    $this->mapelModel = new MapelModel();
    $this->userModel = new UsersModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Dashboard',
      'totalGuru' => $this->guruModel->countAll(),
      'totalSiswa' => $this->siswaModel->countAll(),
      'totalKelas' => $this->kelasModel->countAll(),
      'totalJadwal' => $this->jadwalModel->countAll(),
      'totalJurusan' => $this->jurusanModel->countAll(),
      'totalMapel' => $this->mapelModel->countAll(),
      'totalUser' => $this->userModel->countAll(),
    ];

    return view('admin/dashboard', $data);
  }
}
