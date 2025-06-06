<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = True;
    protected $allowedFields    = ['slug', 'nama', 'nip', 'jabatan', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'thn_masuk', 'foto', 'status'];

    public function getGuru($slug = false)
    {
        $builder = $this->where('status', 'Aktif')
            ->orderBy('guru.id', 'DESC');

        if ($slug === false) {
            return $builder->findAll();
        }

        return $builder->where(['slug' => $slug])->first();
    }

    public function getWakel()
    {
        return $this->where('jabatan', 'Wali Kelas')->select('id, nama')->findAll();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function getIdByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
