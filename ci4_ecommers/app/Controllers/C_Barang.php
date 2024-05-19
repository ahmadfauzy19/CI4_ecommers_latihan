<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\M_DataBarang;
use app\Config\Autoload;

class C_Barang extends BaseController
{
    public function barang()
    {
        dd("adaa");
        $barangModel = new M_dataBarang();
        $data['barang'] = $barangModel->getAllBarang();
        $data['pager'] = $barangModel->pager;
        $data['nomor'] = nomor($this->request->getVar('barang'), 5);
        return view("Shop", $data);
    }

    public function view($kode)
    {
        $model = new M_DataBarang();
        $data['item'] = $model->find($kode);
        return view('data/view', $data);
    }

    public function cariBarang()
    {
        $model = new M_databarang();
        $keyword = $this->request->getVar('keyword');
        $data['barang'] = $model->paginate(5, 'barang', $keyword);
        $data['pager'] = $model->pager;
        $data['nomor'] = nomor($this->request->getVar('barang'), 5);

        return view('v_barang', $data);
    }


    public function detail($kode_barang)
    {
        // dd($kode_barang);
        $model = new M_dataBarang();
        $data['barang'] = $model->getDataBarangByKode($kode_barang);

        return view('v_detile', $data);
    }


    public function tambah()
    {
        return view('tambah_barang');
    }


    public function input()
    {
        helper('url');
        helper('form');
        if ($this->request->getMethod() === 'POST') {
            $model = new M_dataBarang();


            $counter = $model->getKode();
            $counter++;


            if ($this->request->getFile('gambar')) {
                $gambar = $this->request->getFile('gambar');
                $gambar->move('upload/');
                $gambarPath =  $gambar->getName();
            } else {
                $gambarPath = 'gambar/default.jpeg';
            }


            $kode = 'B' . str_pad($counter, 3, '0', STR_PAD_LEFT);


            $data = [
                'kode' => $kode,
                'nama' => $this->request->getPost('nama'),
                'harga' => $this->request->getPost('harga'),
                'stok' => $this->request->getPost('stok'),
                'gambar' => $gambarPath
            ];

            $success = $model->insertBarang($data);

            if ($success) {
                return redirect()->to(site_url('barang'))->withInput()->with('success', 'Berhasil menambahkan barang.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data barang.');
            }
        } else {
            dd("tidak menyimpan");
            return view('shop');
        }
    }
}
