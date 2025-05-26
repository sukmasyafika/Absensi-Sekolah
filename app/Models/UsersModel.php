<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields = ['id_guru', 'email', 'username', 'password_hash', 'active'];

    public function getProfil($userId)
    {
        return $this->select('users.*, guru.*')
            ->join('guru', 'guru.id = users.id_guru', 'left')
            ->where('users.id', $userId)
            ->first();
    }

    public function countAll()
    {
        return $this->countAllResults();
    }

    public function getPengguna($userid = false)
    {
        $builder =  $this->select('users.id AS userid, guru.nama AS namaguru,  username, email, active,  auth_groups.name AS group_name')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->join('guru', 'guru.id = users.id_guru', 'left')
            ->orderBy('users.created_at', 'DESC');

        if ($userid === false) {
            return $builder->findAll();
        }

        return $builder->where(['users.id' => $userid])->first();
    }
}
