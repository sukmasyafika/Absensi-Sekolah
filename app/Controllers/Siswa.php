<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SiswaModel;
use App\Models\KelasModel;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Siswa',
            'siswa' => $this->siswaModel->getSiswaWithKelas(),
        ];

        return view('admin/siswa/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Siswa',
            'siswa' => $this->siswaModel->getSiswa($slug),
        ];
        return view('admin/siswa/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'action' => site_url('siswa/save'),
            'kelas_id' => $this->kelasModel->getKelas(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/siswa/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ]
            ],
            'nisn' => [
                'rules' => 'required|is_unique[siswa.nisn]|numeric|exact_length[10]',
                'errors' => [
                    'required'      => 'NISN wajib diisi.',
                    'is_unique'     => 'NISN sudah terdaftar, gunakan NISN lain.',
                    'numeric'       => 'NISN hanya boleh berisi angka.',
                    'exact_length'  => 'NISN harus terdiri dari 10 digit angka.'
                ]
            ],
            'kelas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas wajib dipilih.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal Lahir wajib diisi.',
                    'valid_date' => 'Format Tanggal Lahir tidak valid. Gunakan format YYYY-MM-DD.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Jenis Kelamin wajib dipilih.',
                    'in_list' => 'Jenis Kelamin tidak valid.'
                ]
            ],
            'agama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Agama wajib dipilih.'
                ]
            ],
            'thn_masuk' => [
                'rules' => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required' => 'Tahun Masuk wajib diisi.',
                    'exact_length' => 'Tahun Masuk harus 4 digit.',
                    'numeric' => 'Tahun Masuk harus angka.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif, Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status tidak valid.'
                ]
            ],
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $slug = url_title($this->request->getVar('nama'), '-', true);

        $this->siswaModel->insert([
            'nama'           => $this->request->getPost('nama'),
            'slug'           => $slug,
            'nisn'           => $this->request->getPost('nisn'),
            'kelas_id'       => $this->request->getPost('kelas_id'),
            'tanggal_lahir'  => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),
            'agama'          => $this->request->getPost('agama'),
            'thn_masuk'      => $this->request->getPost('thn_masuk'),
            'status'         => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Data Siswa Berhasil Ditambahkan.');

        return redirect()->to('/siswa');
    }

    public function edit($slug)
    {
        $siswa = $this->siswaModel->getSiswa($slug);

        $data = [
            'title' => 'Edit Siswa',
            'action' => base_url('siswa/update/' . $siswa->id),
            'kelas_id' => $this->kelasModel->getKelas(),
            'siswa' => $siswa,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/siswa/form', $data);
    }

    public function update($id)
    {
        $siswaLama = $this->siswaModel->getSiswa($this->request->getVar('slug'));

        if ($siswaLama && $siswaLama->nama === $this->request->getVar('nama')) {
            $nama = 'required';
        } else {
            $nama = 'required|is_unique[siswa.nama]';
        }

        $validation = service('validation');
        $validation->setRules([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ]
            ],
            'nisn' => [
                'rules' => 'required|numeric|exact_length[10]|is_unique[siswa.nisn,id,' . $id . ']',
                'errors' => [
                    'required'      => 'NISN wajib diisi.',
                    'numeric'       => 'NISN hanya boleh berisi angka.',
                    'exact_length'  => 'NISN harus terdiri dari 10 digit angka.',
                    'is_unique'     => 'NISN sudah terdaftar, gunakan NISN lain.'
                ]
            ],
            'kelas_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas wajib dipilih.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal Lahir wajib diisi.',
                    'valid_date' => 'Format Tanggal Lahir tidak valid. Gunakan format YYYY-MM-DD.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Jenis Kelamin wajib dipilih.',
                    'in_list' => 'Jenis Kelamin tidak valid.'
                ]
            ],
            'agama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Agama wajib dipilih.'
                ]
            ],
            'thn_masuk' => [
                'rules' => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required' => 'Tahun Masuk wajib diisi.',
                    'exact_length' => 'Tahun Masuk harus 4 digit.',
                    'numeric' => 'Tahun Masuk harus angka.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif, Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status tidak valid.'
                ]
            ],
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $slug = url_title($this->request->getPost('nama'), '-', true);
        $this->siswaModel->update($id, [
            'nama'           => $this->request->getPost('nama'),
            'slug'           => $slug,
            'nisn'           => $this->request->getPost('nisn'),
            'kelas_id'       => $this->request->getPost('kelas_id'),
            'tanggal_lahir'  => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),
            'agama'          => $this->request->getPost('agama'),
            'thn_masuk'      => $this->request->getPost('thn_masuk'),
            'status'         => $this->request->getPost('status'),
        ]);

        session()->setFlashdata('success', 'Data Siswa Berhasil Diperbaharui.');

        return redirect()->to('/siswa');
    }

    public function delete($id)
    {
        $this->siswaModel->delete($id);
        session()->setFlashdata('success', 'Data Siswa Berhasil DiHapus.');
        return redirect()->to('/siswa');
    }
}
