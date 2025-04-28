<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateKelasTable extends Migration
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
            'nama_kls' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'jurusan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'wali_kelas_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
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

        $this->forge->addForeignKey('jurusan_id', 'jurusan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('wali_kelas_id', 'guru', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}
