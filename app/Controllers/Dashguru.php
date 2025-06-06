<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AbsensiModel;



class Dashguru extends BaseController
{

  protected $jadwalModel, $absenModel;

  public function __construct()
  {
    $this->jadwalModel = new JadwalModel();
    $this->absenModel = new AbsensiModel();
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
        ->where('DATE(tanggal)', date('Y-m-d'))
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

      // Cek total absensi > 0, baru simpan ke array
      if ($rekap->total > 0) {
        $rekapAbsensi[$jadwal->id] = $rekap;
      }
    }

    $data = [
      'title' => 'Dashboard',
      'jadwalHariIni' => $jadwalHariIni,
      'rekapAbsensi' => $rekapAbsensi
    ];

    return view('users/dashboard', $data);
  }
}
