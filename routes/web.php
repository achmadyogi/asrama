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
// Penghuni: Mendaftarkan data diri penghuni
Route::post('dashboard/createPenghuni', 'dataPenghuniController@createPenghuni')->name('daftar_penghuni');
// Sekretariat: Buat/edit periode pendaftaran
Route::get('/dashboard/sekretariat/editPeriode', 'sekretariat\editPeriodeController@index')->name('edit_periode');



// ------------- HOME PAGE ----------- //
// Halaman Utama
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


//-------------- MENU ------------- //
route::get('/about', function() {
	return view('about.index');
});

route::get('/asrama', 'AsramaController@index');

// file download
Route::get('/download', 'DownloadController@show_all_downloadable_file');
Route::get('/download/{id}', 'DownloadController@download_file');


//Pendaftaran
//Reguler
Route::get('/daftar_reguler', 'DaftarAsramaController@showFormReguler');
Route::post('/daftar_reguler', 'DaftarAsramaController@daftarReguler')->name('daftar_reguler');