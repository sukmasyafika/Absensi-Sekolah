<?php

namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table            = 'mapel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id', 'kode_mapel', 'nama_mapel', 'id_thnAjaran', 'id_jurusan'];

    public function getMapel()
    {
        $aktif = $this->db->table('thn_ajaran')
            ->select('semester')
            ->where('status', 'Aktif')
            ->get()
            ->getRow();

        if (!$aktif) {
            return [];
        }

        $semesterAktif = $aktif->semester;

        return $this->select('mapel.*, thn_ajaran.semester, thn_ajaran.tahun, jurusan.nama_jurusan, jurusan.kode_jurusan')
            ->join('thn_ajaran', 'thn_ajaran.id = mapel.id_thnAjaran')
            ->join('jurusan', 'jurusan.id = mapel.id_jurusan', 'left')
            ->where('thn_ajaran.semester', $semesterAktif)
            ->findAll();
    }

    public function getIdByKode($kode)
    {
        return $this->where('kode_mapel', $kode)->first();
    }


    public function countAll()
    {
        return $this->countAllResults();
    }
}
