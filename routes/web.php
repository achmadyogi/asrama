<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'HomeController@load_all_pengumuman_welcome');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/editprofile', 'UserController@editprofile')->name('editprofile');
Route::post('editprofile', 'UserController@saveprofile')->name('editprofile');
Route::get('/pengumuman', 'HomeController@load_all_pengumuman');
Route::get('/berita', 'HomeController@load_all_berita');

// file download
Route::get('/download', 'DownloadController@show_all_downloadable_file');
Route::get('/download/{id}', 'DownloadController@download_file');

/* generate file */
Route::get('/download/{id}/form', 'DownloadController@generateDocument');

/* upload file */
Route::get('/formupload', 'DownloadController@show_uploadform');
Route::post('/upload', 'DownloadController@upload');

/* Home */
Route::get('/home', 'HomeController@load_all_pengumuman_welcome');

/* penghuni info */
Route::get('/edit_penghuni_info', 'UserController@edit_penghuni_info')->name('edit_penghuni_info');
Route::post('/edit_penghuni_info', 'UserController@save_penghuni_info')->name('edit_penghuni_info');

// Profile
Route::get('/myprofile', 'UserController@viewprofile')->name('myprofile');
Route::get('/viewprofile/{id_user}', 'UserController@viewprofile');
Route::get('/managenim', 'UserController@managenim')->name('managenim');
Route::post('/managenim', 'UserController@addnim')->name('addnim');

// Pendaftaran
Route::get('/pendaftaran', 'PengelolaanPendaftaranController@index')->name('pendaftaran');
Route::post('/pendaftaran', 'PengelolaanPendaftaranController@accept')->name('pendaftaran');

// Blacklist
Route::get('/blacklists/grid', 'BlacklistsController@grid');
Route::patch('/blacklists', 'BlacklistsController@update');
Route::get('/blacklists/{user}/add', 'BlacklistsController@add');
Route::resource('/blacklists', 'BlacklistsController');

// Asrama
Route::get('/asrama', 'AsramaController@index');
Route::get('/create_asrama', 'AsramaController@showCreateAsramaForm');
Route::post('/create_asrama', 'AsramaController@createAsrama');
Route::get('/edit_asrama/{id_asrama}', 'AsramaController@showEditAsramaForm');
Route::post('/edit_asrama', 'AsramaController@editAsrama');
Route::post('/delete_asrama/{id_asrama}', 'AsramaController@deleteAsrama');
Route::get('/asrama/{id_asrama}', 'AsramaController@detailAsrama');
Route::get('/asrama/{id_asrama}/create_gedung', 'AsramaController@showCreateGedungForm');
Route::post('/asrama/{id_asrama}/create_gedung', 'AsramaController@createGedung');
Route::get('/asrama/{id_asrama}/edit_gedung/{id_gedung}', 'AsramaController@showEditGedungForm');
Route::post('/asrama/{id_asrama}/edit_gedung/{id_gedung}', 'AsramaController@editGedung');
Route::post('/asrama/{id_asrama}/delete_gedung/{id_gedung}', 'AsramaController@deleteGedung');
Route::get('/asrama/{id_asrama}/{id_gedung}/create_kamar', 'AsramaController@showFormCreateKamar');
Route::post('/asrama/{id_asrama}/{id_gedung}/create_kamar', 'AsramaController@createKamar');
Route::get('/asrama/{id_asrama}/{id_gedung}/edit_kamar/{id_kamar}', 'AsramaController@showEditKamarForm');
Route::post('/asrama/{id_asrama}/{id_gedung}/edit_kamar/{id_kamar}', 'AsramaController@editKamar');
Route::post('/asrama/{id_asrama}/{id_gedung}/delete_kamar/{id_kamar}', 'AsramaController@deleteKamar');

// About
Route::get('/about', function () {
	return view('about.index');
});

// Organisasi
Route::get('/organisasi', function() {
	return view('organisasi.index');
});

// Pendaftaran Asrama
Route::get('/daftar_reguler', 'DaftarAsramaController@showFormReguler');
Route::post('/daftar_reguler', 'DaftarAsramaController@daftarReguler')->name('daftar_reguler');
Route::get('/edit_daftar_reguler/{id_daftar}', 'DaftarAsramaController@showFormEditReguler');
Route::post('/edit_daftar_reguler/{id_daftar}', 'DaftarAsramaController@editReguler');
Route::post('/delete_daftar_reguler/{id_daftar}', 'DaftarAsramaController@deleteReguler')->name('delete_reguler');
Route::get('/daftar_non_reguler', 'DaftarAsramaController@showFormNonReguler');
Route::post('/daftar_non_reguler', 'DaftarAsramaController@daftarNonReguler')->name('daftar_non_reguler');
Route::get('/edit_daftar_non_reguler/{id_daftar}', 'DaftarAsramaController@showFormEditNonReguler');
Route::post('/edit_daftar_non_reguler/{id_daftar}', 'DaftarAsramaController@editNonReguler');
Route::post('/delete_daftar_non_reguler/{id_daftar}', 'DaftarAsramaController@deleteNonReguler')->name('delete_non_reguler');

//
Route::get('/users/grid', 'UsersController@grid');
Route::resource('/users', 'UsersController');

/* admin CRUD pengumuman */
Route::get('/adminpengumuman/grid', 'AdminpengumumanController@grid');
Route::put('/adminpengumuman', 'AdminpengumumanController@update');
Route::resource('/adminpengumuman', 'AdminpengumumanController');

/* admin CRUD berita */
Route::get('/adminberita/grid', 'AdminberitaController@grid');
Route::put('/adminberita', 'AdminberitaController@update');
Route::resource('/adminberita', 'AdminberitaController');

/* periode */
Route::get('/periodes/grid', 'PeriodesController@grid');
Route::patch('/periodes', 'PeriodesController@update');
Route::resource('/periodes', 'PeriodesController');

/* alokasi otomatis */
Route::get('/autoalokasi', 'autoAlokasiController@showForm');
Route::post('/autoalokasi/generate', 'autoAlokasiController@generate');

/* alokasi */
Route::get('/alokasi/grid', 'AlokasiController@grid');
Route::get('/alokasi/grid2', 'AlokasiController@grid2');
Route::patch('/alokasi', 'AlokasiController@update');
Route::resource('/alokasi', 'AlokasiController');

/* alokasi non reguler */
Route::get('/alokasinonreguler/grid', 'AlokasiNonRegulerController@grid');
Route::get('/alokasinonreguler/grid2', 'AlokasiNonRegulerController@grid2');
Route::patch('/alokasinonreguler', 'AlokasiNonRegulerController@update');
Route::resource('/alokasinonreguler', 'AlokasiNonRegulerController');

/* Keluar */
Route::get('/requestkeluar/reguler/{id_pendaftaran}', 'KeluarAsramaController@showFormReguler');
Route::get('/requestkeluar/nonreguler/{id_pendaftaran}', 'KeluarAsramaController@showFormNonReguler');
Route::post('/requestkeluar/{jenis_kepenghunian}/{id_pendaftaran}', 'KeluarAsramaController@createRequest');
Route::get('/managerequestkeluar', 'KeluarAsramaController@manageRequest');
Route::post('/managerequestkeluar', 'KeluarAsramaController@processRequest');

/* Pindah */
Route::get('/requestpindah/reguler/{id_pendaftaran}', 'PindahAsramaController@showFormReguler');
Route::get('/requestpindah/nonreguler/{id_pendaftaran}', 'PindahAsramaController@showFormNonReguler');
Route::post('/requestpindah/{jenis_kepenghunian}/{id_pendaftaran}', 'PindahAsramaController@createRequest');
Route::get('/managerequestpindah', 'PindahAsramaController@manageRequest');
Route::post('/managerequestpindah', 'PindahAsramaController@processRequest');

// admin
Route::post('/show_tombol_lanjut_keluar', 'AdminController@showTombolLanjutKeluar');
Route::post('/hide_tombol_lanjut_keluar', 'AdminController@hideTombolLanjutKeluar');
Route::post('/accept/{status}/{id_daftar}', 'AdminController@accept');
Route::get('/periode_asal', 'AdminController@formPeriodeAsal');
Route::post('/periode_asal', 'AdminController@postPeriodeAsal');
Route::get('/periode_akhir/{tanggal_masuk}/{tanggal_keluar}', 'AdminController@formPeriodeAkhir');
Route::post('/perpanjang_periode', 'AdminController@perpanjangPeriode');

/* tarif */
Route::get('/tarif', 'tarifController@index');
Route::get('/admintarif/grid', 'AdmintarifController@grid');
Route::put('/admintarif', 'AdmintarifController@update');
Route::resource('/admintarif', 'AdmintarifController');

/* permohonan pindah kamar */
Route::get('/permohonan_pindahs/grid', 'Permohonan_pindahsController@grid');
Route::resource('/permohonan_pindahs', 'Permohonan_pindahsController');

// Lanjut / Keluar dari periode
Route::post('/keluar_periode', 'UserController@keluarPeriode');
Route::post('/lanjut_periode/{id_periode}', 'UserController@lanjutPeriode');
Route::get('/manage_lanjut_periode', 'AdminController@indexLanjutPeriode');
Route::get('/form_lanjut_periode', 'AdminController@createFormLanjutPeriode');
Route::post('/create_lanjut_periode', 'AdminController@createLanjutPeriode');
Route::post('/delete_lanjut_periode/{periode_asal}/{periode_akhir}', 'AdminController@deleteLanjutPeriode');

/* Kerusakan kamar */
Route::get('/kerusakan_kamar/grid', 'KerusakanKamarController@grid');
Route::patch('/kerusakan_kamar', 'KerusakanKamarController@update');
Route::get('/kerusakan_kamar/{id_kamar}/add', 'KerusakanKamarController@add');
Route::resource('/kerusakan_kamar', 'KerusakanKamarController');

/* Check In Check Out */
Route::get('/manage/{jenisPenghuni}', 'CheckInController@showList');
Route::post('/manage/{jenisPenghuni}', 'CheckInController@showSearch');
Route::get('/manage/{jenisPenghuni}/{id_daftar}', 'CheckInController@viewDetail');
Route::post('/manage/{jenisPenghuni}/{id_daftar}', 'CheckInController@process');
Route::get('print/{jenisPenghuni}/{id_daftar}', 'CheckInController@printCheckIn');
Route::get('printOut/{jenisPenghuni}/{id_daftar}', 'CheckInController@printCheckOut');
