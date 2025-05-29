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
    protected $allowedFields = ['id_guru', 'email', 'username', 'active'];

    protected $db;
    protected $builderAuthGroupsUsers;
    protected $builderAuthGroups;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->builderAuthGroupsUsers = $this->db->table('auth_groups_users');
        $this->builderAuthGroups = $this->db->table('auth_groups');
    }

    public function updateUserData($userid, $data)
    {
        return $this->update($userid, $data);
    }

    public function updateUserRole($userid, $roleName)
    {
        $group = $this->builderAuthGroups->where('name', $roleName)->get()->getRow();

        if (!$group) {
            return false;
        }

        $this->builderAuthGroupsUsers->where('user_id', $userid)->delete();

        $insert = $this->builderAuthGroupsUsers->insert([
            'user_id'  => $userid,
            'group_id' => $group->id,
        ]);

        return $insert;
    }

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
        $builder =  $this->select('users.id AS userid, users.id_guru, guru.nama AS namaguru, username, email, active, auth_groups.name AS group_name')
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
