<?php
/* 
	===== IMPORTANT NOTES =====
	1. Always use middleware 'SSOCheck' for all application
	2. Use middleware 'SSOForceLogin' for application that use authentication
	===========================
*/


//--------------- WEB v.1.0 ---------------//
Route::get('/old',function(){
	redirect('/old');
});

//--------------- SIM SURAT ---------------//
Route::get('/sim_surat',function(){
    redirect('/sim_surat');
});



//--------------- SEARCH ENGINE ---------------//
Route::post('/search', 'searchController@result')->name('search');
Route::get('/search', 'searchController@index')->middleware('SSOCheck');


//--------------- TRANSLATE ---------------//
Route::get('/translate', function(){
	if(session()->has('en')){
		session()->forget('en');
	}else{
		session(['en' => 'active']);
	}
	return redirect()->back();
})->name('translate')->middleware('SSOCheck');



//--------------- LOGIN DAN PEMBUATAN AKUN ---------------//
// Default akun laravel
Auth::routes();
// Email Verification
Route::get('VerificationEmail','Auth\RegisterController@VerificationEmail')->name('VerificationEmail')->middleware('SSOCheck');
// Send Email Verification Done
Route::get('verify/{email}/{token_verification}','Auth\RegisterController@sendEmailDone')->name('sendEmailDone')->middleware('SSOCheck');
// Resend Email Verification
Route::get('/resendEmail/{email}/{token_verification}','Auth\RegisterController@resendEmail')->name('resendEmail')->middleware('SSOCheck');
// Syarat dan ketentuan
Route::get('/register/SyaratDanKetentuan', function(){
	return view('auth.syarat');
})->name('syaratDanKetentuan')->middleware('SSOCheck');

//--------------- LOGIN SSO ---------------//
// Tes login SSO
Route::get('/loginSSO','Auth\SSOLoginController@SSOLogin')->name('SSOLogin');
// Logout
Route::get('/logoutSSO', 'Auth\SSOLoginController@SSOLogout')->name('SSOLogout');

// --------------- DASHBOARD ----------------- //
// MAIN DASHBOARD
	// Menu utama
	Route::get('/dashboard', 'DashboardController@index')->middleware('SSOForceLogin')->name('dashboard');
	// Form Ganti Username.
	Route::get('/dashboard/ganti_username','dashboard\gantiUsernameController@form')->middleware('SSOForceLogin')->name('ganti_username');
	//Form Ganti Email
	Route::get('/dashboard/ganti_email','dashboard\gantiUsernameController@formEditEmail')->middleware('SSOForceLogin')->name('ganti_email');
	// Action Ganti Username
	Route::post('/dashboard/ganti_username/action','dashboard\gantiUsernameController@index')->name('action_username');
	//Ganti Email
	Route::post('/dashboard/ganti_email/action','dashboard\gantiUsernameController@gantiEmail')->name('action_email');
	// Ganti Password
	Route::get('dashboard/ganti_password','dashboard\passwordController@index')->middleware('SSOForceLogin')->name('password');
	Route::post('dashboard/ganti_password','dashboard\passwordController@gantiPassword')->name('submit_password');
	// Data Diri
	Route::get('dashboard/dataDiri','DashboardController@dataDiri')->middleware('SSOForceLogin')->name('dataDiri');
	// Upload foto profil
	Route::post('/dashboard', 'DashboardController@uploadProfil')->name('foto_profil');

// DASHBOARD PENGHUNI
	// KELENGKAPAN PENGHUNI
		// Mendaftarkan data diri penghuni
		Route::post('dashboard/createPenghuni', 'penghuni\dataPenghuniController@createPenghuni')->name('daftar_penghuni');
		// Pendaftaran penghuni
		Route::get('dashboard/penghuni/pendaftaran_penghuni', 'penghuni\pendaftaranPenghuniController@index')->middleware('SSOForceLogin')->name('pendaftaran_penghuni');
		// Ganti NIM
		Route::get('dashboard/penghuni/nim', 'penghuni\dataPenghuniController@showNIM')->middleware('SSOForceLogin')->name('lihat_nim');
		Route::post('dashboard/penghuni/pergantian_nim', 'penghuni\dataPenghuniController@editNIM')->name('ganti_nim');
		// Ganti Nomor Registrasi
		Route::get('dashboard/penghuni/registrasi', 'penghuni\dataPenghuniController@showRegistrasi')->middleware('SSOForceLogin')->name('lihat_no_reg');
		Route::post('dashboard/penghuni/pergantian_registrasi', 'penghuni\dataPenghuniController@editRegistrasi')->name('ganti_registrasi');
		// Edit Data Penghuni
		Route::get('dashboard/penghuni/edit_info_penghuni', 'penghuni\dataPenghuniController@edit_data_penghuni')->middleware('SSOForceLogin')->name('edit_data_diri');
		Route::post('dashboard/penghuni/save_info_penghuni', 'penghuni\dataPenghuniController@save_data_penghuni')->name('edit_data_penghuni');

	// PENDAFTARAN NON REGULER
		// Form Pendaftaran Non Reguler
		Route::get('dashboard/penghuni/pendaftaran_penghuni/non_reguler', 'penghuni\daftarNonRegulerController@index')->middleware('SSOForceLogin')->name('daftar_non_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/waiting', 'penghuni\daftarNonRegulerController@daftar')->name('form_non_reguler');
		// Edit pendaftaran non reguler
		Route::post('dashboard/penghuni/pendaftaran_penghuni/edit_non_reguler','penghuni\daftarNonRegulerController@editDaftar')->name('edit_daftar_non_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/save_edit_pendaftaran','penghuni\daftarNonRegulerController@saveEditDaftar')->name('submit_edit_non_reguler');
		// Pembatalan pendaftaran non reguler
		Route::post('dashboard/penghuni/pendaftaran_penghuni/batal_pendaftaran_non','penghuni\daftarNonRegulerController@batal')->name('submit_batal_non_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/batal_pendaftaran_verif_non','penghuni\daftarNonRegulerController@batalVerif')->name('batal_verif_non_reguler');
		// Generate surat perjanjian
		Route::post('dashboard/penghuni/pendaftaran_penghuni/generate_file_non_reguler', 'DownloadController@SuratPerjanjianNonReguler')->name('SuratPerjanjianNonReguler');

	// PENDAFTARAN REGULER
		// Form Pendaftaran Reguler
		Route::get('dashboard/penghuni/pendaftaran_penghuni/reguler', 'penghuni\daftarRegulerController@index')->middleware('SSOForceLogin')->name('daftar_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/waiting_reguler', 'penghuni\daftarRegulerController@daftar')->name('form_reguler');
		// edit pendaftaran reguler
		Route::post('dashboard/penghuni/pendaftaran_penghuni/edit_pendaftaran', 'penghuni\daftarRegulerController@editDaftar')->name('edit_daftar_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/save_edit_pendafataran_reg', 'penghuni\daftarRegulerController@saveEditDaftar')->name('submit_edit_reguler');
		// Pembatalan pendaftaran reguler
		Route::post('dashboard/penghuni/pendaftaran_penghuni/batal_pendafataran_reg', 'penghuni\daftarRegulerController@batal')->name('submit_batal_reguler');
		Route::post('dashboard/penghuni/pendaftaran_penghuni/batal_pendafataran_verif_reg', 'penghuni\daftarRegulerController@batalVerif')->name('batal_verif_reguler');

	// PEMBAYARAN
		// Form pembayaran host to host
		Route::get('dashboard/penghuni/FormPembayaran','penghuni\pembayaranPenghuniController@form')->middleware('SSOForceLogin')->name('pembayaran_penghuni');
		Route::post('dashboard/penghuni/ConfirmPembayaran','penghuni\pembayaranPenghuniController@index')->name('submit_pembayaran');
		// Form pembayaran ke rekening penampungan
		Route::get('dashboard/penghuni/FormPembayaranRekening','penghuni\pembayaranPenghuniController@formRekening')->middleware('SSOForceLogin')->name('pembayaran_penghuni_rekening');
		Route::post('dashboard/penghuni/ConfirmPembayaranRekening','penghuni\pembayaranPenghuniController@indexRekening')->name('submit_pembayaran_rekening');

	// PENANGGUHAN
		// Form penangguhan
		Route::get('dashboard/penghuni/FormPenangguhan','penghuni\pembayaranPenghuniController@formPenangguhan')->middleware('SSOForceLogin')->name('penangguhan_penghuni');
		Route::post('dashboard/penghuni/ConfirmPenangguhan','penghuni\pembayaranPenghuniController@indexPenangguhan')->name('submit_penangguhan_penghuni');

	// LAYANAN DAN CHECKOUT
		// Buat pdf surat penerimaan
		Route::get('dashboard/penghuni/download','DownloadController@IndexFile')->middleware('SSOForceLogin')->name('generate_file');
		// Buat pdf surat perjanjian
		Route::get('dashboard/penghuni/download/surat_perjanjian','DownloadController@GenerateSuratPerjanjian')->middleware('SSOForceLogin')->name('generate_file_perjanjian');
		// Buat pdf surat penangguhan
		Route::get('dashboard/penghuni/download/formulir_penangguhan','DownloadController@GenerateFormulirPenangguhan')->middleware('SSOForceLogin')->name('generate_file_penangguhan');
		// Pengajuan pindah kamar
		Route::get('/dashboard/penghuni/pengajuan_pindah_kamar', 'penghuni\PindahKamarController@index')->middleware('SSOForceLogin')->name('pengajuan_pindah_kamar');
		// Ajax pengajuan pindah kamar
		Route::post('pindahKamar', function(){
			return view('dashboard.penghuni.ajax.PengajuanPindahKamar');
		})->name('ajax_pindah_kamar');
		// Pengajuan keluar asrama
		Route::post('dashboard/penghuni/download/formulir_keluar_asrama','DownloadController@GenerateFormulirKeluarAsrama')->name('generate_file_keluar_asrama');
		Route::get('dashboard/penghuni/form_pengajuan_keluar', 'admin\CheckoutController@FormPengajuanKeluar')->middleware('SSOForceLogin')->name('form_pengajuan_keluar');
		Route::post('dashboard/penghuni/action_pengajuan_keluar', 'admin\CheckoutController@SavePengajuanKeluar')->name('action_pengajuan_keluar');

// DASHBOARD SEKRETARIAT
	// PERIODE PENDAFTARAN
		// Buat/edit periode pendaftaran
		Route::get('/dashboard/sekretariat/editPeriode', 'sekretariat\editPeriodeController@index')->middleware('SSOForceLogin')->name('edit_periode');
		// Buat tambah periode
		Route::post('/tambah_periode','sekretariat\tambahPeriodeController@index')->name('tambah_periode');
		// Buat edit periode
		Route::post('/edit_periode', 'sekretariat\tambahPeriodeController@editPeriode')->name('edit_lama');

	// PENERIMAAN REGULER
		// Validasi pendaftaran reguler
		Route::get('/dashboard/sekretariat/validasi_pendaftaran_reguler', 'sekretariat\validasiPendaftaranController@indexReguler')->middleware('SSOForceLogin')->name('validasi_pendaftaran_reguler');
		// Pencarian pendaftaran reguler
		Route::get('/dashboard/sekretariat/validasi_pendaftaran_reguler/search', 'sekretariat\validasiPendaftaranController@searchReguler')->middleware('SSOForceLogin')->name('search_reguler');
		// Validasi pendaftaran reguler otomatis
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitReguler', 'sekretariat\validasiPendaftaranController@inboundReg')->name('inboundReg_approval');
		// Pemeriksaan alokasi reguler ajax kamar baru
		Route::get('/dashboard/sekretariat/validasi_pendaftaran/availabilityReguler', 'sekretariat\validasiPendaftaranController@alokasi_reg')->name('alokasi_reg');
		// Pemeriksaan alokasi reguler ajax kamar lama
		Route::get('/dashboard/sekretariat/validasi_pendaftaran_kamar_lama', 'sekretariat\validasiPendaftaranController@alokasi_reg_lama_matic')->name('alokasi_reg_lama_matic');
		// validasi pendaftaran manual reguler
		Route::post('dashboard/sekretariat/pembayaran/submitAlokasiManualReguler','sekretariat\validasiPendaftaranController@AlokasiManualReguler')->name('submit_alokasi');
		// blacklist reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitBlacklistReguler', 'sekretariat\validasiPendaftaranController@blacklist')->name('submit_blacklist');
		// waiting list reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitWaitingListReguler','sekretariat\validasiPendaftaranController@waitingList')->name('submit_list');
		// Tidak lolos reguler
		Route::post('dashboard/sekretariat/validasi_pendaftaran/submitTakLolos','sekretariat\validasiPendaftaranController@taklolos')->name('taklolos');
		//Ajax untuk pemilihan kamar
		Route::get('/json_gedung','sekretariat\validasiPendaftaranController@AjaxGedung')->name('json_gedung');
		Route::get('/json_kamar','sekretariat\validasiPendaftaranController@AjaxKamar')->name('json_kamar');
		//Ajax untuk mengeceklanjut periode
		Route::get('/json_cek_lanjut_periode','sekretariat\validasiPendaftaranController@AjaxLanjutPeriode')->name('json_lanjut_periode');
		// Daftar Ulang Reguler
		Route::get('/dashboard/sekretariat/daftarUlang','sekretariat\daftarUlangController@indexReguler')->middleware('SSOForceLogin')->name('daftarUlang');
		// Submit daftar ulang reguler
		Route::post('/dashboard/sekretariat/daftarUlang/submitDaful', 'sekretariat\daftarUlangController@submitDaful')->middleware('SSOForceLogin')->name('submitDaful');
		// Pencarian daftar ulang reguler
		Route::get('/dashboard/sekretariat/daftarUlang/ajax', 'sekretariat\daftarUlangController@ajaxCariDaful')->name('ajax_daful');
		// Next Prev Daful
		Route::get('/dashboard/sekretariat/daftarUlang/nexrPrev', 'sekretariat\daftarUlangController@nextPrevDaful')->name('nextPrevDaful');

	// PENERIMAAN NON REGULER
		// Validasi pendaftaran non reguler
		Route::get('/dashboard/sekretariat/validasi_pendaftaran', 'sekretariat\validasiPendaftaranController@indexNonReguler')->middleware('SSOForceLogin')->name('validasi_pendaftaran_non_reguler');
		// Pencarian pendaftaran non reguler
		Route::get('/dashboard/sekretariat/validasi_pendaftaran/search', 'sekretariat\validasiPendaftaranController@searchNonReguler')->middleware('SSOForceLogin')->name('search_non_reguler');
		// Validasi pendaftaran manual non reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/nonReguler_manual','sekretariat\validasiPendaftaranController@alokasiManualNonReguler')->name('inboundNonReg_manual');
		// Validasi pendaftaran otomatis non reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitNonReguler', 'sekretariat\validasiPendaftaranController@inboundNonReg')->name('inboundNonReg_approval');
		// blacklist non reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitBlacklistNonReguler', 'sekretariat\validasiPendaftaranController@blacklistNon')->name('submit_blacklist_non');
		// waiting list non reguler
		Route::post('/dashboard/sekretariat/validasi_pendaftaran/submitWaitingListNonReguler','sekretariat\validasiPendaftaranController@waitingListNon')->name('submit_list_non');
		// Tidak lolos non reguler
		Route::post('dashboard/sekretariat/validasi_pendaftaran/submitTakLolosNon','sekretariat\validasiPendaftaranController@taklolosNon')->name('taklolos_non');
		// Daftar Ulang Non Reguler
		Route::get('/dashboard/sekretariat/daftarUlangNonReguler','sekretariat\daftarUlangController@indexNonReguler')->middleware('SSOForceLogin')->name('daftarUlangNon');
		// Submit daftar ulang non reguler
		Route::post('/dashboard/sekretariat/daftarUlangNonReguler', 'sekretariat\daftarUlangController@submitDafulNon')->middleware('SSOForceLogin')->name('submitDafulNon');
		// Pencarian daftar ulang reguler
		Route::get('/dashboard/sekretariat/daftarUlang/ajaxNon', 'sekretariat\daftarUlangController@ajaxCariDafulNon')->name('ajax_daful_non');
		// Next Prev Daful
		Route::get('/dashboard/sekretariat/daftarUlang/nexrPrevNon', 'sekretariat\daftarUlangController@nextPrevDafulNon')->name('nextPrevDafulNon');

	// PEMBAYARAN
		// Halaman validasi Pembayaran
		Route::get('dashboard/sekretariat/pembayaran/validasiPembayaran','sekretariat\ValidasiPembayaranController@IndexReguler')->middleware('SSOForceLogin')->name('validasi_pembayaran');
		// Validasi pendaftaran reguler
		Route::post('dashboard/sekretariat/pembayaran/submitPembayaranReguler','sekretariat\ValidasiPembayaranController@SubmitPembayaranReguler')->name('submit_pembayaran_reguler');
		// Validasi penangguhan reguler
		Route::post('dashboard/sekretariat/pembayaran/submitPenangguhanReguler','sekretariat\ValidasiPembayaranController@SubmitPenangguhanReguler')->name('submit_penangguhan_reguler');
		// Penolakan pembayaran
		Route::post('dashboard/sekretariat/pembayaran/tolakPembayaran','sekretariat\ValidasiPembayaranController@tolakPembayaran')->name('tolak_bayar');
		// Next previous tabel validasi pembayaran
		Route::get('dashboard/sekretariat/pembayaran/nextPrev','sekretariat\ValidasiPembayaranController@nextPrev')->name('nextPrev');
		// ajax pembayaran
		Route::post('ajax_bayar', function(){
			return view('dashboard.sekretariat.ajax.cariPembayaran');
		})->name('ajax_bayar');

	// KESEKRETARIATAN
		// Edit pindah kamar
		Route::get('/dashboard/sekretariat/edit_pindah_kamar','sekretariat\editPindahKamarController@index')->middleware('SSOForceLogin')->name('edit_pindah_kamar');
		// Pencarian Pindah Kamar
		Route::post('/dashboard/sekretariat/pencarian_pindah_kamar','sekretariat\editPindahKamarController@pencarian')->name('pencarian_pindah_kamar');
		// Input Pindah Kamar
		Route::post('/dashboard/sekretariat/edit_pindah_kamar','sekretariat\editPindahKamarController@input')->name('input_ubah_kamar_reguler');
		// ajax pindah kamar
		Route::post('gedungX',function(){
			return view('dashboard.sekretariat.ajax.PindahKamarRegG');
		})->name('gedungX');
		Route::post('kamarX',function(){
			return view('dashboard.sekretariat.ajax.PindahKamarRegK');
		})->name('kamarX');
		// Periksa penghuni aktif
		Route::get('dashborad/sekretariat/periksa_penghuni_aktif','sekretariat\periksaPenghuniAktifController@index')->middleware('SSOForceLogin')->name('periksa_penghuni_aktif');
		Route::post('dashboard/sekretariat/periksa_penghuni_aktif','sekretariat\periksaPenghuniAktifController@periksaPenghuniAktif')->name('periksa_aktif');
		// Periksa penghuni keseluruhan
		Route::get('dashboard/sekretariat/periksa_penghuni_keseluruhan', 'sekretariat\PeriksaDataPenghuniController@index'
		)->middleware('SSOForceLogin')->name('Data_Penghuni_Keseluruhan');
		Route::post('dashboard/sekretariat/periksa_penghuni_keseluruhan','sekretariat\periksaPenghuniAktifController@periksaPenghuniAll')->name('submit_Data_Penghuni_Keseluruhan');
		// Ajax periksa penghuni keseluruhan
		Route::post('ajax_penghuni_all', function(){
			return view('dashboard.sekretariat.ajax.cariPenghuniAll');
		})->name('ajax_penghuni_all');

// DASHBOARD PENGELOLA
// Untuk melakukan edit kamar
Route::get('/dashboard/pengelola/edit_kamar','pengelola\editKamarController@index')->middleware('SSOForceLogin')->name('edit_kamar');
Route::post('/dashboard/pengelola/submit_edit_kamar','pengelola\editKamarController@editKamar')->name('submit_edit_kamar');
Route::post('/dashboard/pengelola/pencarian_kamar','pengelola\editKamarController@pencarianKamar')->name('pencarianKamar');

// DASHBOARD KEUANGAN
	// Untuk menunjukkan halaman statistik keuangan
	Route::get('/dashboard/keuangan/statistikKeuangan','keuangan\statistikKeuanganController@index')->middleware('SSOForceLogin')->name('stat_keuangan');
	Route::get('/dashboard/keuangan/cek_pembayaran','keuangan\cekPembayaranController@index')->middleware('SSOForceLogin')->name('cekPembayaran');
	// Ajax keuangan
	Route::post('ajax_keuangan',function(){
		return view('dashboard.keuangan.ajax.ajax_bulanan');
	})->name('ajax_chart');
	Route::get('ajax_table_keuangan', 'keuangan\cekPembayaranController@nextPrevTabelBayar')->name('show_bayar_kategori');
	// Filter pembayaran
	Route::post('/dashboard/keuangan/resultPembayaran', 'keuangan\cekPembayaranController@tabelBayar')->name('filter_pembayaran');
	// Ajax cari pembayaran penghuni
	Route::get('cariBayar', 'keuangan\cekPembayaranController@cariBayarAjax')->name('cariBayar');

//DASHBOARD EKSTERNAL
	//Untuk menunjukkan form pendaftaran mahasiswa asig oleh IRO
	Route::get('/dashboard/eksternal/pendaftaran_iro', 'eksternal\PendaftaranEksternalController@PendaftaranMahasiswaAsing')->middleware('SSOForceLogin')->name('pendaftaran_asing_iro');
	Route::post('/dashboard/eksternal/pendaftaran_iro/save', 'eksternal\PendaftaranEksternalController@SavePendaftaranMahasiswaAsing')->name('save_pendaftaran_mahasiswa_asing');
	Route::get('/dashboard/eksternal/pendaftaran_iro/cek', 'eksternal\PendaftaranEksternalController@CekPendaftaranMahasiswaAsing')->middleware('SSOForceLogin')->name('cek_pendaftaran_asing');
	Route::post('/dashboard/eksternal/pedaftaran_iro/hasil_pencarian', 'eksternal\PendaftaranEksternalController@TabelCekAsing')->name('pencarian_pendaftaran_asing');
	Route::post('ajax_table_pendaftaran_iro', function(){
		return view('dashboard.eksternal.ajax.ajax_tabel_pendaftaran_iro');
	})->name('show_tabel_pendaftaran_iro');

// DASHBOARD ADMIN
	// Menambah dan edit admin
	Route::get('/users/grid', 'admin\UsersController@grid')->middleware('SSOForceLogin');
	Route::resource('/users', 'admin\UsersController');
	// Unggah file untuk bisa didownload
	Route::get('/upload/view', 'DownloadController@upload')->middleware('SSOForceLogin')->name('show_upload');
	Route::post('/upload/save', 'DownloadController@saveUpload')->name('upload_file');
	// file download
	Route::get('/download', 'DownloadController@show_all_downloadable_file')->middleware('SSOForceLogin');
	Route::get('/download/{id}', 'DownloadController@download_file')->middleware('SSOForceLogin');
	// Penghuni
	Route::post('mahasiswa',function(){
		return view('dashboard.penghuni.ajax.pendaftaran');
	});
	Route::post('fakultas','ajax\fakultasController@index');

	// KELUAR ASRAMA DAN CHECKOUT
		// Pengajuan keluar asrama
    	Route::get('dashboard/admin/list_pengajuan_keluar','admin\CheckoutController@ListPengajuanKeluarReguler')->middleware('SSOForceLogin')->name('list_pengajuan_keluar');
    	// Pengajuan keluar asrama reguler
    	Route::post('dashboard/admin/accept_pengajuan_keluar_reguler', 'admin\CheckoutController@AcceptPengajuanKeluarReguler')->name('accept_pengajuan_keluar_reguler');
    	Route::post('dashboard/admin/reject_pengajuan_keluar_reguler', 'admin\CheckoutController@RejectPengajuanKeluarReguler')->name('reject_pengajuan_keluar_reguler');
    	// Pengajuan keluar asrama non reguler
    	Route::post('dashboard/admin/accept_pengajuan_keluar_non_reguler', 'admin\CheckoutController@AcceptPengajuanKeluarNonReguler')->name('accept_pengajuan_keluar_non_reguler');
    	Route::post('dashboard/admin/reject_pengajuan_keluar_non_reguler', 'admin\CheckoutController@RejectPengajuanKeluarNonReguler')->name('reject_pengajuan_keluar_non_reguler');
    	// Tabel Daftar Checkout
    	Route::get('dashboard/admin/daftar_checkout','admin\CheckoutController@PeriksaCheckout')->middleware('SSOForceLogin')->name('periksa_daftar_checkout');
		Route::post('dashboard/admin/filter_daftar_checkout','admin\CheckoutController@TabelPeriksaCheckout')->name('filter_daftar_checkout');
		// Checkout Otomatis
    	Route::get('dashboard/admin/checkout_otomatis','admin\CheckoutController@HalamanCheckoutOtomatis')->middleware('SSOForceLogin')->name('halaman_checkout_otomatis');
    	Route::post('dashboard/admin/filter_checkout_otomatis','admin\CheckoutController@FilterCheckoutOtomatis')->name('filter_checkout_otomatis');
    	Route::post('dashboard/admin/checkout_semua_otomatis', 'admin\CheckoutController@TombolCheckoutOtomatis')->name('tombol_checkout_otomatis');


// --------------- HOME PAGE --------------- //
// Halaman Utama
Route::get('/', 'HomeController@index')->middleware('SSOCheck');
Route::get('/home', 'HomeController@index')->name('home')->middleware('SSOCheck');


// --------------- TENTANG --------------- //
// Penjelasan umum asrama
Route::get('/about', function() {
	return view('about.index');
})->middleware('SSOCheck');
// Struktur organisasi
Route::get('/about/struktur_organisasi', function(){
	return view('about.struktur');
})->middleware('SSOCheck');



// --------------- PEMBINAAN --------------- //
Route::get('/pembinaan',function(){
	redirect('/pembinaan');
});



// ------------ INFORMASI ------------//
// Halaman informasi
Route::get('/informasi/pendaftaran','informasi\pendaftaranController@index')->name('info')->middleware('SSOCheck');
// BERITA
	// Menampilkan berita
	Route::get('/berita/{id_berita}', 'BeritaController@showBerita')->middleware('SSOCheck');
	Route::get('/berita', 'BeritaController@index')->middleware('SSOCheck');
	// Menambahkan berita
	Route::post('/tambahBerita', 'BeritaController@addBerita')->middleware('SSOForceLogin')->name('tambah_berita');
	Route::get('/showTambahBerita', 'BeritaController@showAddBerita')->middleware('SSOForceLogin')->name('show_tambah_berita');

// PENGUMUMAN
	// Menampilkan pengumuman
	Route::get('/pengumuman/{id_pengumuman}', 'PengumumanController@showPengumuman')->middleware('SSOCheck');
	Route::get('/pengumuman', 'PengumumanController@index')->name('pengumuman')->middleware('SSOCheck');
	// Menambahkan pengumuman
	Route::post('/tambahPengumuman', 'PengumumanController@addPengumuman')->middleware('SSOForceLogin')->name('tambah_pengumuman');
	Route::get('/showTambahPengumuman', 'PengumumanController@showAddPengumuman')->middleware('SSOForceLogin')->name('show_tambah_pengumuman');

// JADWAL KEGIATAN
	// Buka halaman jadwal
	Route::get('/admin/jadwalKegiatan','jadwalController@index')->middleware('SSOForceLogin')->name('show_tambah_jadwal');
	// Tambahkan jadwal
	Route::post('/admin/addJadwalKegiatan', 'jadwalController@addJadwal')->middleware('SSOForceLogin')->name('addJadwal');

// FREQUENTLY ASKED QUESTION
Route::get('/faq', 'informasi\faqController@index')->name('faq')->middleware('SSOCheck');

// PETA
Route::get('/informasi/peta', 'informasi\petaController@index')->name('peta')->middleware('SSOCheck');



// --------------- ASRAMA --------------- //
route::get('/asrama', 'AsramaController@index')->name('asrama')->middleware('SSOCheck');



// --------------- TEST --------------- //
Route::get('test','testController@index')->middleware('SSOForceLogin');
// hasil ajax
Route::post('/testResult', 'testController@result')->name('testResult')->middleware('SSOCheck');
//T Membuat pdf
Route::post('/createPDF', 'testController@createPDF')->name('createPDF')->middleware('SSOCheck');
// Migrasi
Route::post('/testMove', 'testController@testMove')->name('testMove')->middleware('SSOCheck');
