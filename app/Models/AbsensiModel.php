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
    protected $allowedFields    = [
        'id_siswa',
        'id_jadwal',
        'pertemuan_ke',
        'tanggal',
        'status'
    ];


    public function getAbsen()
    {
        return $this->select('absensi.*, siswa.nama AS siswa')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
            ->findAll();
    }

    public function getAbsenKelas($id_kelas, $id_mapel)
    {
        return $this->select('absensi.*, siswa.nama AS namaSiswa')
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

    public function getCekAbsen($id_jadwal, $tanggal, $pertemuan)
    {
        return $this->where('id_jadwal', $id_jadwal)
            ->where('tanggal', $tanggal)
            ->where('pertemuan_ke', $pertemuan)
            ->countAllResults();
    }

    public function getRekapAbsensiLengkap($id_kelas = null, $id_mapel = null, $dari = null, $sampai = null)
    {
        $builder = $this->select('
            siswa.id,
            siswa.nama,
            kelas.nama_kls,
            kelas.rombel,
            jurusan.kode_jurusan,
            absensi.tanggal,
            absensi.pertemuan_ke,
            SUM(CASE WHEN absensi.status = "hadir" THEN 1 ELSE 0 END) AS hadir,
            SUM(CASE WHEN absensi.status = "sakit" THEN 1 ELSE 0 END) AS sakit,
            SUM(CASE WHEN absensi.status = "izin" THEN 1 ELSE 0 END) AS izin,
            SUM(CASE WHEN absensi.status = "alpa" THEN 1 ELSE 0 END) AS alpa,
            COUNT(absensi.id) AS total
        ')
            ->join('siswa', 'siswa.id = absensi.id_siswa')
            ->join('jadwal', 'jadwal.id = absensi.id_jadwal')
            ->join('kelas', 'kelas.id = jadwal.id_kelas')
            ->join('jurusan', 'jurusan.id = kelas.jurusan_id');

        if ($id_kelas) {
            $builder->where('kelas.id', $id_kelas);
        }

        if ($id_mapel) {
            $builder->where('jadwal.id_mapel', $id_mapel);
        }

        if ($dari && $sampai) {
            $builder->where('absensi.tanggal >=', $dari);
            $builder->where('absensi.tanggal <=', $sampai);
        }

        return $builder
            ->groupBy('absensi.id_siswa')
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->getResult();
    }
}
