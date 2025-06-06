<?php

namespace App\Models;

use CodeIgniter\Model;

class KetAbsenModel extends Model
{
    protected $table            = 'absen_keterangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id_guru', 'id_jadwal', 'tanggal', 'alasan', 'keterangan'];

    public function isGuruTidakMasuk($id_guru, $tanggal, $id_jadwal = null)
    {
        $builder = $this->where('id_guru', $id_guru)
            ->where('tanggal', $tanggal)
            ->groupStart()
            ->where('id_jadwal', $id_jadwal)
            ->orWhere('id_jadwal', null)
            ->groupEnd();

        return $builder->countAllResults() > 0;
    }

    public function getGuruTidakMasuk($id_guru, $tanggal)
    {
        return $this->where('id_guru', $id_guru)
            ->where('tanggal', $tanggal)
            ->first();
    }
}
