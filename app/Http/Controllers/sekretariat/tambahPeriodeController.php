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

class tambahPeriodeController extends Controller
{
	use initialDashboard;
	use tanggalWaktu;
    use tanggal;
	use editPeriode;

	protected function index(Request $request)
    {
        $this->Validate($request, [
            'nama_periode' => 'required|max:225|unique:periodes,nama_periode',
            'tanggal_buka_daftar' => 'required|date',
            'tanggal_tutup_daftar' => 'required|date',
            'tanggal_mulai_tinggal' => 'required|date',
            'tanggal_selesai_tinggal' => 'required|date',
            'jumlah_bulan' => 'required|numeric'
        ]);

        $periode_baru = Periode::create([
	    			'nama_periode' => $request->nama_periode,
	    			'tanggal_buka_daftar' => $request->tanggal_buka_daftar,
	    			'tanggal_tutup_daftar' => $request->tanggal_tutup_daftar,
	    			'tanggal_mulai_tinggal' => $request->tanggal_mulai_tinggal,
	    			'tanggal_selesai_tinggal' => $request->tanggal_selesai_tinggal,
	    			'jumlah_bulan' => $request->jumlah_bulan,
	    			'keterangan' => $request->keterangan,
	    		]);
        Session::flash('status2', 'Periode baru berhasil ditambahkan silahkan periksa tabel periode.');
    	return redirect()->back();
    }

    protected function editPeriode(Request $request){

        $edit = Periode::find($request->id_periode);
        $edit->nama_periode = $request->nama_periode_edit;
        $edit->tanggal_buka_daftar = $request->tanggal_pendaftaran_dibuka;
        $edit->tanggal_tutup_daftar = $request->tanggal_pendaftaran_ditutup;
        $edit->save();

        Session::flash('status2', 'Periode berhasil diedit.');
        return redirect()->back();
    }
}
