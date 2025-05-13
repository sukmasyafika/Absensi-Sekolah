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
                'rules' => 'required|regex_match[/^[A-Za-z.,\s]+$/]|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                    'regex_match' => 'Nama hanya boleh berisi huruf.',
                    'min_length' => 'Nama minimal terdiri dari 3 karakter.',
                    'max_length' => 'Nama maksimal terdiri dari 100 karakter.'
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
                'rules' => 'required|regex_match[/^[A-Za-z.,\s]+$/]|min_length[3]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'regex_match' => 'Jabatan hanya boleh berisi huruf.',
                    'min_length' => 'Jabatan minimal terdiri dari 3 karakter.'
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

        $nama = trim($this->request->getVar('nama'));
        $kata = explode(' ', $nama);
        $duaKata = implode(' ', array_slice($kata, 0, 2));
        $slugDasar = url_title($duaKata, '-', true);
        $slug = $slugDasar;
        $i = 1;
        while ($this->guruModel->where('slug', $slug)->first()) {
            $slug = $slugDasar . '-' . $i;
            $i++;
        }

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

        return redirect()->to('/guru')->with('success', 'Data guru Berhasil Ditambahkan.');
    }

    public function edit($slug)
    {
        $guru = $this->guruModel->getGuru($slug);

        if (!$guru) {
            return redirect()->to('/guru')->with('error', 'Data guru tidak ditemukan.');
        }

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
                'rules' => 'required|regex_match[/^[A-Za-z.,\s]+$/]|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                    'regex_match' => 'Nama hanya boleh berisi huruf.',
                    'min_length' => 'Nama minimal terdiri dari 3 karakter.',
                    'max_length' => 'Nama maksimal terdiri dari 100 karakter.'
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

        $nama = trim($this->request->getVar('nama'));
        $kata = explode(' ', $nama);
        $duaKata = implode(' ', array_slice($kata, 0, 2));
        $slugDasar = url_title($duaKata, '-', true);
        $slug = $slugDasar;
        $i = 1;
        while ($this->guruModel->where('slug', $slug)->first()) {
            $slug = $slugDasar . '-' . $i;
            $i++;
        }

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

        return redirect()->to('/guru')->with('success', 'Guru <strong>' . $guruLama->nama . '</strong> berhasil diperbaharui.');
    }

    public function delete($id)
    {
        $guru = $this->guruModel->find($id);

        if ($guru) {
            if (!empty($guru->foto) && file_exists('assets/img/guru/' . $guru->foto)) {
                unlink('assets/img/guru/' . $guru->foto);
            }

            $this->guruModel->delete($id);
            return redirect()->back()->with('success', 'Guru <strong>' . esc($guru->nama) . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
    }

    public function hapus()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $jumlah = 0;
            foreach ($ids as $id) {
                $guru = $this->guruModel->find($id);
                if ($guru) {
                    $this->guruModel->delete($id);
                    $jumlah++;
                }
            }

            return redirect()->back()->with('success', "<strong>$jumlah</strong> data Guru berhasil dihapus.");
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

                $nama = trim($value[1]);
                $nip = trim($value[2]);
                $jabatan = trim($value[3]);
                $tanggal_lahir = trim($value[4]);
                $jenis_kelamin = trim($value[5]);
                $agama = trim($value[6]);
                $thn_masuk = trim($value[7]);
                $status = trim($value[8]);

                $requiredFields = [
                    'nama' => $nama,
                    'nip' => $nip,
                    'jabatan' => $jabatan,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'agama' => $agama,
                    'thn_masuk' => $thn_masuk,
                    'status' => $status,
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

                $customValidations = [
                    'nip' => [
                        'regex' => '/^\d{18}$/',
                        'error' => "NIP di baris " . ($key + 1) . " harus 18 digit angka.",
                    ],
                    'thn_masuk' => [
                        'regex' => '/^\d{4}$/',
                        'error' => "Tahun Masuk di baris " . ($key + 1) . " harus 4 digit angka.",
                    ],
                ];

                foreach ($customValidations as $field => $rule) {
                    if (!preg_match($rule['regex'], $$field)) {
                        $errors[] = $rule['error'];
                        continue 2;
                    }
                }

                if ($this->guruModel->where('nip', $nip)->first()) {
                    $errors[] = "NIP Sudah Terdaftar di baris ke-" . ($key + 1) . ".";
                    continue;
                }

                $allowed = [
                    'jenis_kelamin' => ['laki-laki', 'perempuan'],
                    'agama' => ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'],
                    'status' => ['aktif', 'tidak aktif'],
                ];

                foreach ($allowed as $field => $validValues) {
                    if (!in_array(strtolower($$field), $validValues)) {
                        $errors[] = ucfirst($field) . " " . $$field . " tidak valid di baris ke-" . ($key + 1);
                    }
                }

                if (is_numeric($tanggal_lahir)) {
                    try {
                        $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $errors[] = "Tanggal lahir tidak valid (format Excel) di baris ke-" . ($key + 1);
                        continue;
                    }
                } else {
                    $timestamp = strtotime($tanggal_lahir);
                    if ($timestamp === false) {
                        $errors[] = "Format tanggal lahir tidak dikenali di baris ke-" . ($key + 1);
                        continue;
                    }

                    $tanggal_lahir = date('Y-m-d', $timestamp);
                }


                $kata = explode(' ', $nama);
                $duaKata = implode(' ', array_slice($kata, 0, 2));
                $slugDasar = url_title($duaKata, '-', true);
                $slug = $slugDasar;
                $i = 1;
                while ($this->guruModel->where('slug', $slug)->first()) {
                    $slug = $slugDasar . '-' . $i++;
                }

                $validData[] = [
                    'nama' => $nama,
                    'slug' => $slug,
                    'nip' => $nip,
                    'jabatan' => $jabatan,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'agama' => $agama,
                    'thn_masuk' => $thn_masuk,
                    'status' => $status,
                    'foto' => 'default.png',
                ];
                $berhasil++;
            }

            if (!empty($errors)) {
                return redirect()->back()->with('error', implode('<br>', $errors));
            }

            $this->guruModel->insertBatch($validData);

            return redirect()->back()->with('success', "Import berhasil, $berhasil data berhasil diimpor.");
        }

        return redirect()->back()->with('error', 'Format file tidak sesuai, Harus xls atau xlsx.');
    }
}
