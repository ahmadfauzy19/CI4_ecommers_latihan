<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjualan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,  // Add unsigned
                'auto_increment' => true,  // Add auto_increment
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal' => [
                'type' => 'DATE'
            ]
        ]);

        $this->forge->addPrimaryKey('id_penjualan');
        $this->forge->createTable('Penjualan');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan');
    }
}
