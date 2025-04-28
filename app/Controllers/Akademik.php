<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ThnAjaranModel;
use App\Models\KelasModel;
use App\Models\mapelModel;

class Akademik extends BaseController
{

    protected $thnAjaranModel;
    protected $kelasModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->thnAjaranModel = new ThnAjaranModel();
        $this->kelasModel = new KelasModel();
        $this->mapelModel = new mapelModel();
    }

    public function thnajaran()
    {
        $data = [
            'title' => 'Tahun Ajaran',
            'tahun' => $this->thnAjaranModel->findAll(),
        ];

        return view('admin/akademik/thnajaran/index', $data);
    }

    public function kelas()
    {
        $data = [
            'title' => 'Kelas',
            'kelas' => $this->kelasModel->getKelas(),
        ];

        return view('admin/akademik/kelas/index', $data);
    }

    public function mapel()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'mapel' => $this->mapelModel->getMapel(),
        ];

        return view('admin/akademik/mapel/index', $data);
    }
}
