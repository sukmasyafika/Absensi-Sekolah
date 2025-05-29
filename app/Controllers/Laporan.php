<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Laporan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Laporan',
        ];

        return view('admin/laporan/index', $data);
    }
}
