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
            [
                'id_barang' => '4',
                'namaBarang' => 'charger',
                'harga' => 10000,
                'stok' => 35,
                'gambar' => 'charger.jpg'
            ],
            [
                'id_barang' => '5',
                'namaBarang' => 'Laptop',
                'harga' => 100000,
                'stok' => 32,
                'gambar' => 'laptop.jpg'
            ],
            [
                'id_barang' => '6',
                'namaBarang' => 'tas',
                'harga' => 40000,
                'stok' => 32,
                'gambar' => 'tas.jpg'
            ],
            [
                'id_barang' => '7',
                'namaBarang' => 'sandal',
                'harga' => 9000,
                'stok' => 20,
                'gambar' => 'sandal.jpg'
            ],
            [
                'id_barang' => '8',
                'namaBarang' => 'sepatu',
                'harga' => 45000,
                'stok' => 40,
                'gambar' => 'sepatu.jpg'
            ],
        ];

        // Mendapatkan instance dari Database
        $db = \Config\Database::connect();

        // Insert data ke dalam tabel 'databarang'
        $db->table('barang')->insertBatch($data);
    }
}
