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
        return $this->where('status', 'Aktif')->select('id, semester, tahun')->findAll();
    }

    public function insertWithStatusCheck(array $data)
    {
        if (isset($data['status']) && $data['status'] === 'Aktif') {
            $this->where('status', 'Aktif')->set('status', 'Tidak Aktif')->update();
        }

        return $this->insert($data);
    }

    public function updateWithStatusCheck($id, array $data)
    {
        if (isset($data['status']) && $data['status'] === 'Aktif') {
            $this->where('status', 'Aktif')->where('id !=', $id)->set('status', 'Tidak Aktif')->update();
        }

        return $this->update($id, $data);
    }

    public function getAllOrdered()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
