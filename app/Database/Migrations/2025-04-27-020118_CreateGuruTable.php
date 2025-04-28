<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => 18,
                'unique'     => true,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
            ],
            'agama' => [
                'type' => 'ENUM',
                'constraint' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
            ],
            'thn_masuk' => [
                'type' => 'YEAR',
                'null' => false,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'    => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default' => 'Aktif',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
