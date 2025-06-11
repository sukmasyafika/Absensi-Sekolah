<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KalenderModel;

class Kalender extends BaseController
{
    protected $kalenderModel;

    public function __construct()
    {
        $this->kalenderModel = new KalenderModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kalender Akademik',
            'kalender' => $this->kalenderModel->findAll()
        ];

        return view('admin/akademik/kalender/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kalender',
            'action' => site_url('kalender/save'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/kalender/form', $data);
    }

    public function save()
    {
        $validation = service('validation');
        $validation->setRules([
            'tanggal' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal wajib diisi.',
                    'valid_date' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
                ]
            ],
            'nama_libur' => [
                'rules' => 'required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z0-9\s\-\.\/\(\)]+$/]|is_unique[hari_libur.nama_libur]',
                'errors' => [
                    'required' => 'Nama libur wajib diisi.',
                    'min_length' => 'Nama libur minimal 3 karakter.',
                    'max_length' => 'Nama libur maksimal 100 karakter.',
                    'regex_match' => 'Nama libur hanya boleh huruf, angka, spasi, tanda hubung, titik, garis miring, dan kurung.',
                    'is_unique' => 'Nama libur sudah terdaftar.'
                ]
            ],
            'keterangan' => [
                'rules' => 'permit_empty|max_length[255]|regex_match[/^[a-zA-Z0-9\s\-\.\,\!\?\(\)\/\:]+$/]',
                'errors' => [
                    'max_length' => 'Keterangan maksimal 255 karakter.',
                    'regex_match' => 'Keterangan mengandung karakter yang tidak diperbolehkan.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = $this->request->getVar();

        $tanggal = $data['tanggal'];
        $inputDate = strtotime($tanggal);
        $today = strtotime(date('Y-m-d'));
        $maxDate = strtotime('+1 year', $today);

        if ($inputDate < $today || $inputDate > $maxDate) {
            return redirect()->back()->withInput()->with('errors', [
                'tanggal' => 'Tanggal hanya boleh mulai dari hari ini sampai 1 tahun ke depan.'
            ]);
        }

        $this->kalenderModel->insert([
            'tanggal'    => $tanggal,
            'nama_libur' => $data['nama_libur'],
            'keterangan' => $data['keterangan'],
        ]);

        return redirect()->to('/kalender')->with('success', 'Data kalender Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $kalender = $this->kalenderModel->find($id);

        if (!$kalender) {
            return redirect()->to('/kalender')->with('error', 'Data kalender tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit kalender',
            'kalender' => $kalender,
            'action' => base_url('kalender/update/' . $kalender->id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/akademik/kalender/form', $data);
    }

    public function update($id)
    {
        $validation = service('validation');
        $validation->setRules([
            'tanggal' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal wajib diisi.',
                    'valid_date' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
                ]
            ],
            'nama_libur' => [
                'rules' => 'required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z0-9\s\-\.\/\(\)]+$/]|is_unique[hari_libur.nama_libur,' . $id . ']',
                'errors' => [
                    'required' => 'Nama libur wajib diisi.',
                    'min_length' => 'Nama libur minimal 3 karakter.',
                    'max_length' => 'Nama libur maksimal 100 karakter.',
                    'regex_match' => 'Nama libur hanya boleh huruf, angka, spasi, tanda hubung, titik, garis miring, dan kurung.',
                    'is_unique' => 'Nama libur sudah terdaftar.'
                ]
            ],
            'keterangan' => [
                'rules' => 'permit_empty|max_length[255]|regex_match[/^[a-zA-Z0-9\s\-\.\,\!\?\(\)\/\:]+$/]',
                'errors' => [
                    'max_length' => 'Keterangan maksimal 255 karakter.',
                    'regex_match' => 'Keterangan mengandung karakter yang tidak diperbolehkan.'
                ]
            ]
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = $this->request->getVar();

        $tanggal = $data['tanggal'];
        $inputDate = strtotime($tanggal);
        $today = strtotime(date('Y-m-d'));
        $maxDate = strtotime('+1 year', $today);

        if ($inputDate < $today || $inputDate > $maxDate) {
            return redirect()->back()->withInput()->with('errors', [
                'tanggal' => 'Tanggal hanya boleh mulai dari hari ini sampai 1 tahun ke depan.'
            ]);
        }

        $this->kalenderModel->update($id, [
            'tanggal'    => $tanggal,
            'nama_libur' => $data['nama_libur'],
            'keterangan' => $data['keterangan'],
        ]);

        return redirect()->to('/kalender')->with('success', 'Data kalender Berhasil Diperbaharui.');
    }

    public function delete($id)
    {
        $kalender = $this->kalenderModel->find($id);

        if ($kalender) {
            $this->kalenderModel->delete($id);
            return redirect()->back()->with('success', 'kalender <strong> Hari Libur ' . $kalender->nama_libur . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data kalender Hari Libur tidak ditemukan.');
    }

    public function getLibur()
    {
        $data = $this->kalenderModel->findAll();
        $events = [];

        foreach ($data as $row) {
            $events[] = [
                'title' => $row->nama_libur,
                'start' => $row->tanggal,
                'description' => $row->keterangan
            ];
        }

        return $this->response->setJSON($events);
    }
}
