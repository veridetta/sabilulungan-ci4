<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/infografis', 'Main::infografis');
$routes->get('/', 'Main::index');
$routes->get('/tentang', 'Main::tentang');
$routes->get('proposal/(:num)/(:num)/(:num)/(:num)/(:num)/(:num)', 'Main::proposal/$1/$2/$3/$4/$5/$6');
$routes->get('proposal', 'Main::proposal');
$routes->post('proposal', 'Main::proposal');
$routes->get('proposal/(:num)', 'Main::proposal/$1');
$routes->get('proposal/(:num)/(:num)', 'Main::proposal/$1/$2');
$routes->get('proposal/(:num)/(:num)/(:num)', 'Main::proposal/$1/$2/$3');
$routes->get('proposal/(:num)/(:num)/(:num)/(:num)', 'Main::proposal/$1/$2/$3/$4');
$routes->get('proposal/(:num)/(:num)/(:num)/(:num)/(:num)', 'Main::proposal/$1/$2/$3/$4/$5');
$routes->get('/peraturan', 'Main::peraturan');
$routes->get('/lapor', 'Main::lapor');

$routes->post('lapor/(:num)/(:num)', 'Process::lapor/$1/$2');
$routes->post('lapor/(:num)', 'Process::lapor/$1');

$routes->get('/listlaporan', 'Main::listlaporan');
$routes->get('/listlaporan/(:num)', 'Main::listlaporan/$1');
$routes->get('/listlaporan/(:num)/(:num)', 'Main::listlaporan/$1/$2');

$routes->get('/pengumuman', 'Main::pengumuman');
$routes->get('/pengumuman/(:num)', 'Main::pengumuman/$1');
$routes->get('/pengumuman/(:num)/(:num)', 'Main::pengumuman/$1/$2');

$routes->get('/statistik', 'Main::statistik');
$routes->get('/statistik/(:any)', 'Main::statistik/$1');
$routes->get('/statistik/(:any)/(:any)', 'Main::statistik/$1/$2');


$routes->get('/detail', 'Main::detail');
$routes->get('/detail/(:any)', 'Main::detail/$1');

$routes->get('/galeri', 'Main::galeri');
$routes->get('/galeri/(:any)', 'Main::galeri/$1');

$routes->get('/laporan', 'Main::laporan');
$routes->get('/laporan/(:any)', 'Main::laporan/$1');

$routes->get('/view', 'Main::view');
$routes->get('/view/(:any)', 'Main::view/$1');

$routes->get('/bcc', 'Main::bcc');

$routes->get('/login', 'Auth::login');
$routes->post('/user/(:any)', 'Auth::user/$1');
$routes->post('/user/(:any)/(:any)', 'Auth::user/$1/$2');

//logout
$routes->get('/logout', 'Auth::logout');
$routes->get('/logout/(:any)', 'Auth::logout/$1');

//daftar
$routes->get('/daftar', 'Auth::daftar');

$routes->get('/report', 'HasLogin::report');
$routes->get('/report/(:any)', 'HasLogin::report/$1');
$routes->get('/report/(:any)/(:any)', 'HasLogin::report/$1/$2');

$routes->post('/report', 'HasLogin::report');
$routes->post('/report/(:any)', 'HasLogin::report/$1');
$routes->post('/report/(:any)/(:any)', 'HasLogin::report/$1/$2');

$routes->get('/hibah', 'HasLogin::hibah');
$routes->get('/hibah/(:any)', 'HasLogin::hibah/$1');
$routes->get('/hibah/(:any)/(:any)', 'HasLogin::hibah/$1/$2');


$routes->post('/process/hibah', 'Process::hibah');
$routes->post('/process/hibah/(:any)', 'Process::hibah/$1');
$routes->post('/process/hibah/(:any)/(:any)', 'Process::hibah/$1/$2');

$routes->get('/tatausaha', 'HasLogin::tatausaha');
$routes->get('/tatausaha/(:any)', 'HasLogin::tatausaha/$1');
$routes->get('/tatausaha/(:any)/(:any)', 'HasLogin::tatausaha/$1/$2');

$routes->post('/process/tatausaha', 'Process::tatausaha');
$routes->post('/process/tatausaha/(:any)', 'Process::tatausaha/$1');
$routes->post('/process/tatausaha/(:any)/(:any)', 'Process::tatausaha/$1/$2');

$routes->get('/walikota', 'HasLogin::walikota');
$routes->get('/walikota/(:any)', 'HasLogin::walikota/$1');
$routes->get('/walikota/(:any)/(:any)', 'HasLogin::walikota/$1/$2');

$routes->post('/process/walikota', 'Process::walikota');
$routes->post('/process/walikota/(:any)', 'Process::walikota/$1');
$routes->post('/process/walikota/(:any)/(:any)', 'Process::walikota/$1/$2');

$routes->get('/pertimbangan', 'HasLogin::pertimbangan');
$routes->get('/pertimbangan/(:any)', 'HasLogin::pertimbangan/$1');
$routes->get('/pertimbangan/(:any)/(:any)', 'HasLogin::pertimbangan/$1/$2');

$routes->post('/process/pertimbangan', 'Process::pertimbangan');
$routes->post('/process/pertimbangan/(:any)', 'Process::pertimbangan/$1');
$routes->post('/process/pertimbangan/(:any)/(:any)', 'Process::pertimbangan/$1/$2');

$routes->get('/skpd', 'HasLogin::skpd');
$routes->get('/skpd/(:any)', 'HasLogin::skpd/$1');
$routes->get('/skpd/(:any)/(:any)', 'HasLogin::skpd/$1/$2');

$routes->post('/process/skpd', 'Process::skpd');
$routes->post('/process/skpd/(:any)', 'Process::skpd/$1');
$routes->post('/process/skpd/(:any)/(:any)', 'Process::skpd/$1/$2');

$routes->get('/tapd', 'HasLogin::tapd');
$routes->get('/tapd/(:any)', 'HasLogin::tapd/$1');
$routes->get('/tapd/(:any)/(:any)', 'HasLogin::tapd/$1/$2');

$routes->post('/tapd', 'HasLogin::tapd');
$routes->post('/tapd/(:any)', 'HasLogin::tapd/$1');
$routes->post('/tapd/(:any)/(:any)', 'HasLogin::tapd/$1/$2');

$routes->post('/process/tapd', 'Process::tapd');
$routes->post('/process/tapd/(:any)', 'Process::tapd/$1');
$routes->post('/process/tapd/(:any)/(:any)', 'Process::tapd/$1/$2');

$routes->get('/admin', 'HasLogin::admin');
$routes->get('/admin/(:any)', 'HasLogin::admin/$1');
$routes->get('/admin/(:any)/(:any)', 'HasLogin::admin/$1/$2');

$routes->post('/process/admin', 'Process::admin');
$routes->post('/process/admin/(:any)', 'Process::admin/$1');
$routes->post('/process/admin/(:any)/(:any)', 'Process::admin/$1/$2');

$routes->get('/detil', 'HasLogin::detil');
$routes->get('/detil/(:any)', 'HasLogin::detil/$1');
$routes->get('/detil/(:any)/(:any)', 'HasLogin::detil/$1/$2');

$routes->get('/cms', 'HasLogin::cms');
$routes->get('/cms/(:any)', 'HasLogin::cms/$1');
$routes->get('/cms/(:any)/(:any)', 'HasLogin::cms/$1/$2');
$routes->get('/cms/(:any)/(:any)/(:any)', 'HasLogin::cms/$1/$2/$3');

$routes->post('/process/cms', 'Process::cms');
$routes->post('/process/cms/(:any)', 'Process::cms/$1');
$routes->post('/process/cms/(:any)/(:any)', 'Process::cms/$1/$2');
$routes->post('/process/cms/(:any)/(:any)/(:any)', 'Process::cms/$1/$2/$3');

//realisasi
$routes->get('/realisasi', 'HasLogin::realisasi');
$routes->get('/realisasi/(:any)', 'HasLogin::realisasi/$1');
$routes->get('/realisasi/(:any)/(:any)', 'HasLogin::realisasi/$1/$2');
$routes->get('/realisasi/(:any)/(:any)/(:any)', 'HasLogin::realisasi/$1/$2/$3');

$routes->post('/process/realisasi', 'Process::realisasi');
$routes->post('/process/realisasi/(:any)', 'Process::realisasi/$1');
$routes->post('/process/realisasi/(:any)/(:any)', 'Process::realisasi/$1/$2');
$routes->post('/process/realisasi/(:any)/(:any)/(:any)', 'Process::realisasi/$1/$2/$3');

//lpj
$routes->get('/lpj', 'HasLogin::lpj');
$routes->get('/lpj/(:any)', 'HasLogin::lpj/$1');
$routes->get('/lpj/(:any)/(:any)', 'HasLogin::lpj/$1/$2');
$routes->get('/lpj/(:any)/(:any)/(:any)', 'HasLogin::lpj/$1/$2/$3');

$routes->post('/process/lpj', 'Process::lpj');
$routes->post('/process/lpj/(:any)', 'Process::lpj/$1');
$routes->post('/process/lpj/(:any)/(:any)', 'Process::lpj/$1/$2');
$routes->post('/process/lpj/(:any)/(:any)/(:any)', 'Process::lpj/$1/$2/$3');

$routes->get('/form', 'HasLogin::form');
$routes->get('/form/(:any)', 'HasLogin::form/$1');
$routes->get('/form/(:any)/(:any)', 'HasLogin::form/$1/$2');

$routes->get('/organisasi', 'Kesbangpol::organisasi');
$routes->post('/organisasi', 'Kesbangpol::organisasi');
$routes->get('/add_organisasi', 'Kesbangpol::add_organisasi');
$routes->get('/edit_organisasi/(:any)', 'Kesbangpol::edit_organisasi/$1');
$routes->get('/delete_organisasi/(:any)', 'Kesbangpol::delete_organisasi/$1');
$routes->post('/proses_organisasi','Kesbangpol::proses_organisasi');
$routes->post('/proses_edit_organisasi','Kesbangpol::proses_edit_organisasi');
$routes->post('/organisasi/ajaxList', 'Kesbangpol::ajaxList');

$routes->get('/pdf', 'Pdf::pdf');
$routes->get('/pdf/(:any)', 'Pdf::pdf/$1');
$routes->get('/pdf/(:any)/(:any)', 'Pdf::pdf/$1/$2');
$routes->get('/pdf/(:any)/(:any)/(:any)', 'Pdf::pdf/$1/$2/$3');
$routes->get('/pdf/(:any)/(:any)/(:any)/(:any)', 'Pdf::pdf/$1/$2/$3/$4');
$routes->get('/pdf/(:any)/(:any)/(:any)/(:any)/(:any)', 'Pdf::pdf/$1/$2/$3/$4/$5');

$routes->get('/report_hibah', 'Pdf::report_hibah');
$routes->get('/report_hibah/(:any)', 'Pdf::report_hibah/$1');

$routes->get('/report_bansos', 'Pdf::report_bansos');
$routes->get('/report_bansos/(:any)', 'Pdf::report_bansos/$1');

$routes->get('/generate_dnc', 'Pdf::generate_dnc');
$routes->get('/generate_dnc/(:any)', 'Pdf::generate_dnc/$1');
$routes->get('/generate_dnc/(:any)/(:any)', 'Pdf::generate_dnc/$1/$2');
$routes->get('/generate_dnc/(:any)/(:any)/(:any)', 'Pdf::generate_dnc/$1/$2/$3');
$routes->get('/generate_dnc/(:any)/(:any)/(:any)/(:any)', 'Pdf::generate_dnc/$1/$2/$3/$4');

$routes->get('/generate', 'Pdf::generate');





