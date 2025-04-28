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

$routes->get('/guru', 'Guru::index');

$routes->get('/absensi', 'Absensi::index');

$routes->get('/jadwal', 'Jadwal::index');

$routes->get('/akademik/thnajaran', 'Akademik::thnAjaran');
$routes->get('/akademik/kelas', 'Akademik::kelas');
$routes->get('/akademik/mapel', 'Akademik::mapel');
$routes->get('/akademik/wakel', 'Akademik::wakel');
