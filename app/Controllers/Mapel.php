<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ThnAjaranModel;
use App\Models\MapelModel;
use App\Models\JurusanModel;

class Mapel extends BaseController
{
    protected $mapelModel, $thnAjaranModel, $jurusanModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->thnAjaranModel = new ThnAjaranModel();
        $this->jurusanModel = new JurusanModel();
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
            'jurusan' => $this->jurusanModel->getListJurusan(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/mapel/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_mapel' => [
                'rules' => 'required|alpha_numeric_punct|is_unique[mapel.kode_mapel]',
                'errors' => [
                    'required' => 'Kode mapel wajib diisi.',
                    'alpha_numeric_punct' => 'Kode mapel hanya boleh berisi huruf, angka, titik, koma, atau strip.',
                    'is_unique' => 'Kode Mapel sudah terdaftar.',
                ]
            ],
            'nama_mapel' => [
                'rules' => 'required|string|min_length[3]|is_unique[mapel.nama_mapel]',
                'errors' => [
                    'required' => 'Nama Mapel wajib diisi.',
                    'string' => 'Nama Mapel hanya boleh berisi karakter teks.',
                    'min_length' => 'Nama Mapel minimal 3 karakter.',
                    'is_unique' => 'Nama Mapel sudah terdaftar.',
                ]
            ],
            'id_jurusan' => [
                'rules' => 'permit_empty|is_not_unique[jurusan.id]',
                'errors' => [
                    'is_not_unique' => 'Jurusan yang dipilih tidak valid.'
                ]
            ],
            'id_thnAjaran' => [
                'rules' => 'required|is_not_unique[thn_ajaran.id]',
                'errors' => [
                    'required' => 'Tahun Ajaran wajib dipilih.',
                    'is_not_unique' => 'Tahun Ajaran yang dipilih tidak valid.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $idJurusan = $this->request->getPost('id_jurusan') ?: null;

        $this->mapelModel->insert([
            'kode_mapel'       => $this->request->getVar('kode_mapel'),
            'nama_mapel'       => $this->request->getVar('nama_mapel'),
            'id_thnAjaran'     => $this->request->getVar('id_thnAjaran'),
            'id_jurusan'       => $idJurusan,
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
            'jurusan' => $this->jurusanModel->getListJurusan(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/mapel/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'kode_mapel' => [
                'rules' => 'required|alpha_numeric_punct|is_unique[mapel.kode_mapel,id,' . $id . ']',
                'errors' => [
                    'required' => 'Kode mapel wajib diisi.',
                    'alpha_numeric_punct' => 'Kode mapel hanya boleh berisi huruf, angka, titik, koma, atau strip.',
                    'is_unique' => 'Kode Mapel sudah terdaftar.',
                ]
            ],
            'nama_mapel' => [
                'rules' => 'required|string|min_length[3]|is_unique[mapel.nama_mapel,id,' . $id . ']',
                'errors' => [
                    'required' => 'Nama Mapel wajib diisi.',
                    'string' => 'Nama Mapel hanya boleh berisi karakter teks.',
                    'min_length' => 'Nama Mapel minimal 3 karakter.',
                    'is_unique' => 'Nama Mapel sudah terdaftar.',
                ]
            ],
            'id_jurusan' => [
                'rules' => 'permit_empty|is_not_unique[jurusan.id]',
                'errors' => [
                    'is_not_unique' => 'Jurusan yang dipilih tidak valid.'
                ]
            ],
            'id_thnAjaran' => [
                'rules' => 'required|is_not_unique[thn_ajaran.id]',
                'errors' => [
                    'required' => 'Tahun Ajaran wajib dipilih.',
                    'is_not_unique' => 'Tahun Ajaran yang dipilih tidak valid.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $idJurusan = $this->request->getPost('id_jurusan') ?: null;

        $this->mapelModel->update($id, [
            'kode_mapel'         => $this->request->getVar('kode_mapel'),
            'nama_mapel'         => $this->request->getVar('nama_mapel'),
            'id_thnAjaran'       => $this->request->getVar('id_thnAjaran'),
            'id_jurusan'         => $idJurusan,
        ]);

        return redirect()->to('/mapel')->with('success', 'Data Mata Pelajaran Berhasil Perbaharui.');
    }

    public function delete($id)
    {
        $mapel = $this->mapelModel->find($id);

        if ($mapel) {
            $this->mapelModel->delete($id);
            return redirect()->back()->with('success', 'mapel <strong>' . $mapel->nama_mapel . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data mapel tidak ditemukan.');
    }
}
