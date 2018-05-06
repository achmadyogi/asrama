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
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\pendaftaranPenghuni;
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

class gantiUsernameController extends Controller
{
	use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    use pendaftaranPenghuni;

    public function index(Request $request){
    	$this->Validate($request, [
    		'username' => 'required|unique:users,username'
    	]);
    	$username = Auth::User();
    	$username->username = $request->username;
    	$username->save();

    	Session::flash('status2','username Anda sudah diperbarui. Silahkan logout dan login kembali untuk mengaplikasikan perubahan yang sudah diatur.');
    	return view('dashboard.ganti_username', $this->getInitialDashboard());
    }

    public function form(){
    	Session::flash('menu','username');
    	return view('dashboard.ganti_username', $this->getInitialDashboard());
    }
}
