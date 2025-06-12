<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['slug', 'nama', 'nisn', 'kelas_id', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'thn_masuk', 'status'];


    public function getSiswa($slug = false)
    {
        $builder = $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name, kelas.rombel')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->orderBy('siswa.id', 'DESC');


        if ($slug === false) {
            return $builder->findAll();
        }

        return $builder->where(['slug' => $slug])->first();
    }

    public function getSiswaWithKelas($filter_kelas = null)
    {
        $builder = $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name, kelas.rombel')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->orderBy('siswa.id', 'DESC');

        if (!empty($filter_kelas)) {
            $builder->where('kelas.id', $filter_kelas);
        }

        return $builder->findAll();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function getFilteredData($filter = [])
    {
        $builder = $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name, kelas.rombel')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->orderBy('siswa.id', 'DESC');

        if (!empty($filter['kelas_rombel'])) {
            $builder->where('kelas.rombel', $filter['kelas_rombel']);
        }

        if (!empty($filter['jurusan'])) {
            $builder->where('jurusan.kode_jurusan', $filter['jurusan']);
        }

        return $builder->get()->getResultArray();
    }
}
