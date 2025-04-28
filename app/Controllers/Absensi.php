<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Absensi',
            'absensi' => $this->absensiModel->findAll(),
        ];

        return view('absensi/index', $data);
    }
}
