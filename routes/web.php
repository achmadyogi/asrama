<?php

// --------------- LOGIN DAN PEMBUATAN AKUN --------------- //
Auth::routes();
// Email Verification
Route::get('VerificationEmail','Auth\RegisterController@VerificationEmail')->name('VerificationEmail');
// Send Email Verification Done
Route::get('verify/{email}/{token_verification}','Auth\RegisterController@sendEmailDone')->name('sendEmailDone');
// Resend Email Verification
Route::get('/resendEmail/{email}/{token_verification}','Auth\RegisterController@resendEmail')->name('resendEmail');



// --------------- DASHBOARD ----------------- //
// Masuk Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// DASHBOARD PENGHUNI
// Mendaftarkan data diri penghuni
Route::post('dashboard/createPenghuni', 'penghuni\dataPenghuniController@createPenghuni')->name('daftar_penghuni');
// Pendaftaran penghuni
Route::get('dashboard/penghuni/pendaftaran_penghuni', 'penghuni\pendaftaranPenghuniController@index')->name('pendaftaran_penghuni');

// Form Pendaftaran Non Reguler
Route::get('dashboard/penghuni/pendaftaran_penghuni/non_reguler', 'penghuni\daftarNonRegulerController@index')->name('daftar_non_reguler');
// Pendaftaran Non Reguler
Route::post('dashboard/penghuni/pendaftaran_penghuni/waiting', 'penghuni\daftarNonRegulerController@daftar')->name('form_non_reguler');

// pendaftaran reguler
Route::get('dashboard/penghuni/daftar_reguler', 'penghuni\pendaftaranPenghuniController@showFormReguler')->name('daftar_reguler');
Route::post('dashboard/penghuni/daftar_reguler', 'penghuni\pendaftaranPenghuniController@daftarReguler')->name('daftar_reguler');

// DASHBOARD SEKRETARIAT
// Buat/edit periode pendaftaran
Route::get('/dashboard/sekretariat/editPeriode', 'sekretariat\editPeriodeController@index')->name('edit_periode');
// Buat tambah periode
Route::post('/tambah_periode','sekretariat\tambahPeriodeController@index')->name('tambah_periode');
// Buat edit periode
Route::post('/edit_periode', 'sekretariat\tambahPeriodeController@editPeriode')->name('edit_lama');
// Validasi Pendaftaran
Route::get('/dashboard/sekretariat/validasi_pendaftaran', 'sekretariat\validasiPendaftaranController@index')->name('validasi_pendaftaran');
// Persetujuan validasi, mengenerate kamar, dan jumlah tagihan
Route::post('/dashboard/sekretariat/validasi_pendaftaran', 'sekretariat\validasiPendaftaranController@inboundNonReg')->name('inboundNonReg_approval');



// ------------- HOME PAGE ----------- //
// Halaman Utama
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


//-------------- TENTANG ------------- //
Route::get('/about', function() {
	return view('about.index');
});

Route::get('/about/struktur_organisasi', function(){
	return view('about.struktur');
});


// ------------ PEMBINAAN -------------//
Route::get('/pembinaan',function(){
	return view('pembinaan.pembinaan');
});


// ------------ INFORMASI ------------//
Route::get('/informasi/pendaftaran','informasi\pendaftaranController@index');

route::get('/asrama', 'AsramaController@index');

// file download
Route::get('/download', 'DownloadController@show_all_downloadable_file');
Route::get('/download/{id}', 'DownloadController@download_file');



// -----TEST----------
Route::get('test', function(){
	return view('test');
});
Route::post('test','testController@index');

//ADMIN
Route::get('/users/grid', 'admin\UsersController@grid');
Route::resource('/users', 'admin\UsersController');

//Berita
Route::get('/berita/{id_berita}', 'BeritaController@showBerita');
Route::get('/berita', 'BeritaController@index');

//Pengumuman
Route::get('/pengumuman/{id_pengumuman}', 'PengumumanController@showPengumuman');
Route::get('/pengumuman', 'PengumumanController@index');

