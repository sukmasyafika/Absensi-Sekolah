<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->setAutoRoute(true);

$routes->group('', ['filter' => 'role:admin'], function ($routes) {

  $routes->get('dashboard', 'Dashboard::index');

  // penguna
  $routes->get('user', 'User::index');
  $routes->get('/user/edit/(:num)', 'User::edit/$1');
  $routes->post('/user/update/(:num)', 'User::update/$1');
  $routes->delete('/user/delete/(:num)', 'User::delete/$1');

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
  $routes->get('/mapel/create', 'Mapel::create');
  $routes->post('/mapel/save', 'Mapel::save');
  $routes->get('/mapel/edit/(:num)', 'Mapel::edit/$1');
  $routes->post('/mapel/update/(:num)', 'Mapel::update/$1');
  $routes->delete('/mapel/delete/(:num)', 'Mapel::delete/$1');

  // tahun ajaran
  $routes->get('thnajaran', 'ThnAjaran::index');
  $routes->get('/thnajaran/create', 'ThnAjaran::create');
  $routes->post('/thnajaran/save', 'ThnAjaran::save');
  $routes->get('/thnajaran/edit/(:num)', 'ThnAjaran::edit/$1');
  $routes->post('/thnajaran/update/(:num)', 'ThnAjaran::update/$1');
  $routes->delete('/thnajaran/delete/(:num)', 'ThnAjaran::delete/$1');

  // jurusan
  $routes->get('jurusan', 'Jurusan::index');
  $routes->get('/jurusan/create', 'Jurusan::create');
  $routes->post('/jurusan/save', 'Jurusan::save');
  $routes->get('/jurusan/edit/(:num)', 'Jurusan::edit/$1');
  $routes->post('/jurusan/update/(:num)', 'Jurusan::update/$1');
  $routes->delete('/jurusan/delete/(:num)', 'Jurusan::delete/$1');

  //kalender akademik
  $routes->get('kalender', 'Kalender::index');
  $routes->get('kalender/getLibur', 'Kalender::getLibur');
  $routes->get('/kalender/create', 'Kalender::create');
  $routes->post('/kalender/save', 'Kalender::save');
  $routes->get('/kalender/edit/(:num)', 'Kalender::edit/$1');
  $routes->post('/kalender/update/(:num)', 'Kalender::update/$1');
  $routes->delete('/kalender/delete/(:num)', 'Kalender::delete/$1');

  // jadwal
  $routes->get('/jadwal', 'Jadwal::index');
  $routes->get('/jadwal/create', 'Jadwal::create');
  $routes->post('/jadwal/save', 'Jadwal::save');
  $routes->get('/jadwal/edit/(:num)', 'Jadwal::edit/$1');
  $routes->post('/jadwal/update/(:num)', 'Jadwal::update/$1');
  $routes->delete('/jadwal/delete/(:num)', 'Jadwal::delete/$1');
  $routes->get('/jadwal/detail/(:num)', 'Jadwal::detail/$1');
  $routes->post('/jadwal/import', 'Jadwal::import');
  $routes->delete('/jadwal/hapus', 'Jadwal::hapus');


  // laporan
  $routes->get('/laporan', 'Laporan::index');
  $routes->get('/laporan/siswaPdf', 'Laporan::siswaPdf');
  $routes->get('/laporan/absenPdf', 'Laporan::absenPdf');
});

$routes->group('', ['filter' => 'role:guru'], function ($routes) {

  $routes->get('dashguru', 'Dashguru::index');

  // rekap
  $routes->get('/rekap', 'Rekap::index');
  $routes->get('/rekap/cetakLaporan', 'Rekap::cetakLaporan');

  // Absensi
  $routes->get('/absensi', 'Absensi::index');
  $routes->post('/absensi/save', 'Absensi::save');
  $routes->post('/absensi/savegurutidakmasuk', 'Absensi::savegurutidakmasuk');

  $routes->get('/profil', 'Profil::index');
});
