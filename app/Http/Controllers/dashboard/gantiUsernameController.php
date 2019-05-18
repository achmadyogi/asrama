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
use Session;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;
use ITBdorm;
use DormAuth;

class gantiUsernameController extends Controller
{
    public function index(Request $request){
    	$this->Validate($request, [
    		'username' => 'required|unique:users,username'
    	]);
    	$username = DormAuth::User();
    	$username->username = $request->username;
    	$username->save();

    	Session::flash('status2','username Anda sudah diperbarui. Silahkan logout dan login kembali untuk mengaplikasikan perubahan yang sudah diatur.');
    	return redirect()->back();
	}
	
	public function gantiEmail(Request $request){
    	$this->Validate($request, [
    		'email' => 'required|unique:users,email'
    	]);
    	$email = DormAuth::User();
    	$email->email = $request->email;
    	$email->save();

    	Session::flash('status2','Email Anda sudah diperbarui. Silahkan logout dan login kembali untuk mengaplikasikan perubahan yang sudah diatur.');
    	return redirect()->back();
	}

    public function form(){
    	Session::flash('menu','username');
    	return view('dashboard.ganti_username');
	}
	
	public function formEditEmail(){
    	Session::flash('menu','email');
    	return view('dashboard.ganti_email');
	}
}
