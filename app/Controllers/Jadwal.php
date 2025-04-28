<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal',
            'jadwal' => $this->jadwalModel->getJadwal(),
        ];

        return view('admin/jadwal/index', $data);
    }
}
