<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Jual extends Model
{
    protected $table = 'jual';
    protected $primaryKey = 'id_jual';
    protected $allowedFields = ['id_penjualan', 'id_barang', 'harga', 'jumlah'];
}
