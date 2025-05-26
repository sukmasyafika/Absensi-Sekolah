<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->setAutoRoute(true);

$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashguru', 'Dashguru::index');

// penguna
$routes->get('user', 'User::index');
$routes->get('/user/edit/(:num)', 'user::edit/$1');
$routes->post('/user/update/(:num)', 'User::update/$1');
// $routes->post('user/update', 'User::update');



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
$routes->get('/thnajaran/create', 'ThnAjaran::create');
$routes->post('/thnajaran/save', 'ThnAjaran::save');
$routes->get('/thnajaran/edit/(:num)', 'ThnAjaran::edit/$1');
$routes->post('/thnajaran/update/(:num)', 'ThnAjaran::update/$1');
$routes->delete('/thnajaran/delete/(:num)', 'ThnAjaran::delete/$1');

// jadwal
$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/jadwal/create', 'Jadwal::create');
$routes->post('/jadwal/save', 'Jadwal::save');
$routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1');
$routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1');
$routes->delete('/jadwal/delete/(:num)', 'Jadwal::delete/$1');
$routes->get('/jadwal/detail/(:num)', 'Jadwal::detail/$1');

// untuk halaman guru
$routes->get('/absensi', 'Absensi::index');

$routes->get('/profil', 'Profil::index');
