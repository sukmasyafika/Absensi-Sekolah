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
    protected $allowedFields    = ['id', 'kode_mapel', 'nama_mapel', 'id_thnAjaran'];

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

        return $this->select('mapel.*, thn_ajaran.semester, thn_ajaran.tahun')
            ->join('thn_ajaran', 'thn_ajaran.id = mapel.id_thnAjaran')
            ->where('thn_ajaran.semester', $semesterAktif)
            ->findAll();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }
}
