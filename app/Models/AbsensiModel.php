<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id', 'id_siswa', 'id_jadwal', 'pertemuan_ke', 'tanggal', 'status', 'jam_absen'];

    public function getAbsen()
    {
        return $this->select('absensi.*, siswa.nama AS siswa, jadwal.kode_jurusan AS kd_jurusan, guru.nama AS wakel')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
            ->findAll();
    }

    public function Getabsenkelas()
    {
        return $this->select('absensi.*, siswa.nama AS namaSiswa, kelas.nama_kelas')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('kelas', 'kelas.id = siswa.id_kelas')
            ->findAll();
    }
}
