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
}
