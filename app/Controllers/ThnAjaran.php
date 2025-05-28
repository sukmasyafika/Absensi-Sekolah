<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ThnAjaranModel;

class ThnAjaran extends BaseController
{
    protected $thnAjaranModel;


    public function __construct()
    {
        $this->thnAjaranModel = new ThnAjaranModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Tahun Ajaran',
            'tahun' => $this->thnAjaranModel->findAll(),
        ];

        return view('admin/akademik/thnajaran/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Tahun Ajaran',
            'action' => site_url('thnajaran/save'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/thnajaran/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'semester' => [
                'rules' => 'required|in_list[Ganjil,Genap]',
                'errors' => [
                    'required' => 'Semester wajib dipilih.',
                    'in_list' => 'Semester harus salah satu dari Ganjil & Genap.',
                ]
            ],
            'tahun' => [
                'rules' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'regex_match' => 'Tahun harus dalam format contoh: 2024/2025.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif,Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status harus salah satu dari Aktif atau Tidak Aktif.',
                ]
            ],
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        if ($this->thnAjaranModel->isDuplicate(
            $this->request->getVar('semester'),
            $this->request->getVar('tahun'),
        )) {
            return redirect()->back()->withInput()->with('error', 'Data Tahun Ajaran dengan kombinasi tersebut sudah Terdaftar.');
        }

        $this->thnAjaranModel->insert([
            'semester'           => $this->request->getVar('semester'),
            'tahun'             => $this->request->getVar('tahun'),
            'status'         => $this->request->getVar('status'),
        ]);

        return redirect()->to('/thnajaran')->with('success', 'Data Tahun Ajaran Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $thnajaran = $this->thnAjaranModel->find($id);

        if (!$thnajaran) {
            return redirect()->to('/thnajaran')->with('error', 'Data Tahun Ajaran tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Tahun Ajaran',
            'thnajaran' => $thnajaran,
            'action' => base_url('thnajaran/update/' . $thnajaran->id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/thnajaran/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'semester' => [
                'rules' => 'required|in_list[Ganjil,Genap]',
                'errors' => [
                    'required' => 'Semester wajib dipilih.',
                    'in_list' => 'Semester harus salah satu dari Ganjil & Genap.',
                ]
            ],
            'tahun' => [
                'rules' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'regex_match' => 'Tahun harus dalam format contoh: 2024/2025.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif,Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status harus salah satu dari Aktif atau Tidak Aktif.',
                ]
            ],
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        if ($this->thnAjaranModel->isDuplicate(
            $this->request->getVar('semester'),
            $this->request->getVar('tahun'),
        )) {
            return redirect()->back()->withInput()->with('error', 'Data Tahun Ajaran dengan kombinasi tersebut sudah Terdaftar.');
        }

        $this->thnAjaranModel->update($id, [
            'semester'           => $this->request->getVar('semester'),
            'tahun'             => $this->request->getVar('tahun'),
            'status'         => $this->request->getVar('status'),
        ]);

        return redirect()->to('/thnajaran')->with('success', 'Data Tahun Ajaran Berhasil Berhasil Diperbaharui.');
    }

    public function delete($id)
    {
        $thnajaran = $this->thnAjaranModel->find($id);

        if (!$thnajaran) {
            return redirect()->to('/thnajaran')->with('error', 'Data Tahun Ajaran tidak ditemukan.');
        }

        $this->thnAjaranModel->delete($id);
        return redirect()->to('/thnajaran')->with('success', 'Data Tahun Ajaran Berhasil Dihapus.');
    }
}
