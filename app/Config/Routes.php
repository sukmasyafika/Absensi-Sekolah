<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->setAutoRoute(true);
// utama
$routes->get('/', 'Login::index');

$routes->get('dashboard', 'Dashboard::index');

// siswa
$routes->get('/siswa', 'Siswa::index');
$routes->get('/siswa/create', 'Siswa::create');
$routes->post('/siswa/save', 'Siswa::save');
$routes->get('/siswa/edit/(:segment)', 'Siswa::edit/$1');
$routes->post('/siswa/update/(:num)', 'Siswa::update/$1');
$routes->delete('/siswa/delete/(:num)', 'Siswa::delete/$1');
$routes->delete('/siswa/hapus', 'Siswa::hapus');
$routes->get('/siswa/detail/(:any)', 'Siswa::detail/$1');
$routes->post('/siswa/import', 'Siswa::import');

// guru
$routes->get('/guru', 'Guru::index');
$routes->get('/guru/create', 'Guru::create');
$routes->post('/guru/save', 'Guru::save');
$routes->get('/guru/edit/(:segment)', 'Guru::edit/$1');
$routes->post('/guru/update/(:num)', 'Guru::update/$1');
$routes->delete('/guru/delete/(:num)', 'Guru::delete/$1');
$routes->delete('/guru/hapus', 'Guru::hapus');
$routes->get('/guru/detail/(:any)', 'Guru::detail/$1');
$routes->post('/guru/import', 'Guru::import');

// kelas
$routes->get('/kelas', 'Kelas::index');
$routes->get('/kelas/create', 'Kelas::create');
$routes->post('/kelas/save', 'Kelas::save');
$routes->get('/kelas/edit/(:num)', 'Kelas::edit/$1');
$routes->post('/kelas/update/(:num)', 'Kelas::update/$1');
$routes->delete('/kelas/delete/(:num)', 'Kelas::delete/$1');

// mapel
$routes->get('mapel', 'Mapel::index');

// jurusan
$routes->get('jurusan', 'Jurusan::index');

// tahun ajaran
$routes->get('thnajaran', 'ThnAjaran::index');

// jadwal (nanti sa yg buat)
$routes->get('/jadwal', 'Jadwal::index');


// untuk halaman guru nanti
$routes->get('/absensi', 'Absensi::index');
