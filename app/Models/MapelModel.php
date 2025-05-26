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
    protected $allowedFields    = ['id', 'kode_mapel', 'nama_mapel', 'id_thnajaran'];

    public function getMapel()
    {
        return $this->select('mapel.*, thn_ajaran.semester, thn_ajaran.tahun')
            ->join('thn_ajaran', 'thn_ajaran.id = mapel.id_thnajaran')
            ->findAll();
    }


    public function countAll()
    {
        return $this->countAllResults();
    }
}
