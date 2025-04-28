<?php

namespace App\Models;

use CodeIgniter\Model;

class ThnAjaranModel extends Model
{
    protected $table            = 'thn_ajaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id', 'semester', 'tahun', 'status'];
}
