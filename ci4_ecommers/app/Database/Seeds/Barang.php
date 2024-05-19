<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Barang extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_barang' => '1',
                'namaBarang' => 'PENA',
                'harga' => 5000,
                'stok' => 20,
                'gambar' => 'pena.jpg'
            ],
            [
                'id_barang' => '2',
                'namaBarang' => 'PENGHAPUS',
                'harga' => 3000,
                'stok' => 13,
                'gambar' => 'penghapus.jpg'
            ],
            [
                'id_barang' => '3',
                'namaBarang' => 'PENSIL',
                'harga' => 2000,
                'stok' => 32,
                'gambar' => 'pensil.jpg'
            ],
        ];

        // Mendapatkan instance dari Database
        $db = \Config\Database::connect();

        // Insert data ke dalam tabel 'databarang'
        $db->table('barang')->insertBatch($data);
    }
}
