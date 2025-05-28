<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ThnAjaranModel;
use App\Models\MapelModel;

class Mapel extends BaseController
{
    protected $mapelModel, $thnAjaranModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->thnAjaranModel = new ThnAjaranModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'mapel' => $this->mapelModel->getMapel(),
        ];

        return view('admin/akademik/mapel/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'action' => site_url('mapel/save'),
            'tahun' => $this->thnAjaranModel->getThnAjaran(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/mapel/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_mapel' => [
                'rules' => 'required|is_unique[mapel.kode_mapel]',
                'errors' => [
                    'required' => 'Kode mapel wajib diisi.',
                    'is_unique' => 'Kode Mapel sudah terdaftar.',
                ]
            ],
            'nama_mapel' => [
                'rules' => 'required|is_unique[mapel.nama_mapel]',
                'errors' => [
                    'required' => 'Nama Mapel wajib Diisi.',
                    'is_unique' => 'Nama Mapel sudah terdaftar.',
                ]
            ],
            'id_thnAjaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Ajaran wajib dipilih.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        dd($this->request->getVar());

        $this->mapelModel->insert([
            'kode_mapel'           => $this->request->getVar('kode_mapel'),
            'nama_mapel'             => $this->request->getVar('nama_mapel'),
            'id_thnAjaran'         => $this->request->getVar('id_thnAjaran'),
        ]);

        return redirect()->to('/mapel')->with('success', 'Data Mata Pelajaran Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $mapel = $this->mapelModel->find($id);

        if (!$mapel) {
            return redirect()->to('/mapel')->with('error', 'Data Mata Pelajaran tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Mata Pelajaran',
            'mapel' => $mapel,
            'tahun' => $this->thnAjaranModel->getThnAjaran(),
            'action' => base_url('mapel/update/' . $mapel->id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/mapel/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_mapel' => [
                'rules' => 'required|is_unique[mapel.kode_mapel,id,' . $id . ']',
                'errors' => [
                    'required' => 'Kode mapel wajib diisi.',
                    'is_unique' => 'Kode Mapel sudah terdaftar.',
                ]
            ],
            'nama_mapel' => [
                'rules' => 'required|is_unique[mapel.nama_mapel, id,' . $id . ']',
                'errors' => [
                    'required' => 'Nama Mapel wajib Diisi.',
                    'is_unique' => 'Nama Mapel sudah terdaftar.',
                ]
            ],
            'id_thnAjaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Ajaran wajib dipilih.',
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->mapelModel->update($id, [
            'kode_mapel'           => $this->request->getVar('kode_mapel'),
            'nama_mapel'             => $this->request->getVar('nama_mapel'),
            'id_thnAjaran'         => $this->request->getVar('id_thnAjaran'),
        ]);

        return redirect()->to('/mapel')->with('success', 'Data Mata Pelajaran Berhasil Perbaharui.');
    }
}
