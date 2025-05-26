<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Profil extends BaseController
{
    public function index()
    {
        $profilModel = new UsersModel();
        $data = [
            'title' => 'Profil Guru',
            'userProfile' => $profilModel->getProfil(user()->id)
        ];
        return view('users/profil/index', $data);
    }
}
