<?php

namespace App\Http\Controllers\sekretariat;

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
use App\Periode;
use dateTime;
use Carbon\Carbon;

class editPeriodeController extends Controller
{
	use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    // Memanggil Periode
    function index(){
    	return view('dashboard.sekretariat.edit_periode', $this->getEditPeriode());
    }
}
	
    
