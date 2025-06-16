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
    protected $allowedFields    = ['id', 'id_siswa', 'id_jadwal', 'pertemuan_ke', 'tanggal', 'status'];

    public function getAbsen()
    {
        return $this->select('absensi.*, siswa.nama AS siswa, jadwal.kode_jurusan AS kd_jurusan, guru.nama AS wakel')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
            ->findAll();
    }

    public function Getabsenkelas($id_kelas, $id_mapel)
    {
        return $this->select('absensi.*, siswa.id, siswa.nama AS namaSiswa')
            ->join('siswa', 'siswa.id = absensi.id_siswa', 'right')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal', 'left')
            ->where('siswa.kelas_id', $id_kelas)
            ->where('jadwal.id_mapel', $id_mapel)
            ->where('siswa.status', 'Aktif')
            ->findAll();
    }

    public function getJumlahPertemuan($id_jadwal)
    {
        $row = $this->selectMax('pertemuan_ke')
            ->where('id_jadwal', $id_jadwal)
            ->first();

        return $row->pertemuan_ke ?? 0;
    }

    public function getUpdateabsen($jadwal, $id_siswa, $tanggal, $pertemuan)
    {
        return $this->where('id_jadwal', $jadwal->id)
            ->where('id_siswa', $id_siswa)
            ->where('tanggal', $tanggal)
            ->where('pertemuan_ke', $pertemuan)
            ->first();
    }

    public function getCekAbsen($jadwal, $tanggal, $pertemuan)
    {
        return $this->where('id_jadwal', $jadwal->id)
            ->where('tanggal', $tanggal)
            ->where('pertemuan_ke', $pertemuan)
            ->countAllResults();
    }

    public function getRekapAbsensiLengkap($id_kelas = null, $id_mapel = null, $dari = null, $sampai = null)
    {
        $builder = $this->select('
        siswa.id, siswa.nama, mapel.nama_mapel, jadwal.id_kelas, thn_ajaran.semester, kelas.nama_kls, kelas.rombel, jurusan.kode_jurusan, absensi.tanggal, absensi.pertemuan_ke, siswa.jenis_kelamin,
        SUM(CASE WHEN absensi.status = "hadir" THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN absensi.status = "sakit" THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN absensi.status = "izin" THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN absensi.status = "alpa" THEN 1 ELSE 0 END) AS alpa,
        COUNT(absensi.id) AS total
    ')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
            ->join('mapel', 'mapel.id = jadwal.id_mapel')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id')
            ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran');

        if (!empty($id_kelas)) {
            $builder->where('kelas.id', $id_kelas);
        }

        if (!empty($id_mapel)) {
            $builder->where('mapel.id', $id_mapel);
        }

        if (!empty($dari) && !empty($sampai)) {
            $builder->where('absensi.tanggal >=', $dari);
            $builder->where('absensi.tanggal <=', $sampai);
        } elseif (!empty($dari)) {
            $builder->where('absensi.tanggal', $dari);
        }

        return $builder
            ->groupBy('absensi.id_siswa')
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->getResult();
    }

    // public function getRekapAbsensi($id_kelas = null, $id_mapel = null, $semester = null, $dari = null, $sampai = null)
    // {
    //     $builder = $this->select('siswa.nama, 
    //       SUM(CASE WHEN absensi.status = "hadir" THEN 1 ELSE 0 END) AS hadir,
    //       SUM(CASE WHEN absensi.status = "sakit" THEN 1 ELSE 0 END) AS sakit,
    //       SUM(CASE WHEN absensi.status = "izin" THEN 1 ELSE 0 END) AS izin,
    //       SUM(CASE WHEN absensi.status = "alpha" THEN 1 ELSE 0 END) AS alpa,
    //       COUNT(absensi.id) AS total')
    //         ->join('siswa', 'siswa.id = absensi.id_siswa')
    //         ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
    //         ->join('mapel', 'mapel.id = jadwal.id_mapel')
    //         ->join('kelas', 'kelas.id = jadwal.id_kelas')
    //         ->join('thn_ajaran', 'thn_ajaran.id = jadwal.id_thnajaran');

    //     if (!empty($id_kelas)) {
    //         $builder->where('kelas.id', $id_kelas);
    //     }

    //     if (!empty($id_mapel)) {
    //         $builder->where('mapel.id', $id_mapel);
    //     }

    //     if (!empty($semester)) {
    //         $builder->where('thn_ajaran.semester', $semester);
    //     }

    //     if (!empty($dari)) {
    //         $builder->where('absensi.tanggal >=', $dari);
    //     }

    //     if (!empty($sampai)) {
    //         $builder->where('absensi.tanggal <=', $sampai);
    //     }

    //     return $builder
    //         ->groupBy('absensi.id_siswa')
    //         ->orderBy('siswa.nama', 'ASC')
    //         ->get()
    //         ->getResult();
    // }
}
