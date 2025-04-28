<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id', 'id_guru', 'id_mapel', 'id_kelas', 'id_thnajaran', 'hari', 'jam_ke', 'jam_mulai', 'jam_selesai', 'ruangan', 'status'];

    public function getJadwal()
    {
        return $this->select('jadwal.*, guru.nama AS guru, mapel.kode_mapel AS mapel, kelas.nama_kls AS kelas, thn_ajaran.semester AS semester, thn_ajaran.tahun AS tahun')
            ->join('guru', 'guru.id = jadwal.id_guru')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran')
            ->findAll();
    }
}
