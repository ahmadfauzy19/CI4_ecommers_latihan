<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_DataBarang;
use App\Models\M_Jual;
use App\Models\M_Penjualan;
use CodeIgniter\HTTP\Request;

class Barang extends BaseController
{
    public function shop()
    {
        $barangModel = new M_dataBarang();
        $data['barang'] = $barangModel->getAllBarang();
        return view("Shop", $data);
    }

    public function cart()
    {
        $session = session();
        $cart = $session->get('cart', []);

        $subtotal = 0;
        if ($cart != null) {
            foreach ($cart as $item) {
                $subtotal += $item['harga'] * $item['kuantitas'];
            }
            $data['cart'] = $cart;
            $data['subtotal'] = $subtotal;
            $data['total'] = $subtotal;
            return view('cart', $data);
        }
        $data['cart'] = [];
        $data['subtotal'] = $subtotal;
        $data['total'] = $subtotal;
        return view('/cart', $data);
    }

    public function cartinput($id_barang)
    {
        $session = session();
        $barangModel = new M_dataBarang();
        $barang = $barangModel->find($id_barang);

        // Pastikan barang ditemukan
        if (!$barang) {
            // Jika barang tidak ditemukan, kembalikan respons dengan pesan error
            return view('Shop', ['message' => 'Barang tidak ditemukan']);
        }

        // Ambil data keranjang dari session
        $cart = $session->get('cart') ?? [];

        // Cek apakah barang sudah ada di dalam keranjang
        $itemIndex = $this->findItemIndex($cart, $id_barang);

        if ($itemIndex === null) {
            // Jika barang belum ada di dalam keranjang, tambahkan sebagai item baru
            $cart[] = [
                'id' => $barang['id_barang'],
                'nama' => $barang['namaBarang'],
                'harga' => $barang['harga'],
                'gambar' => $barang['gambar'],
                'kuantitas' => 1,
                // tambahkan detail lain yang dibutuhkan
            ];
        } else {
            // Jika barang sudah ada di dalam keranjang, tambahkan kuantitasnya
            $cart[$itemIndex]['kuantitas']++;
        }

        // Simpan kembali data keranjang ke dalam session
        $session->set('cart', $cart);

        return redirect()->to('shop')->with('message', 'Barang berhasil ditambahkan ke keranjang');
    }

    public function update()
    {
        $session = session();
        $cart = $session->get('cart');

        $id = $this->request->getPost('id');
        $quantity = $this->request->getPost('quantity');

        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['kuantitas'] = $quantity;
                break;
            }
        }

        $session->set('cart', $cart);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function hapus($id_barang)
    {
        $session = session();
        $cart = $session->get('cart');

        // Cari dan hapus item dari keranjang
        foreach ($cart as $key => $item) {
            if ($item['id'] == $id_barang) {
                unset($cart[$key]);
                break;
            }
        }

        // Hitung subtotal baru
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['kuantitas'];
        }

        // Simpan keranjang yang diperbarui ke sesi
        $session->set('cart', $cart);

        return redirect()->to('cartShop')->with('message', 'Barang berhasil dihapus');
    }


    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['kuantitas'];
        }
        $data['cart'] = $cart;
        $data['subtotal'] = $subtotal;
        $data['total'] = $subtotal;
        return view('checkout', $data);
    }

    public function order()
    {
        $request = \Config\Services::request();
        $session = session();
        $cart = $session->get('cart', []);

        $fname = $request->getPost('fname');
        $lname = $request->getPost('lname');
        $nama = $fname . ' ' . $lname;
        $alamat = $request->getPost('address');
        $hp = $request->getPost('phone');

        // Buat instance dari model

        $jualModel = new M_Jual();
        $penjualanModel = new M_Penjualan();
        $barangModel = new M_DataBarang();

        // Data yang akan disimpan
        $dataPenjualan = [
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $hp,
            'tanggal' => date('Y-m-d') // Mendapatkan tanggal saat ini
        ];

        // Simpan data ke dalam database dan dapatkan id_penjualan
        $penjualanModel->insert($dataPenjualan);
        $idPenjualan = $penjualanModel->insertID();

        // Loop melalui keranjang dan simpan data ke dalam tabel jual
        foreach ($cart as $item) {
            $barang = $barangModel->find($item['id']);

            if ($barang) {
                // Data yang akan disimpan ke tabel jual
                $dataJual = [
                    'id_penjualan' => $idPenjualan,
                    'id_barang' => $item['id'],
                    'harga' => $item['harga'],
                    'jumlah' => $item['kuantitas']
                ];
                $barang['stok'] -= $item['kuantitas'];
                $jualModel->save($dataJual);
                $barangModel->save($barang);
            }
        }

        // Kosongkan keranjang setelah order disimpan
        $session->remove('cart');

        // Tampilkan pesan sukses atau redirect ke halaman lain
        return redirect()->to('berhasil')->with('message', 'Order berhasil disimpan!');
    }

    public function berhasil()
    {
        return view('berhasil');
    }





    // Method untuk mencari index item dalam keranjang berdasarkan id_barang
    private function findItemIndex($cart, $id_barang)
    {
        foreach ($cart as $index => $item) {
            if ($item['id'] == $id_barang) {
                return $index;
            }
        }
        return null;
    }
}
