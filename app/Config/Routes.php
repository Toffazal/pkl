<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');

// Auth
$routes->add('auth', 'Auth::index');
$routes->add('login', 'Auth::index');
$routes->add('auth/index', 'Auth::index');
$routes->add('auth/prosesLogin', 'Auth::prosesLogin');
$routes->add('logout', 'Auth::logout');
// END Auth


// Siswa
$routes->add('dashboard', 'Siswa::index');
$routes->add('siswa', 'Siswa::index');
$routes->add('siswa/uploadBerkas', 'Siswa::uploadBerkas');
$routes->add('siswa/akun', 'Siswa::akun');
$routes->add('siswa/updateAkun', 'Siswa::updateAkun');
// End Siswa


// Pembimbing
$routes->add('pembimbing', 'Pembimbing::index');
$routes->add('pembimbing', 'Pembimbing::index');
$routes->add('pembimbing/akun', 'Pembimbing::akun');
$routes->add('pembimbing/updateAkun', 'Pembimbing::updateAkun');
$routes->add('pembimbing/selesai', 'Pembimbing::selesai');
$routes->add('pembimbing/selesai/(:num)', 'Pembimbing::selesai/$1');
// End Pembimbing


// Kajur
$routes->add('kajur', 'Kajur::index');
$routes->add('kajur', 'Kajur::index');
$routes->add('kajur/setuju', 'Kajur::setuju');
$routes->add('kajur/setuju/(:any)', 'Kajur::setuju/$1');
$routes->add('kajur/tolak', 'Kajur::tolak');
$routes->add('kajur/tolak/(:any)', 'Kajur::tolak/$1');
$routes->add('kajur/riwayat', 'Kajur::riwayat');
$routes->add('kajur/akun', 'Kajur::akun');
$routes->add('kajur/updateAkun', 'Kajur::updateAkun');
$routes->add('kajur/pembimbing', 'Kajur::pembimbing');
$routes->add('kajur/tambahKelompok', 'Kajur::tambahKelompok');
$routes->add('kajur/tambahKelompok/(:num)', 'Kajur::tambahKelompok/$1');
$routes->add('kajur/simpanKelompok', 'Kajur::simpanKelompok');
$routes->add('kajur/hapusKelompok', 'Kajur::hapusKelompok');
// End Kajur


// Admin
$routes->add('admin', 'Admin::dashboard');
$routes->add('admin/uploadBerkas', 'Admin::uploadBerkas');
$routes->add('admin/jurusan', 'Admin::jurusan');
$routes->add('admin/penilaian', 'Admin::penilaian');
$routes->add('admin/hapusPenilaian', 'Admin::hapusPenilaian');
$routes->add('admin/penilaian/(:any)', 'Admin::penilaian/$1');
$routes->add('admin/simpanPenilaian', 'Admin::simpanPenilaian');
$routes->add('admin/tambahJurusan', 'Admin::tambahJurusan');
$routes->add('admin/updateJurusan', 'Admin::updateJurusan');
$routes->add('admin/hapusJurusan', 'Admin::hapusJurusan');
$routes->add('admin/hapusJurusan/(:num)', 'Admin::hapusJurusan/$1');
$routes->add('admin/siswa', 'Admin::siswa');
$routes->add('admin/tambahSiswa', 'Admin::tambahSiswa');
$routes->add('admin/simpanSiswa', 'Admin::simpanSiswa');
$routes->add('admin/editSiswa', 'Admin::editSiswa');
$routes->add('admin/editSiswa/(:num)', 'Admin::editSiswa/$1');
$routes->add('admin/updateSiswa', 'Admin::updateSiswa');
$routes->add('admin/hapusSiswa/(:num)', 'Admin::hapusSiswa/$1');
$routes->add('admin/pegawai', 'Admin::pegawai');
$routes->add('admin/tambahPegawai', 'Admin::tambahPegawai');
$routes->add('admin/simpanPegawai', 'Admin::simpanPegawai');
$routes->add('admin/editPegawai', 'Admin::editPegawai');
$routes->add('admin/editPegawai/(:num)', 'Admin::editPegawai/$1');
$routes->add('admin/updatePegawai', 'Admin::updatePegawai');
$routes->add('admin/hapusPegawai/(:num)', 'Admin::hapusPegawai/$1');
$routes->add('admin/nilai', 'Admin::nilai');
$routes->add('admin/simpanNilai', 'Admin::simpanNilai');
$routes->add('admin/nilai/(:num)', 'Admin::nilai/$1');
$routes->add('admin/ubahNilai/(:num)', 'Admin::ubahNilai/$1');
$routes->add('admin/updateNilai', 'Admin::updateNilai');
$routes->add('admin/hapusNilai', 'Admin::hapusNilai');
$routes->add('admin/hapusNilai/(:num)', 'Admin::hapusNilai/$1');
$routes->add('admin/sertifikat', 'Admin::sertifikat');
$routes->add('admin/sertifikat/cover/(:num)', 'Admin::sertifikat/$1');
$routes->add('admin/sertifikat/nilai/(:num)', 'Admin::nilaiSertifikat/$1');
$routes->add('admin/akun', 'Admin::akun');
$routes->add('admin/updateAkun', 'Admin::updateAkun');
// End Admin



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
