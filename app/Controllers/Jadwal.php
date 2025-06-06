<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\GuruModel;
use App\Models\MapelModel;
use App\Models\ThnAjaranModel;

class Jadwal extends BaseController
{
    protected $jadwalModel, $kelasModel, $guruModel, $mapelModel, $tahunModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kelasModel = new KelasModel();
        $this->guruModel = new GuruModel();
        $this->mapelModel = new MapelModel();
        $this->tahunModel = new ThnAjaranModel();
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
            'title' => 'Detail Jadwal',
            'jadwal' => $this->jadwalModel->getJadwal($id),
        ];
        return view('admin/jadwal/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah jadwal',
            'action' => site_url('jadwal/save'),
            'id_kelas' => $this->kelasModel->getKelas(),
            'guru' => $this->guruModel->getGuru(),
            'mapel' => $this->mapelModel->getMapel(),
            'tahun' => $this->tahunModel->getThnAjaran(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jadwal/form', $data);
    }

    public function save()
    {
        $jamMulai = $this->request->getVar('jam_mulai');
        $jamSelesai = $this->request->getVar('jam_selesai');
        $ruangan = $this->request->getVar('ruangan');
        $hari = $this->request->getVar('hari');
        $id_guru = $this->request->getVar('id_guru');
        $id_kelas = $this->request->getVar('id_kelas');
        $jam_ke = $this->request->getVar('jam_ke');


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
                'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat]',
                'errors' => [
                    'required' => 'Hari wajib dipilih.',
                    'in_list' => 'Hari harus salah satu dari Senin sampai Jumat.',
                ]
            ],
            'jam_ke' => [
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[10]',
                'errors' => [
                    'required' => 'Jam ke-berapa wajib diisi.',
                    'is_natural_no_zero' => 'Jam ke harus berupa angka lebih dari 0.',
                    'less_than_equal_to' => 'Jam ke tidak boleh lebih dari 10.',
                ]
            ],
            'jam_mulai' => [
                'rules' => 'required|regex_match[/^[0-2][0-9]:[0-5][0-9]$/]',
                'errors' => [
                    'required' => 'Jam mulai wajib diisi.',
                    'regex_match' => 'Format jam mulai harus hh:mm (contoh: 07:30).',
                ]
            ],
            'jam_selesai' => [
                'rules' => 'required|regex_match[/^[0-2][0-9]:[0-5][0-9]$/]',
                'errors' => [
                    'required' => 'Jam selesai wajib diisi.',
                    'regex_match' => 'Format jam selesai harus hh:mm (contoh: 09:15).',
                ]
            ],
            'ruangan' => [
                'rules' => 'required|alpha_numeric_punct|max_length[20]',
                'errors' => [
                    'required' => 'Ruangan wajib diisi.',
                    'alpha_numeric_punct' => 'Ruangan hanya boleh berisi huruf, angka, titik, koma, atau spasi.',
                    'max_length' => 'Nama ruangan maksimal 20 karakter.',
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
            return redirect()->back()->withInput()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        if ($this->jadwalModel->getRuangan($hari, $ruangan, $jamMulai, $jamSelesai)) {
            return redirect()->back()->with('error', 'Ruangan <strong>' . $ruangan . '</strong> sudah terpakai pada waktu tersebut.');
        }

        if ($this->jadwalModel->getGuru($hari, $id_guru, $jamMulai, $jamSelesai)) {
            return redirect()->back()->with('error', 'Guru sudah mengajar di waktu yang sama.');
        }

        if ($this->jadwalModel->getKelas($hari, $id_kelas, $jamMulai, $jamSelesai)) {
            return redirect()->back()->with('error', 'Kelas sudah ada pelajaran di waktu <strong>' . $jamMulai . '-' . $jamSelesai . '</strong> itu.');
        }

        if ($this->jadwalModel->getJamKeDuplikat($hari, $id_kelas, $jam_ke)) {
            return redirect()->back()->with('error', 'Jam ke <strong>' . $jam_ke . '</strong> yang sama sudah digunakan untuk kelas ini.');
        }

        $this->jadwalModel->insert([
            'id_guru'       => $id_guru,
            'id_mapel'      => $this->request->getVar('id_mapel'),
            'id_kelas'      => $id_kelas,
            'id_thnajaran'  => $this->request->getVar('id_thnajaran'),
            'hari'          => $hari,
            'jam_ke'        => $jam_ke,
            'jam_mulai'     => $jamMulai . ':00',
            'jam_selesai'   => $jamSelesai . ':00',
            'ruangan'       => $ruangan,
            'status'        => $this->request->getVar('status'),
        ]);

        return redirect()->to('/jadwal')->with('success', 'Data jadwal Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to('/jadwal')->with('error', 'Data jadwal tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit jadwal',
            'action' => base_url('jadwal/update/' . $jadwal->id),
            'jadwal' => $jadwal,
            'id_kelas' => $this->kelasModel->getKelas(),
            'guru' => $this->guruModel->getGuru(),
            'mapel' => $this->mapelModel->getMapel(),
            'tahun' => $this->tahunModel->getThnAjaran(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jadwal/form', $data);
    }

    public function update($id)
    {
        $jamMulai = $this->request->getVar('jam_mulai');
        $jamSelesai = $this->request->getVar('jam_selesai');
        $ruangan = $this->request->getVar('ruangan');
        $hari = $this->request->getVar('hari');
        $id_guru = $this->request->getVar('id_guru');
        $id_kelas = $this->request->getVar('id_kelas');
        $jam_ke = $this->request->getVar('jam_ke');


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
                'rules' => 'required|in_list[Senin,Selasa,Rabu,Kamis,Jumat]',
                'errors' => [
                    'required' => 'Hari wajib dipilih.',
                    'in_list' => 'Hari harus salah satu dari Senin sampai Jumat.',
                ]
            ],
            'jam_ke' => [
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[10]',
                'errors' => [
                    'required' => 'Jam ke-berapa wajib diisi.',
                    'is_natural_no_zero' => 'Jam ke harus berupa angka lebih dari 0.',
                    'less_than_equal_to' => 'Jam ke tidak boleh lebih dari 10.',
                ]
            ],
            'jam_mulai' => [
                'rules' => 'required|regex_match[/^(?:[01]\d|2[0-3]):[0-5]\d$/]',
                'errors' => [
                    'required' => 'Jam mulai wajib diisi.',
                    'regex_match' => 'Format jam mulai harus hh:mm (contoh: 07:30).',
                ]
            ],
            'jam_selesai' => [
                'rules' => 'required|regex_match[/^(?:[01]\d|2[0-3]):[0-5]\d$/]',
                'errors' => [
                    'required' => 'Jam selesai wajib diisi.',
                    'regex_match' => 'Format jam selesai harus hh:mm (contoh: 09:15).',
                ]
            ],
            'ruangan' => [
                'rules' => 'required|alpha_numeric_punct|max_length[20]',
                'errors' => [
                    'required' => 'Ruangan wajib diisi.',
                    'alpha_numeric_punct' => 'Ruangan hanya boleh berisi huruf, angka, titik, koma, atau spasi.',
                    'max_length' => 'Nama ruangan maksimal 20 karakter.',
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

        // belum tau mau pake atau tidak
        // $totalMenit = $this->jadwalModel->getBatasGuru($hari, $id_guru, $id);
        // $durasiBaru = (strtotime($jamSelesai) - strtotime($jamMulai)) / 60;
        // if (($totalMenit + $durasiBaru) > 360) {
        //     return redirect()->back()->withInput()->with('error', 'Guru ini sudah melebihi batas maksimal 6 jam mengajar pada hari tersebut.');
        // }

        if (strtotime($jamSelesai) <= strtotime($jamMulai)) {
            return redirect()->back()->withInput()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        if ($this->jadwalModel->getRuangan($hari, $ruangan, $jamMulai, $jamSelesai, $id)) {
            return redirect()->back()->with('error', 'Ruangan <strong>' . $ruangan . '</strong> sudah terpakai pada waktu tersebut.');
        }

        if ($this->jadwalModel->getGuru($hari, $id_guru, $jamMulai, $jamSelesai, $id)) {
            return redirect()->back()->with('error', 'Guru sudah mengajar di waktu yang sama.');
        }

        if ($this->jadwalModel->getKelas($hari, $id_kelas, $jamMulai, $jamSelesai, $id)) {
            return redirect()->back()->with('error', 'Kelas tersebut sudah ada pelajaran di waktu <strong>' . $jamMulai . '-' . $jamSelesai . '</strong>.');
        }

        if ($this->jadwalModel->getJamKeDuplikat($hari, $id_kelas, $jam_ke, $id)) {
            return redirect()->back()->with('error', 'Jam ke <strong>' . $jam_ke . '</strong> yang sama sudah digunakan untuk kelas ini.');
        }

        $this->jadwalModel->update($id, [
            'id_guru'       => $id_guru,
            'id_mapel'      => $this->request->getVar('id_mapel'),
            'id_kelas'      => $id_kelas,
            'id_thnajaran'  => $this->request->getVar('id_thnajaran'),
            'hari'          => $hari,
            'jam_ke'        => $jam_ke,
            'jam_mulai'     => $jamMulai . ':00',
            'jam_selesai'   => $jamSelesai . ':00',
            'ruangan'       => $ruangan,
            'status'        => $this->request->getVar('status'),
        ]);

        return redirect()->to('/jadwal')->with('success', 'Data jadwal Berhasil Diperbaharui.');
    }

    public function delete($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if ($jadwal) {
            $this->jadwalModel->delete($id);
            return redirect()->back()->with('success', 'jadwal berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data jadwal tidak ditemukan.');
    }

    public function hapus()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $jumlah = 0;
            foreach ($ids as $id) {
                $jadwal = $this->jadwalModel->find($id);
                if ($jadwal) {
                    $this->jadwalModel->delete($id);
                    $jumlah++;
                }
            }

            return redirect()->back()->with('success', "<strong>$jumlah</strong> data jadwal berhasil dihapus.");
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');
        $extension = $file->getClientExtension();

        if ($extension == 'xlsx' || $extension == 'xls') {
            $reader = $extension === 'xls' ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);
            $rows = $spreadsheet->getActiveSheet()->toArray();

            $validData = [];
            $errors = [];
            $berhasil = 0;

            foreach ($rows as $key => $value) {
                if ($key == 0) continue;

                $guru = trim($value[1]);
                $mapel = trim($value[2]);
                $kelas = trim($value[3]);
                $thnajaran = trim($value[4]);
                $hari = trim($value[5]);
                $jamke = trim($value[6]);
                $jamMulai = trim($value[7]);
                $jamSelesai = trim($value[8]);
                $ruangan = trim($value[9]);

                $requiredFields = [
                    'id_guru' => $guru,
                    'id_mapel' => $mapel,
                    'id_kelas' => $kelas,
                    'id_thnajaran' => $thnajaran,
                    'hari' => $hari,
                    'jam_ke' => $jamke,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'ruangan' => $ruangan,
                ];

                $emptyFields = [];
                foreach ($requiredFields as $field => $value) {
                    if (empty($value)) {
                        $emptyFields[] = ucfirst(str_replace('_', ' ', $field));
                    }
                }

                if (!empty($emptyFields)) {
                    $errors[] = "Baris ke-" . ($key + 1) . " Tidak boleh kosong untuk " . implode(', ', $emptyFields);
                    continue;
                }

                $guruExist   = $this->guruModel->getIdByNama($guru);
                $mapelExist  = $this->mapelModel->getIdByKode($mapel);

                list($tahun, $semester) = explode(' - ', $thnajaran);
                $ajaranExist = $this->tahunModel->getIdByTahunDanSemester($tahun, $semester);

                if (!$guruExist || !$mapelExist || !$ajaranExist) {
                    $invalids = [];

                    if (!$guruExist) {
                        $invalids[] = 'Guru (ID: ' . $guru . ')';
                    } else {
                        $invalids[] = 'Guru: ' . $guruExist->nama;
                    }

                    if (!$mapelExist) {
                        $invalids[] = 'Mapel (ID: ' . $mapel . ')';
                    } else {
                        $invalids[] = 'Mapel: ' . $mapelExist->kode_mapel;
                    }

                    if (!$ajaranExist) {
                        $invalids[] = 'Tahun Ajaran (ID: ' . $thnajaran . ')';
                    } else {
                        $invalids[] = 'Tahun Ajaran: ' . $ajaranExist->tahun . ' - ' . $ajaranExist->semester;
                    }

                    $errors[] = "Baris ke-" . ($key + 1) . ": Data tidak valid untuk " . implode(', ', $invalids);
                    continue;
                }

                if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $jamMulai) || !preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $jamSelesai)) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Format jam salah. Gunakan format HH:MM atau HH:MM:SS.";
                    continue;
                }

                if (strtotime($jamMulai) >= strtotime($jamSelesai)) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Jam mulai harus lebih kecil dari jam selesai.";
                    continue;
                }

                $parts = explode(' ', $kelas);
                if (count($parts) < 3) {
                    $errors[] = "Format kolom kelas tidak valid di baris ke-$key (harus: Nama Kelas, Kode Jurusan, Rombel)";
                    continue;
                }
                [$nama_kls, $kode_jurusan, $rombel] = $parts;
                $kelasid = $this->kelasModel->getIdByNamaDanJurusanDanRombel($nama_kls, $kode_jurusan, $rombel);
                if (!$kelasid) {
                    $errors[] = "Kelas $nama_kls $kode_jurusan $rombel Tidak terdaftar / Tidak ada.";
                    continue;
                }

                $allowed = [
                    'hari' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat'],
                ];

                foreach ($allowed as $field => $validValues) {
                    if (!in_array(strtolower($$field), $validValues)) {
                        $errors[] = ucfirst($field) . " " . $$field . " tidak valid di baris ke-" . ($key + 1);
                    }
                }

                // Cek bentrok kelas
                $bentrokKelas = $this->jadwalModel->getKelas($hari, $kelas, $jamMulai, $jamSelesai);
                if ($bentrokKelas) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Jadwal kelas bentrok dengan data yang sudah ada.";
                    continue;
                }

                // Cek bentrok ruangan
                $bentrokRuangan = $this->jadwalModel->getRuangan($hari, $ruangan, $jamMulai, $jamSelesai);
                if ($bentrokRuangan) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Ruangan sudah digunakan pada jam tersebut.";
                    continue;
                }

                // Cek bentrok Guru
                $bentrokGuru = $this->jadwalModel->getGuru($hari, $guru, $jamMulai, $jamSelesai);
                if ($bentrokGuru) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Guru sudah Mengajar pada waktu yang sama.";
                    continue;
                }

                // Cek bentrok jam
                $JamKeDuplikat = $this->jadwalModel->getJamKeDuplikat($hari, $kelas, $jamke);
                if ($JamKeDuplikat) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Jam yang sama sudah digunakan untuk kelas ini.";
                    continue;
                }

                if (!preg_match('/^\d{4}\/\d{4} - (Ganjil|Genap)$/i', $thnajaran)) {
                    $errors[] = "Baris ke-" . ($key + 1) . ": Format tahun ajaran harus 'YYYY/YYYY - Ganjil|Genap', contoh: 2025/2026 - Ganjil.";
                    continue;
                }

                $validData[] = [
                    'id_guru' => $guruExist->id,
                    'id_mapel' => $mapelExist->id,
                    'id_kelas' => $kelasid->id,
                    'id_thnajaran' => $ajaranExist->id,
                    'hari' => $hari,
                    'jam_ke' => $jamke,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'ruangan' => $ruangan,
                    'status' => 'Aktif',
                ];
                $berhasil++;
            }

            if (!empty($errors)) {
                return redirect()->back()->with('error', implode('<br>', $errors));
            }

            $this->jadwalModel->insertBatch($validData);

            return redirect()->back()->with('success', "Import berhasil! Sebanyak $berhasil data telah berhasil dimasukkan.");
        }

        return redirect()->back()->with('error', 'Format file tidak sesuai, Harus xls atau xlsx.');
    }
}
