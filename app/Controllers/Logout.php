<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Logout extends BaseController
{
    public function index()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}
