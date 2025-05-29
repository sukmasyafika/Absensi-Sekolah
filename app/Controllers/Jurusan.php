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
            'title' => 'Jurusan',
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
                'rules' => 'required|alpha_numeric|max_length[10]|is_unique[jurusan.kode_jurusan]',
                'errors' => [
                    'required' => 'Kode jurusan wajib diisi.',
                    'alpha_numeric' => 'Kode jurusan hanya boleh huruf dan angka.',
                    'max_length' => 'Kode jurusan maksimal 10 karakter.',
                    'is_unique' => 'Kode Jurusan sudah terdaftar.',
                ]
            ],
            'nama_jurusan' => [
                'rules' => 'required|alpha_space|min_length[3]|is_unique[jurusan.nama_jurusan]',
                'errors' => [
                    'required' => 'Jurusan wajib diisi.',
                    'alpha_space' => 'Nama jurusan hanya boleh huruf dan spasi.',
                    'min_length' => 'Nama jurusan minimal 3 karakter.',
                    'is_unique' => 'Nama Jurusan sudah terdaftar.',
                ]
            ]
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
                'rules' => 'required|alpha_numeric|max_length[10]|is_unique[jurusan.kode_jurusan,' . $id . ']',
                'errors' => [
                    'required' => 'Kode jurusan wajib diisi.',
                    'alpha_numeric' => 'Kode jurusan hanya boleh huruf dan angka.',
                    'max_length' => 'Kode jurusan maksimal 10 karakter.',
                    'is_unique' => 'Kode Jurusan sudah terdaftar.',
                ]
            ],
            'nama_jurusan' => [
                'rules' => 'required|alpha_space|min_length[3]|is_unique[jurusan.nama_jurusan,' . $id . ']',
                'errors' => [
                    'required' => 'Jurusan wajib diisi.',
                    'alpha_space' => 'Nama jurusan hanya boleh huruf dan spasi.',
                    'min_length' => 'Nama jurusan minimal 3 karakter.',
                    'is_unique' => 'Nama Jurusan sudah terdaftar.',
                ]
            ]
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

    public function delete($id)
    {
        $jurusan = $this->jurusanModel->find($id);

        if ($jurusan) {
            $this->jurusanModel->delete($id);
            return redirect()->back()->with('success', 'jurusan <strong>' . $jurusan->kode_jurusan . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data jurusan tidak ditemukan.');
    }
}
