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
use App\Http\Controllers\Traits\editPeriode;
use App\Periode;
use dateTime;
use Carbon\Carbon;

class tambahPeriodeController extends Controller
{
	use initialDashboard;
	use tanggalWaktu;
	use editPeriode;

	protected function index(Request $request)
    {
        $this->Validate($request, [
            'nama_periode' => 'required|max:255',
            'tanggal_buka_daftar' => 'required|date',
            'tanggal_tutup_daftar' => 'required|date',
            'tanggal_mulai_tinggal' => 'required|date',
            'tanggal_selesai_tinggal' => 'required|date',
            'ammount of month' => 'required|numeric'
        ]);


    	return view('dashboard.sekretariat.edit_periode', $this->getEditPeriod());
    }
}
