<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GuruModel;

class Guru extends BaseController
{
    protected $guruModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Guru',
            'guru' => $this->guruModel->findAll(),
        ];

        return view('admin/guru/index', $data);
    }
}
