<?php

namespace App\Models;

use CodeIgniter\Model;

class M_DataBarang extends Model
{

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $allowedFields = ['id_barang', 'namaBarang', 'harga', 'stok', 'gambar'];

    public function getAllBarang()
    {
        // Menggunakan query SQL untuk mengambil semua data mahasiswa
        $query = $this->db->query('SELECT * FROM barang');

        // Mengembalikan hasil query sebagai array
        return $query->getResultArray();
    }

    public function search($keyword)
    {
        $query = "SELECT * FROM barang WHERE nama LIKE '%$keyword%'";
        $result = $this->db->query($query);
        return $result->getResultArray();
    }

    public function getDataBarangByKode($kode)
    {
        $query = "SELECT * FROM barang WHERE kode = ?";
        $result = $this->db->query($query, [$kode]);
        return $result->getRowArray(); // Mengembalikan satu baris hasil sebagai array asosiatif
    }

    public function getKode()
    {
        // Query untuk mendapatkan nilai terkecil dari counter
        $query = $this->db->query('SELECT MIN(CAST(SUBSTRING(kode, 2) AS UNSIGNED)) AS min_counter FROM databarang');
        $row = $query->getRow();
        $minCounter = $row->min_counter ?? 0;

        // Mencari nilai yang tidak ada setelah nilai terkecil
        $currentCounter = $minCounter;
        $nextCounter = $minCounter + 1;

        while (true) {
            // Cek apakah nilai berikutnya sudah ada di dalam tabel
            $query = $this->db->query("SELECT COUNT(*) AS count FROM databarang WHERE kode = 'B" . str_pad($nextCounter, 3, '0', STR_PAD_LEFT) . "'");
            $row = $query->getRow();

            // Jika tidak ada, maka nilai berikutnya adalah nilai terakhir yang buntu
            if ($row->count == 0) {
                return $currentCounter;
            }

            // Pindah ke nilai berikutnya
            $currentCounter = $nextCounter;
            $nextCounter++;
        }
    }


    public function insertBarang($data)
    {

        $query = "INSERT INTO databarang (kode, nama, harga, stok, gambar) VALUES (?, ?, ?, ?,?)";
        $this->db->query($query, [$data['kode'], $data['nama'], $data['harga'], $data['stok'], $data['gambar']]);
        return $this->db->affectedRows() > 0;
    }
}
