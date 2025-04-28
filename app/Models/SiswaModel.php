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

    public function getSiswaWithKelas()
    {
        return $this->select('siswa.*, kelas.nama_kls AS kelas_name, jurusan.kode_jurusan AS jurusan_name')
            ->join('kelas', 'kelas.id = siswa.kelas_id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->findAll();
    }
}
