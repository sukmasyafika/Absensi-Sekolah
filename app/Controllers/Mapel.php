<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MapelModel;

class Mapel extends BaseController
{
    protected $mapelModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'mapel' => $this->mapelModel->findAll(),
        ];

        return view('mapel/index', $data);
    }
}
