<?php

// --------------- LOGIN DAN PEMBUATAN AKUN --------------- //
Auth::routes();
// Email Verification
Route::get('VerificationEmail','Auth\RegisterController@VerificationEmail')->name('VerificationEmail');
// Send Email Verification Done
Route::get('verify/{email}/{token_verification}','Auth\RegisterController@sendEmailDone')->name('sendEmailDone');
// Resend Email Verification
Route::get('/resendEmail/{email}/{token_verification}','Auth\RegisterController@resendEmail')->name('resendEmail');



// --------------- WEBSITE BLOGS --------------//
Route::get('/pembinaan',function(){
	return view('pembinaan');
});



// --------------- DASHBOARD ----------------- //
// Masuk Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// DASHBOARD PENGHUNI
// Mendaftarkan data diri penghuni
Route::post('dashboard/createPenghuni', 'penghuni\dataPenghuniController@createPenghuni')->name('daftar_penghuni');
// Pendaftaran penghuni
Route::get('dashboard/penghuni/pendaftaran_penghuni', 'penghuni\pendaftaranPenghuniController@index')->name('pendaftaran_penghuni');
// pendaftaran reguler
Route::get('dashboard/penghuni/daftar_reguler', 'penghuni\pendaftaranPenghuniController@showFormReguler')->name('daftar_reguler');

// DASHBOARD SEKRETARIAT
// Buat/edit periode pendaftaran
Route::get('/dashboard/sekretariat/editPeriode', 'sekretariat\editPeriodeController@index')->name('edit_periode');
// Buat tambah periode
Route::post('/tambah_periode','sekretariat\tambahPeriodeController@index')->name('tambah_periode');
// Buat edit periode
Route::post('/edit_periode', 'sekretariat\tambahPeriodeController@editPeriode')->name('edit_lama');



// ------------- HOME PAGE ----------- //
// Halaman Utama
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


//-------------- TENTANG ------------- //
Route::get('/about', function() {
	return view('about.index');
});

route::get('/asrama', 'AsramaController@index');

// file download
Route::get('/download', 'DownloadController@show_all_downloadable_file');
Route::get('/download/{id}', 'DownloadController@download_file');
