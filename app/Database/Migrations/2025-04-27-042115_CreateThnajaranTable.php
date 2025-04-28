<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateThnajaranTable extends Migration
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
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap']
            ],
            'tahun' => [
                'type' => 'YEAR',
                'null' => false,
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
        $this->forge->createTable('thn_ajaran');
    }

    public function down()
    {
        $this->forge->dropTable('thn_ajaran');
    }
}
