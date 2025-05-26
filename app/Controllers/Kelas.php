<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\JurusanModel;

class Kelas extends BaseController
{
    protected $kelasModel, $guruModel, $jurusanModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelas',
            'kelas' => $this->kelasModel->getKelas(),
        ];

        return view('admin/akademik/kelas/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kelas',
            'action' => site_url('kelas/save'),
            'jurusan' => $this->jurusanModel->getListJurusan(),
            'wakel' => $this->guruModel->getWakel(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/kelas/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'nama_kls' => [
                'rules' => 'required|in_list[X,XI,XII]',
                'errors' => [
                    'required' => 'Kelas wajib dipilih.',
                    'in_list' => 'Kelas harus salah satu dari X, XI, atau XII.',
                ]
            ],
            'rombel' => [
                'rules' => 'required|in_list[A,B,C]',
                'errors' => [
                    'required' => 'Rombel wajib Dipilih.',
                    'in_list' => 'Rombel harus salah satu dari A, B, atau C.'
                ]
            ],
            'jurusan_id' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Jurusan wajib dipilih.',
                    'is_natural_no_zero' => 'Jurusan tidak valid.'
                ]
            ],
            'wali_kelas_id' => [
                'rules' => 'required|is_unique[kelas.wali_kelas_id]',
                'errors' => [
                    'required' => 'Wali kelas wajib dipilih.',
                    'is_unique' => 'Wali kelas sudah terdaftar di kelas lain.',
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        if ($this->kelasModel->isDuplicate(
            $this->request->getVar('nama_kls'),
            $this->request->getVar('rombel'),
            $this->request->getVar('jurusan_id')
        )) {
            return redirect()->back()->withInput()->with('error', 'Data kelas dengan kombinasi tersebut sudah Terdaftar.');
        }

        $this->kelasModel->insert([
            'nama_kls'           => $this->request->getVar('nama_kls'),
            'rombel'             => $this->request->getVar('rombel'),
            'jurusan_id'         => $this->request->getVar('jurusan_id'),
            'wali_kelas_id'      => $this->request->getVar('wali_kelas_id'),
        ]);

        return redirect()->to('/kelas')->with('success', 'Data kelas Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = $this->kelasModel->find($id);

        if (!$kelas) {
            return redirect()->to('/kelas')->with('error', 'Data kelas tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit kelas',
            'kelas' => $kelas,
            'jurusan' => $this->jurusanModel->getListJurusan(),
            'wakel' => $this->guruModel->getWakel(),
            'action' => base_url('kelas/update/' . $kelas->id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/kelas/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'nama_kls' => [
                'rules' => 'required|in_list[X,XI,XII]',
                'errors' => [
                    'required' => 'Kelas wajib dipilih.',
                    'in_list' => 'Kelas harus salah satu dari X, XI, atau XII.',
                ]
            ],
            'rombel' => [
                'rules' => 'required|in_list[A,B,C]',
                'errors' => [
                    'required' => 'Rombel wajib Dipilih.',
                    'in_list' => 'Rombel harus salah satu dari A, B, atau C.'
                ]
            ],
            'jurusan_id' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Jurusan wajib dipilih.',
                    'is_natural_no_zero' => 'Jurusan tidak valid.'
                ]
            ],
            'wali_kelas_id' => [
                'rules' => 'required|is_unique[kelas.wali_kelas_id,id,' . $id . ']',
                'errors' => [
                    'required' => 'Wali kelas wajib dipilih.',
                    'is_unique' => 'Wali kelas sudah terdaftar di kelas lain.',
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        if ($this->kelasModel->isDuplicate(
            $this->request->getVar('nama_kls'),
            $this->request->getVar('rombel'),
            $this->request->getVar('jurusan_id'),
            $id
        )) {
            return redirect()->back()->withInput()->with('error', 'Data kelas tersebut sudah ada.');
        }

        $this->kelasModel->update($id, [
            'nama_kls'           => $this->request->getVar('nama_kls'),
            'rombel'             => $this->request->getVar('rombel'),
            'jurusan_id'         => $this->request->getVar('jurusan_id'),
            'wali_kelas_id'      => $this->request->getVar('wali_kelas_id'),
        ]);

        return redirect()->to('/kelas')->with('success', 'Data Kelas berhasil diperbaharui.');
    }

    public function delete($id)
    {
        $kelas = $this->kelasModel->find($id);

        if ($kelas) {
            $this->kelasModel->delete($id);
            return redirect()->back()->with('success', 'kelas <strong>' . $kelas->nama_kls . $kelas->rombel . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data kelas tidak ditemukan.');
    }
}
