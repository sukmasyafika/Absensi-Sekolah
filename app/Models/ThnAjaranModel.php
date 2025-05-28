<?php

namespace App\Models;

use CodeIgniter\Model;

class ThnAjaranModel extends Model
{
    protected $table            = 'thn_ajaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['semester', 'tahun', 'status'];

    public function isDuplicate($semester, $tahun, $excludeId = null)
    {
        $builder = $this->where('semester', $semester)
            ->where('tahun', $tahun);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->first() !== null;
    }

    public function getThnAjaran()
    {
        return $this->select('id, semester')->findAll();
    }
}
