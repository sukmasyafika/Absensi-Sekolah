<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\GuruModel;

class User extends BaseController
{

    protected $userModel, $guruModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'pengguna' => $this->userModel->getPengguna()
        ];

        return view('admin/pengguna/index', $data);
    }

    public function edit($userid)
    {
        $pengguna = $this->userModel->getPengguna($userid);

        if (!$pengguna) {
            return redirect()->to('/user')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit pengguna',
            'pengguna' => $pengguna,
            'guru' => $this->guruModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/pengguna/form', $data);
    }

    public function update($userid)
    {
        $validation = service('validation');
        $validation->setRules([
            'id_guru' => [
                'rules' => 'required|is_unique[users.id_guru,id,' . $userid . ']',
                'errors' => [
                    'required' => 'Nama guru wajib dipilih.',
                    'is_unique' => 'Guru ini sudah terdaftar sebagai pengguna.',
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'username wajib Di Isi.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email,id,' . $userid . ']',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan oleh pengguna lain.',
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[admin,guru,kajur,wali_kelas]',
                'errors' => [
                    'required' => 'Role wajib diisi.',
                    'in_list' => 'Role tidak valid.',
                ]
            ],
            'active' => [
                'rules' => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Status aktif wajib dipilih.',
                    'in_list' => 'Status aktif harus bernilai 0 atau 1.',
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $dataUser = [
            'id_guru'  => $this->request->getVar('id_guru'),
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'active'   => $this->request->getVar('active'),
        ];

        $roleName = $this->request->getVar('role');

        if (!$this->userModel->updateUserData($userid, $dataUser)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pengguna.');
        }

        if (!$this->userModel->updateUserRole($userid, $roleName)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui role pengguna.');
        }

        return redirect()->to('/user')->with('success', 'Data pengguna berhasil diperbaharui.');
    }
}
