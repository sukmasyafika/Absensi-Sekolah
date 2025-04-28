<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateAbsensiTable extends Migration
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
            'id_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_jadwal' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'pertemuan_ke' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => false,
                'unsigned'   => true,
            ],
            'tanggal' => [
                'type'       => 'DATE',
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Hadir', 'Sakit', 'Izin', 'Alpha'],
                'default'    => 'Hadir',
            ],
            'jam_absen' => [
                'type'       => 'TIME',
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
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_siswa', 'siswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
