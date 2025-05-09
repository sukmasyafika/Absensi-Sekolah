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
    protected $allowedFields    = ['nama_kls', 'rombel', 'jurusan_id', 'wali_kelas_id'];

    public function getKelas()
    {
        return $this->select('kelas.*, jurusan.nama_jurusan AS jurusan, jurusan.kode_jurusan AS kd_jurusan, guru.nama AS wakel')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id', 'left')
            ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
            ->findAll();
    }

    public function getIdByNamaDanJurusanDanRombel($nama_kls, $kode_jurusan, $rombel)
    {
        return $this->select('kelas.id')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('kelas.nama_kls', $nama_kls)
            ->where('jurusan.kode_jurusan', $kode_jurusan)
            ->where('kelas.rombel', $rombel)
            ->first();
    }
}
