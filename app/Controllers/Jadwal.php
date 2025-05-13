<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\GuruModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $kelasModel;
    protected $guruModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jadwal',
            'jadwal' => $this->jadwalModel->getJadwal(),
        ];

        return view('admin/jadwal/index', $data);
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail jadwal',
            'jadwal' => $this->jadwalModel->getJadwal($id),
        ];
        return view('admin/jadwal/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah jadwal',
            'action' => site_url('jadwal/save'),
            'kelas_id' => $this->kelasModel->getKelas(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jadwal/form', $data);
    }

    public function save()
    {

        $jamMulai = $this->request->getVar('jam_mulai');
        $jamSelesai = $this->request->getVar('jam_selesai');


        $validation = service('validation');
        $validation->setRules([
            'id_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Guru wajib dipilih.',
                ]
            ],
            'id_mapel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mata pelajaran wajib dipilih.',
                ]
            ],
            'id_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelas wajib dipilih.',
                ]
            ],
            'id_thnajaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun ajaran wajib dipilih.',
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hari wajib diisi.',
                ]
            ],
            'jam_ke' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => [
                    'required' => 'Jam ke-berapa wajib diisi.',
                    'is_natural_no_zero' => 'Jam ke harus berupa angka lebih dari 0.',
                ]
            ],
            'jam_mulai' => [
                'rules' => 'required|valid_time',
                'errors' => [
                    'required' => 'Jam mulai wajib diisi.',
                    'valid_time' => 'Format jam mulai tidak valid (hh:mm).',
                ]
            ],
            'jam_selesai' => [
                'rules' => 'required|valid_time',
                'errors' => [
                    'required' => 'Jam selesai wajib diisi.',
                    'valid_time' => 'Format jam selesai tidak valid (hh:mm).',
                ]
            ],
            'ruangan' => [
                'rules' => 'required|alpha_numeric_punct',
                'errors' => [
                    'required' => 'Ruangan wajib diisi.',
                    'alpha_numeric_punct' => 'Ruangan hanya boleh berisi huruf, angka, titik, koma, atau spasi.',
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[Aktif,Tidak Aktif]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list' => 'Status harus berupa Aktif atau Tidak Aktif.',
                ]
            ],
        ]);

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        if (strtotime($jamSelesai) <= strtotime($jamMulai)) {
            return redirect()->back()->withInput()->with('errors', ['jam_selesai' => 'Jam selesai harus lebih besar dari jam mulai.']);
        }

        $this->jadwalModel->insert([
            'id_guru'       => $this->request->getVar('id_guru'),
            'id_mapel'      => $this->request->getVar('id_mapel'),
            'id_kelas'      => $this->request->getVar('id_kelas'),
            'id_thnajaran'  => $this->request->getVar('id_thnajaran'),
            'hari'          => $this->request->getVar('hari'),
            'jam_ke'        => $this->request->getVar('jam_ke'),
            'jam_mulai'     => $jamMulai . ':00',
            'jam_selesai'   => $jamSelesai . ':00',
            'ruangan'       => $this->request->getVar('ruangan'),
            'status'        => $this->request->getVar('status'),
        ]);

        return redirect()->to('/jadwal')->with('success', 'Data jadwal Berhasil Ditambahkan.');
    }
}
