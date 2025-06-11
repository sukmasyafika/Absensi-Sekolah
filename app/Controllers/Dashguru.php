<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\KalenderModel;

class Dashguru extends BaseController
{

  protected $jadwalModel, $absenModel, $hariLiburModel;

  public function __construct()
  {
    $this->jadwalModel = new JadwalModel();
    $this->absenModel = new AbsensiModel();
    $this->hariLiburModel = new KalenderModel();
  }

  public function index()
  {
    $guruId = session()->get('id_guru');

    $jadwalHariIni = $this->jadwalModel->getJadwalDashboard($guruId);

    $rekapAbsensi = [];

    foreach ($jadwalHariIni as $jadwal) {
      $absen = $this->absenModel
        ->select("absensi.status, COUNT(*) as jumlah")
        ->where('id_jadwal', $jadwal->id)
        ->where('tanggal >=', date('Y-m-d 00:00:00'))
        ->where('tanggal <=', date('Y-m-d 23:59:59'))
        ->groupBy('absensi.status')
        ->findAll();

      $rekap = (object)[
        'Hadir' => 0,
        'Sakit' => 0,
        'Izin'  => 0,
        'Alpa'  => 0,
        'total' => 0,
      ];

      foreach ($absen as $a) {
        $status = $a->status;
        $jumlah = $a->jumlah;
        $rekap->$status = $jumlah;
        $rekap->total += $jumlah;
      }

      if ($rekap->total > 0) {
        $rekapAbsensi[$jadwal->id] = $rekap;
      }
    }

    $tanggal = date('Y-m-d');
    $libur = $this->hariLiburModel->where('tanggal', $tanggal)->first();

    $data = [
      'title' => 'Dashboard',
      'jadwalHariIni' => $jadwalHariIni,
      'rekapAbsensi' => $rekapAbsensi,
      'libur' => $libur
    ];

    return view('users/dashboard', $data);
  }
}
