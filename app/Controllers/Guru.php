<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GuruModel;

class Guru extends BaseController
{
    protected $guruModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Guru',
            'guru' => $this->guruModel->findAll(),
        ];

        return view('admin/guru/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Guru',
            'guru' => $this->guruModel->getGuru($slug),
        ];

        return view('admin/guru/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Guru',
            'action' => site_url('guru/save'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/guru/form', $data);
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
            'nip' => [
                'rules' => 'required|is_unique[guru.nip]|numeric|exact_length[18]',
                'errors' => [
                    'required'      => 'NIP wajib diisi.',
                    'is_unique'     => 'NIP sudah terdaftar, gunakan NIP lain.',
                    'numeric'       => 'NIP hanya boleh berisi angka.',
                    'exact_length'  => 'NIP harus terdiri dari 18 digit angka.'
                ]
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.'
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
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto wajib diunggah.',
                    'max_size' => 'Ukuran foto maksimal 1MB.',
                    'is_image' => 'File yang diunggah bukan gambar.',
                    'mime_in'  => 'Format foto Harus JPG, JPEG, atau PNG.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif, Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status tidak valid.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $img = $this->request->getFile('foto');
        $img->move('assets/img/guru');
        $namaImg = $img->getName();

        $slug = url_title($this->request->getVar('nama'), '-', true);

        $this->guruModel->insert([
            'nama'           => $this->request->getVar('nama'),
            'slug'           => $slug,
            'nip'            => $this->request->getVar('nip'),
            'jabatan'        => $this->request->getVar('jabatan'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getVar('jenis_kelamin'),
            'agama'          => $this->request->getVar('agama'),
            'thn_masuk'      => $this->request->getVar('thn_masuk'),
            'foto'           => $namaImg,
            'status'         => $this->request->getVar('status'),
        ]);

        session()->setFlashdata('success', 'Data guru Berhasil Ditambahkan.');

        return redirect()->to('/guru');
    }

    public function edit($slug)
    {
        $guru = $this->guruModel->getGuru($slug);

        $data = [
            'title' => 'Edit guru',
            'action' => base_url('guru/update/' . $guru->id),
            'guru' => $guru,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/guru/form', $data);
    }

    public function update($id)
    {
        $guruLama = $this->guruModel->getguru($this->request->getVar('slug'));

        if ($guruLama && $guruLama->nama === $this->request->getVar('nama')) {
            $nama = 'required';
        } else {
            $nama = 'required|is_unique[guru.nama]';
        }

        $validation = service('validation');
        $validation->setRules([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ]
            ],
            'nip' => [
                'rules' => 'required|is_unique[guru.nip,id,' . $id . ']|numeric|exact_length[18]',
                'errors' => [
                    'required'      => 'NIP wajib diisi.',
                    'is_unique'     => 'NIP sudah terdaftar, gunakan NIP lain.',
                    'numeric'       => 'NIP hanya boleh berisi angka.',
                    'exact_length'  => 'NIP harus terdiri dari 18 digit angka.'
                ]
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.'
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
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 1MB.',
                    'is_image' => 'File yang diunggah bukan gambar.',
                    'mime_in'  => 'Format foto Harus JPG, JPEG, atau PNG.'
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

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $img = $this->request->getFile('foto');
        if ($img->getError() == 4) {
            $namaImg = $this->request->getVar('fotoLama');
        } else {
            $img->move('assets/img/guru');
            $namaImg = $img->getName();
            $fotoLama = $this->request->getVar('fotoLama');
            if ($fotoLama) {
                $path = 'assets/img/guru/' . $fotoLama;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $slug = url_title($this->request->getVar('nama'), '-', true);
        $this->guruModel->update($id, [
            'nama'           => $this->request->getVar('nama'),
            'slug'           => $slug,
            'nip'            => $this->request->getVar('nip'),
            'jabatan'        => $this->request->getVar('jabatan'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getVar('jenis_kelamin'),
            'agama'          => $this->request->getVar('agama'),
            'thn_masuk'      => $this->request->getVar('thn_masuk'),
            'foto'           => $namaImg,
            'status'         => $this->request->getVar('status'),
        ]);

        session()->setFlashdata('success', 'Data guru Berhasil Diperbaharui.');

        return redirect()->to('/guru');
    }

    public function delete($id)
    {
        $guruFoto = $this->guruModel->find($id);
        unlink('assets/img/guru/' . $guruFoto->foto);

        $this->guruModel->delete($id);
        session()->setFlashdata('success', 'Data guru Berhasil DiHapus.');
        return redirect()->to('/guru');
    }
}
