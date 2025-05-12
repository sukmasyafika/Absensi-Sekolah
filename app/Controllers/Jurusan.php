<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\jurusanModel;

class Jurusan extends BaseController
{

    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new jurusanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'jurusan' => $this->jurusanModel->findAll(),
        ];

        return view('admin/akademik/jurusan/index', $data);
    }
}
