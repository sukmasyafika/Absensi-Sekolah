<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['nama_kls', 'jurusan_id', 'wali_kelas_id'];

    public function getKelas()
    {
        return $this->select('kelas.*, jurusan.nama_jurusan AS jurusan, jurusan.kode_jurusan AS kd_jurusan, guru.nama AS wakel')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->findAll();
    }
}
