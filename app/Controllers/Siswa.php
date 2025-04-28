<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SiswaModel;

class Siswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Siswa',
            'siswa' => $this->siswaModel->getSiswaWithKelas(),
        ];

        return view('admin/siswa/index', $data);
    }
}
