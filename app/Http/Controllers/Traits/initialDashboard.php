<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User_nim;
use App\User_penghuni;
use App\Asrama;
use App\Next_periode;
use App\Periode;
use App\Blacklist;
use App\Keluar_asrama;
use App\kerusakan_kamar;
use App\Pengelola;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;

trait initialDashboard{
	public function getInitialDashboard(){
	// Get user ID
        $userID = Auth::User()->id;
        // Get user information
        $user = User::find($userID);
        // Mengambil data pada tabel reguler
        if(Daftar_asrama_reguler::where(['id_user'=>$userID])->count() < 1){
        	$reguler = '0';
        }else{
        	$reguler = User::find($userID)->Daftar_asrama_reguler;
        }
        // Mengambil data pada tabel non reguler
        if(Daftar_asrama_non_reguler::where(['id_user'=>$userID])->count() < 1){
        	$nonReguler = '0';
        }else{
        	$nonReguler = User::find($userID)->Daftar_asrama_non_reguler;
        }
        // Mengambil data dari nim penghuni
        if(User_penghuni::where(['id_user'=>$userID])->count() < 1){
        	$userPenghuni = '0';
        }else{
        	$userPenghuni = User::find($userID)->user_penghuni;
        }
        // Mengambil data nim user
        if(User_nim::where(['id_user'=>$userID])->count() < 1){
        	$userNim = '0';
        }else{
        	$userNim = User::find($userID)->user_nim;
        }
        // Mengambil data pengelola
        if(Pengelola::where(['id_user'=>$userID])->count() < 1){
        	$pengelola = '0';
        	$pengelolaAsrama = '0';
        }else{
        	$pengelola = User::find($userID)->pengelola;
        	$pengelolaAsrama = Pengelola::find($pengelola->id_pengelola)->asrama;
        }
        // Mengambil data jurusan dan fakultas dari User NIM bila ada
        return (['reguler'=>$reguler,
        	        'nonReguler'=>$nonReguler,
        		'userNim'=>$userNim,
        		'userPenghuni'=>$userPenghuni,
        		'user'=>$user,
                        'pengelola'=>$pengelola,
        		'pengelolaAsrama'=>$pengelolaAsrama]);
	}
}


?>