<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\jurusanModel;

class Jurusan extends BaseController
{

    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new jurusanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'jurusan' => $this->jurusanModel->findAll(),
        ];

        return view('admin/akademik/jurusan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jurusan',
            'action' => site_url('jurusan/save'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/jurusan/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_jurusan' => [
                'rules' => 'required|is_unique[jurusan.kode_jurusan]',
                'errors' => [
                    'required' => 'Kode jurusan wajib diisi.',
                    'is_unique' => 'Kode Jurusan sudah terdaftar.',
                ]
            ],
            'nama_jurusan' => [
                'rules' => 'required|is_unique[jurusan.nama_jurusan]',
                'errors' => [
                    'required' => 'Jurusan wajib diisi.',
                    'is_unique' => 'Nama Jurusan sudah terdaftar.',
                ]
            ],

        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        $this->jurusanModel->insert([
            'kode_jurusan'           => $this->request->getVar('kode_jurusan'),
            'nama_jurusan'             => $this->request->getVar('nama_jurusan'),
        ]);

        return redirect()->to('/jurusan')->with('success', 'Data Jurusan Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $jurusan = $this->jurusanModel->find($id);

        if (!$jurusan) {
            return redirect()->to('/jurusan')->with('error', 'Data Jurusan tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Jurusan',
            'jurusan' => $jurusan,
            'action' => base_url('jurusan/update/' . $jurusan->id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/jurusan/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_jurusan' => [
                'rules' => 'required|is_unique[jurusan.kode_jurusan]|max_length[5]',
                'errors' => [
                    'required' => 'Kode jurusan wajib diisi.',
                    'is_unique' => 'Kode Jurusan sudah terdaftar.',
                    'max_length' => 'Kode Jurusan tidak boleh lebih dari 5 karakter.',
                ]
            ],
            'nama_jurusan' => [
                'rules' => 'required|is_unique[jurusan.nama_jurusan]',
                'errors' => [
                    'required' => 'Jurusan wajib diisi.',
                    'is_unique' => 'Nama Jurusan sudah terdaftar.',
                ]
            ],

        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->jurusanModel->update($id, [
            'kode_jurusan'           => $this->request->getVar('kode_jurusan'),
            'nama_jurusan'             => $this->request->getVar('nama_jurusan'),
        ]);

        return redirect()->to('/jurusan')->with('success', 'Data Jurusan Berhasil Perbaharui.');
    }
}
