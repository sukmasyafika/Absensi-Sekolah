<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ThnAjaranModel;

class ThnAjaran extends BaseController
{
    protected $thnAjaranModel;


    public function __construct()
    {
        $this->thnAjaranModel = new ThnAjaranModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Tahun Ajaran',
            'tahun' => $this->thnAjaranModel->findAll(),
        ];

        return view('admin/akademik/thnajaran/index', $data);
    }
}
