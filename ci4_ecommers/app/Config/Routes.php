<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/shop', 'Barang::shop');

$routes->get('/', 'Home::index');
$routes->get('/cartShop', 'Barang::cart');
$routes->get('/cart(:num)', 'Barang::cartinput/$1');
$routes->post('cart/update', 'Barang::update');
$routes->get('hapusitem(:num)', 'Barang::hapus/$1');

$routes->get('/checkout', 'Barang::checkout');
$routes->get('/berhasil', 'Barang::berhasil');
$routes->post('/order', 'Barang::order');


// $routes->get('/barang', 'C_Barang::barang');
// $routes->get('/cariBarang', 'C_Barang::cariBarang');
// $routes->post('/barang/input', 'C_Barang::input');
// $routes->get('/barang/input', 'C_Barang::tambah');

// $routes->get('/detail/(:alphanum)', 'C_Barang::detail/$1');

// $routes->get('/search', 'C_Search::search');

// $routes->get('/validasi', 'C_FormValidasi::index');
// $routes->get('/berhasil', 'C_FormValidasi::berhasil');
// $routes->post('/validasi', 'C_FormValidasi::validasi');
