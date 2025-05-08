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

        $filter_kelas = $this->request->getGet('filter_kelas');

        $data = [
            'title' => 'Siswa',
            'siswa' => $this->siswaModel->getSiswaWithKelas($filter_kelas),
            'kelas_id' => $this->kelasModel->getKelas(),
            'filter_kelas'   => $filter_kelas
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

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $nama = trim($this->request->getVar('nama'));
        $kata = explode(' ', $nama);
        $duaKata = implode(' ', array_slice($kata, 0, 2));
        $slugDasar = url_title($duaKata, '-', true);
        $slug = $slugDasar;
        $i = 1;
        while ($this->siswaModel->where('slug', $slug)->first()) {
            $slug = $slugDasar . '-' . $i;
            $i++;
        }

        $this->siswaModel->insert([
            'nama'           => $this->request->getVar('nama'),
            'slug'           => $slug,
            'nisn'           => $this->request->getVar('nisn'),
            'kelas_id'       => $this->request->getVar('kelas_id'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getVar('jenis_kelamin'),
            'agama'          => $this->request->getVar('agama'),
            'thn_masuk'      => $this->request->getVar('thn_masuk'),
            'status'         => $this->request->getVar('status'),
        ]);

        return redirect()->to('/siswa')->with('success', 'Data Siswa Berhasil Ditambahkan.');
    }

    public function edit($slug)
    {
        $siswa = $this->siswaModel->getSiswa($slug);

        if (!$siswa) {
            return redirect()->to('/siswa')->with('error', 'Data siswa tidak ditemukan.');
        }

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

        if (!$validation->run($this->request->getVar())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $nama = trim($this->request->getVar('nama'));
        $kata = explode(' ', $nama);
        $duaKata = implode(' ', array_slice($kata, 0, 2));
        $slugDasar = url_title($duaKata, '-', true);
        $slug = $slugDasar;
        $i = 1;
        while ($this->siswaModel->where('slug', $slug)->first()) {
            $slug = $slugDasar . '-' . $i;
            $i++;
        }

        $this->siswaModel->update($id, [
            'nama'           => $this->request->getVar('nama'),
            'slug'           => $slug,
            'nisn'           => $this->request->getVar('nisn'),
            'kelas_id'       => $this->request->getVar('kelas_id'),
            'tanggal_lahir'  => $this->request->getVar('tanggal_lahir'),
            'jenis_kelamin'  => $this->request->getVar('jenis_kelamin'),
            'agama'          => $this->request->getVar('agama'),
            'thn_masuk'      => $this->request->getVar('thn_masuk'),
            'status'         => $this->request->getVar('status'),
        ]);

        return redirect()->to('/siswa')->with('success', 'Siswa <strong>' . $siswaLama->nama . '</strong> berhasil diperbaharui.');
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);

        if ($siswa) {
            $this->siswaModel->delete($id);
            return redirect()->back()->with('success', 'Siswa <strong>' . $siswa->nama . '</strong> berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }

    public function hapus()
    {
        $ids = $this->request->getPost('ids');

        if ($ids) {
            $jumlah = 0;
            foreach ($ids as $id) {
                $siswa = $this->siswaModel->find($id);
                if ($siswa) {
                    $this->siswaModel->delete($id);
                    $jumlah++;
                }
            }

            return redirect()->back()->with('success', "<strong>$jumlah</strong> data siswa berhasil dihapus.");
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

            $errors = [];
            $berhasil = 0;
            foreach ($rows as $key => $value) {
                if ($key == 0) continue;

                $nama = trim($value[1]);
                $nisn = trim($value[2]);
                $kelas_id = trim($value[3]);
                $tanggal_lahir = trim($value[4]);
                $jenis_kelamin = trim($value[5]);
                $agama = trim($value[6]);
                $thn_masuk = trim($value[7]);
                $status = trim($value[8]);
                $parts = explode(' ', $kelas_id);

                if (count($parts) < 3) {
                    $errors[] = "Format kolom kelas tidak valid di baris ke-$key (harus: Nama Kelas, Kode Jurusan, Rombel)";
                }

                $nama_kls = $parts[0];
                $kode_jurusan = $parts[1];
                $rombel = $parts[2];
                $kelas = $this->kelasModel->getIdByNamaDanJurusanDanRombel($nama_kls, $kode_jurusan, $rombel);
                if (!$kelas) {
                    $errors[] = "Kelas $kelas_id Tidak terdaftar / Tidak ada.";
                }

                $agama1 = $this->siswaModel->getAgama($agama);
                if (!$agama1) {
                    $errors[] = "Agama $agama Tidak terdaftar / Tidak ada.";
                }

                if (!$nama || !$nisn || !$kelas_id || !$tanggal_lahir || !$jenis_kelamin) {
                    $errors[] = "Baris ke-" . ($key + 1) . " tidak lengkap.";
                    continue;
                }

                if (!preg_match('/^\d{10}$/', $nisn)) {
                    $errors[] = "NISN di baris " . ($key + 1) . " harus 10 digit angka.";
                    continue;
                }

                if (!preg_match('/^\d{4}$/', $thn_masuk)) {
                    $errors[] = "Tahun Masuk di baris " . ($key + 1) . " harus 4 digit angka.";
                    continue;
                }

                if ($this->siswaModel->where('nisn', $nisn)->first()) {
                    $errors[] = "NISN Sudah Terdaftar di baris " . ($key + 1) . ".";
                    continue;
                }

                if (!in_array(strtolower($jenis_kelamin), ['laki-laki', 'perempuan'])) {
                    $errors[] = "Jenis kelamin tidak valid di baris " . ($key + 1);
                    continue;
                }

                if (is_numeric($tanggal_lahir)) {
                    $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
                } else {
                    $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir));
                }

                $kata = explode(' ', $nama);
                $duaKata = implode(' ', array_slice($kata, 0, 2));
                $slugDasar = url_title($duaKata, '-', true);
                $slug = $slugDasar;
                $i = 1;
                while ($this->siswaModel->where('slug', $slug)->first()) {
                    $slug = $slugDasar . '-' . $i++;
                }

                $this->siswaModel->insert([
                    'nama' => $nama,
                    'slug' => $slug,
                    'nisn' => $nisn,
                    'kelas_id' => $kelas->id,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jenis_kelamin,
                    'agama' => $agama,
                    'thn_masuk' => $thn_masuk,
                    'status' => $status,
                ]);
                $berhasil++;
            }

            if (!empty($errors)) {
                return redirect()->back()->with('error', implode('<br>', $errors));
            }

            return redirect()->back()->with('success', "Import selesai. $berhasil data berhasil, " . count($errors) . " gagal.");
        }

        return redirect()->back()->with('error', 'Format file tidak sesuai. Harus xls atau xlsx.');
    }
}
