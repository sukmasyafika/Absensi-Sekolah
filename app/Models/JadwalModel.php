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
        return $this->select('jadwal.*, guru.nama AS guru, mapel.kode_mapel AS mapel, kelas.nama_kls AS kelas, thn_ajaran.semester AS semester, thn_ajaran.tahun AS tahun, jurusan.kode_jurusan AS jurusan, kelas.rombel')
            ->join('guru', 'guru.id = jadwal.id_guru')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->findAll();
    }

    public function getRuangan($hari, $ruangan, $mulai, $selesai, $id = null)
    {
        return $this->where('hari', $hari)
            ->where('ruangan', $ruangan)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd()
            ->where('id !=', $id)
            ->first();
    }

    public function getGuru($hari, $id_guru, $mulai, $selesai, $id = null)
    {
        return $this->where('hari', $hari)
            ->where('id_guru', $id_guru)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd()
            ->where('id !=', $id)
            ->first();
    }

    public function getKelas($hari, $id_kelas, $mulai, $selesai, $id = null)
    {
        return $this->where('hari', $hari)
            ->where('id_kelas', $id_kelas)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd()
            ->where('id !=', $id)
            ->first();
    }

    public function getJamKeDuplikat($hari, $id_kelas, $jam_ke, $id = null)
    {
        return $this->where('hari', $hari)
            ->where('id_kelas', $id_kelas)
            ->where('jam_ke', $jam_ke)
            ->where('id !=', $id)
            ->first();
    }
}
