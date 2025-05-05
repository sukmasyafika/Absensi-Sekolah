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

    // public function getSiswa($slug = false)
    // {
    //     if ($slug === false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['slug' => $slug])->first();
    // }

    public function getSiswa($slug = false)
    {
        $builder = $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name, kelas.rombel')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id');

        if ($slug === false) {
            return $builder->findAll();
        }

        return $builder->where('siswa.slug', $slug)->first();
    }


    public function getSiswaWithKelas()
    {
        return $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name, kelas.rombel')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->findAll();
    }
}
