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


//-------------- TENTANG ------------- //
rOUTE::GET('/about', function() {
	return view('about.index');
});
