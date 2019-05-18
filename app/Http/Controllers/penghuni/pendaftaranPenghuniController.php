<?php

namespace App\Http\Controllers\penghuni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Asrama;
use App\User_penghuni;
use App\Daftar_asrama_reguler;
use App\User;
use App\User_nim;
use App\Prodi;
use Session;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use Illuminate\Support\Facades\DB;
use ITBdorm;
use DormAuth;

class pendaftaranPenghuniController extends Controller
{
    public function index(){
    	// Mendapatkan list pendaftaran reguler
		$reguler = ITBdorm::DataReguler(DormAuth::User()->id);
		// Hitung total reguler
		$countReg = 0;
		foreach ($reguler as $reg) {
			$countReg += 1;
		}
		// Mendapatkan list pendaftaran non reguler
		$nonReguler = ITBdorm::DataNonReguler(DormAuth::User()->id);
		// Hitung total non reguler
		$countNonReg = 0;
		foreach ($nonReguler as $nonReg) {
			$countNonReg += 1;
		}
		// Mendapatkan tanggal sekarang
    	$now = Carbon::now()->toDateTimeString();
    	// Mendapatkan data periode
    	$periode = Periode::all();
    	// Mencari periode tersedia
    	$pass_periode = 2;
    	foreach ($periode as $p) {
    		if(ITBdorm::CompareDateTime($now,$p->tanggal_tutup_daftar) == 1){
    			$pass_periode = 1;
    		}
    	}
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
    	return view('dashboard.penghuni.infoPendaftaran',[
			'reguler' => $reguler,
			'nonReguler' => $nonReguler, 
			'now' => $now,
			'countReg' => $countReg,
			'countNonReg' => $countNonReg,
			'pass_periode' => $pass_periode]);
	}
}