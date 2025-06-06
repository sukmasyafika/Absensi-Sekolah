<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kalender extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kalender Akademik'
        ];

        return view('admin/akademik/kalender/index', $data);
    }
}
