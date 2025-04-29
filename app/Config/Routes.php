<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->setAutoRoute(true);
// utama
$routes->get('/', 'Dashboard::index');

$routes->get('/siswa', 'Siswa::index');
$routes->get('/siswa/create', 'Siswa::create');
$routes->post('/siswa/save', 'Siswa::save');
$routes->get('/siswa/edit/(:num)', 'Siswa::edit/$1');
$routes->post('/siswa/update/(:num)', 'Siswa::update/$1');
$routes->delete('/siswa/(:num)', 'Siswa::delete/$1');
$routes->get('/siswa/(:any)', 'Siswa::detail/$1');

$routes->get('/guru', 'Guru::index');
$routes->get('/guru/(:any)', 'Guru::detail/$1');
$routes->get('/guru/create', 'Guru::create');
$routes->post('/guru/save', 'Guru::save');
$routes->get('/guru/edit/(:num)', 'Guru::edit/$1');
$routes->post('/guru/update/(:num)', 'Guru::update/$1');
$routes->delete('/guru/(:num)', 'Guru::delete/$1');

$routes->get('/absensi', 'Absensi::index');

$routes->get('/jadwal', 'Jadwal::index');

$routes->get('/akademik/thnajaran', 'Akademik::thnAjaran');
$routes->get('/akademik/kelas', 'Akademik::kelas');
$routes->get('/akademik/mapel', 'Akademik::mapel');
$routes->get('/akademik/jurusan', 'Akademik::jurusan');
