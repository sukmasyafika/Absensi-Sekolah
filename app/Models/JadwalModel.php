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

    public function getJadwal($id = false)
    {
        $builder = $this->select('jadwal.*, guru.nama AS guru, mapel.kode_mapel AS mapel, kelas.nama_kls AS kelas, thn_ajaran.semester AS semester, thn_ajaran.tahun AS tahun, jurusan.kode_jurusan AS jurusan, kelas.rombel')
            ->join('guru', 'guru.id = jadwal.id_guru')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('thn_ajaran.status', 'Aktif')
            ->orderBy('jadwal.id', 'DESC');

        if ($id === false) {
            return $builder->findAll();
        }

        return $builder->where(['jadwal.id' => $id])->first();
    }

    public function getRuangan($hari, $ruangan, $mulai, $selesai, $id = null)
    {
        $builder = $this->where('hari', $hari)
            ->where('ruangan', $ruangan)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd();

        if ($id !== null) {
            $builder->where('id !=', $id);
        }

        return $builder->first();
    }

    public function getGuru($hari, $id_guru, $mulai, $selesai, $id = null)
    {
        $builder = $this->where('hari', $hari)
            ->where('id_guru', $id_guru)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd();

        if ($id !== null) {
            $builder->where('id !=', $id);
        }

        return $builder->first();
    }

    public function getKelas($hari, $id_kelas, $mulai, $selesai, $id = null)
    {
        $builder = $this->where('hari', $hari)
            ->where('id_kelas', $id_kelas)
            ->groupStart()
            ->where('jam_mulai <=', $mulai)->where('jam_selesai >', $mulai)
            ->orWhere('jam_mulai <', $selesai)->where('jam_selesai >=', $selesai)
            ->orWhere('jam_mulai >=', $mulai)->where('jam_selesai <=', $selesai)
            ->groupEnd();

        if ($id !== null) {
            $builder->where('id !=', $id);
        }

        return $builder->first();
    }

    public function getJamKeDuplikat($hari, $id_kelas, $jam_ke, $id = null)
    {
        $builder = $this->where('hari', $hari)
            ->where('id_kelas', $id_kelas)
            ->where('jam_ke', $jam_ke);

        if ($id !== null) {
            $builder->where('id !=', $id);
        }

        return $builder->first();
    }

    public function getBatasGuru($hari, $id_guru, $id = null)
    {
        $builder = $this->where('id_guru', $id_guru)
            ->where('hari', $hari);

        if ($id !== null) {
            $builder->where('id !=', $id);
        }

        $result = $builder
            ->select('SUM(TIMESTAMPDIFF(MINUTE, jam_mulai, jam_selesai)) as total')
            ->first();

        return (int) ($result['total'] ?? 0);
    }

    public function getMapelHariIni($guruId)
    {
        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat'
        ];

        $hariInggris = date('l');

        if (!isset($hariMap[$hariInggris])) {
            return [];
        }

        $hariIni = $hariMap[$hariInggris];

        return $this->select('mapel.id, mapel.kode_mapel, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->where('jadwal.hari', $hariIni)
            ->where('jadwal.id_guru', $guruId)
            ->where('jadwal.status', 'Aktif')
            ->groupBy('mapel.id, mapel.kode_mapel, mapel.nama_mapel')
            ->findAll();
    }

    public function getKelasHariIni($guruId)
    {
        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat'
        ];

        $hariInggris = date('l');

        if (!isset($hariMap[$hariInggris])) {
            return [];
        }

        $hariIni = $hariMap[$hariInggris];

        return $this->select('kelas.id, kelas.nama_kls, jurusan.kode_jurusan AS kd_jurusan, kelas.rombel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('jadwal.hari', $hariIni)
            ->where('jadwal.id_guru', $guruId)
            ->where('jadwal.status', 'Aktif')
            ->groupBy('kelas.id, kelas.nama_kls, jurusan.kode_jurusan, kelas.rombel')
            ->findAll();
    }

    public function getJadwalToday($guruId)
    {

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat'
        ];

        $hariInggris = date('l');

        if (!isset($hariMap[$hariInggris])) {
            return [];
        }

        $hariIni = $hariMap[$hariInggris];

        return $this->select('jadwal.*, mapel.kode_mapel AS mapel, kelas.nama_kls AS kelas, jurusan.kode_jurusan AS jurusan, kelas.rombel')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('jadwal.hari', $hariIni)
            ->where('jadwal.id_guru', $guruId)
            ->where('jadwal.status', 'Aktif')
            ->orderBy('jadwal.jam_mulai', 'ASC')
            ->findAll();
    }

    public function getCekJadwal($id_mapel, $id_kelas, $guruId = null, $semester = null)
    {
        $builder = $this->where('id_mapel', $id_mapel)
            ->where('id_kelas', $id_kelas);

        if ($guruId !== null) {
            $builder = $builder->where('id_guru', $guruId);
        }

        if ($semester !== null) {
            $builder = $builder->where('semester', $semester);
        }

        return $builder->first();
    }

    public function getHariJadwal($id_mapel, $id_kelas, $guruId = null)
    {

        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat'
        ];

        $hariInggris = date('l');

        if (!isset($hariMap[$hariInggris])) {
            return [];
        }

        $hariIni = $hariMap[$hariInggris];

        $builder = $this->where('id_mapel', $id_mapel)
            ->where('id_kelas', $id_kelas)
            ->where('hari', $hariIni);

        if ($guruId !== null) {
            $builder->where('id_guru', $guruId);
        }

        return $builder->first();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function getJadwalDashboard($guruId)
    {
        $hariMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat'
        ];

        $hariInggris = date('l');

        if (!isset($hariMap[$hariInggris])) {
            return [];
        }

        $hariIni = $hariMap[$hariInggris];

        return $this->select('jadwal.*, mapel.id AS id_jadwal, mapel.nama_mapel, kelas.nama_kls, jurusan.kode_jurusan AS jurusan, kelas.rombel, jadwal.jam_mulai, jadwal.jam_selesai, jadwal.ruangan')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('jadwal.hari', $hariIni)
            ->where('jadwal.id_guru', $guruId)
            ->where('jadwal.status', 'Aktif')
            ->findAll();
    }

    public function getMapelRekap($guruId)
    {
        return $this->select('mapel.id, mapel.kode_mapel, mapel.nama_mapel')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->where('jadwal.id_guru', $guruId)
            ->groupBy('mapel.id, mapel.kode_mapel, mapel.nama_mapel')
            ->findAll();
    }

    public function getKelasRekap($guruId)
    {
        return $this->select('kelas.id, kelas.nama_kls, jurusan.kode_jurusan AS kd_jurusan, kelas.rombel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->where('jadwal.id_guru', $guruId)
            ->groupBy('kelas.id, kelas.nama_kls, jurusan.kode_jurusan, kelas.rombel')
            ->findAll();
    }

    public function getTahunAjaranByJadwal($id_jadwal)
    {
        return $this->select('thn_ajaran.tahun, thn_ajaran.semester')
            ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran')
            ->where('jadwal.id', $id_jadwal)
            ->get()
            ->getRow();
    }
}
