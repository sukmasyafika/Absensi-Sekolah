<?php

namespace App\Models;

use CodeIgniter\Model;

class KalenderModel extends Model
{
    protected $table            = 'hari_libur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['tanggal', 'nama_libur', 'keterangan'];
}
