<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $allowedFields = ['nama', 'alamat', 'no_hp', 'tanggal'];
}
