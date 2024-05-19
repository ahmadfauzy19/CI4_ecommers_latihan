<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jual extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jual' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_penjualan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);

        $this->forge->addPrimaryKey('id_jual');
        $this->forge->addForeignKey('id_penjualan', 'Penjualan', 'id_penjualan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_barang', 'Barang', 'id_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jual');
    }

    public function down()
    {
        $this->forge->dropTable('jual');
    }
}
