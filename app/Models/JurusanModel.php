<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = 'jurusan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['kode_jurusan', 'nama_jurusan'];

    public function getListJurusan()
    {
        return $this->select('id, nama_jurusan')->findAll();
    }


    public function countAll()
    {
        return $this->countAllResults();
    }
}
