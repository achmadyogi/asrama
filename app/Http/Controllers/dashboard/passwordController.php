<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use Session;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\Asrama;
use DormAuth;

class passwordController extends Controller
{
    public function index(){
    	Session::flash('menu','password');
    	return view('dashboard.password');
    }

    public function gantiPassword(request $request){
    	$this->Validate($request, [
	    	'password_lama' => 'required',
	    	'password_baru' => 'required',
	    	're_password_baru' => 'required',
		]);

    	// Apakah password baru sudah sama dengan konfirmasinya
		if($request->password_baru != $request->re_password_baru){
			Session::flash('status1','Konfirmasi password Anda tidak cocok, silahkan ulangi lagi.');
			return redirect()->back();
		}

		// Apakah password lama sesuai dengan database
		$pwd = DormAuth::User()->password;
		$ID = DormAuth::User()->id;
		$hash = password_verify($request->password_lama, $pwd);
		if($hash == 0){
			Session::flash('status1','password lama yang Anda masukkan tidak sesuai. Silahkan ulangi lagi.');
			return redirect()->back();
		}else{
			$enct_pass = password_hash($request->password_baru, PASSWORD_DEFAULT);
			$user = User::find($ID);
			$user->password = $enct_pass;
			$user->save();

			Session::flash('status2','Password Anda berhasil diubah.');
			return redirect()->back();
		}
    }
}
