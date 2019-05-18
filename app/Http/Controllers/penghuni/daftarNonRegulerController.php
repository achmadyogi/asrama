<?php

namespace App\Http\Controllers\penghuni;

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
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use ITBdorm;
use DormAuth;

class daftarNonRegulerController extends Controller
{
    public function index(){
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
    	return view('dashboard.penghuni.formNonReguler');
    }

    public function editDaftar(Request $request){
     	$id_daftar = $request->id_daftar;
     	$tujuan_tinggal = $request->tujuan_tinggal;
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
    	return view('dashboard.penghuni.formEditNonReguler',['id_daftar' => $id_daftar, 'tujuan_tinggal' => $tujuan_tinggal]);
    }

    public function saveEditDaftar(Request $request){
    	$id_daftar = $request->id_daftar;
    	$non = Daftar_asrama_non_reguler::find($id_daftar);
    	$non->preference = $request->preference;
    	$non->lokasi_asrama = $request->lokasi_asrama;
    	$non->is_difable = $request->difable;
    	$non->ket_difable = $request->ket_difable;
    	$non->tanggal_masuk = $request->tanggal_masuk;
    	$non->tempo = $request->tempo;
    	$non->lama_tinggal = $request->jumlah;
    	$non->save();

    	Session::flash('status2','Edit pendaftaran berhasil.');
    	return redirect()->route('pendaftaran_penghuni');
	}
	
	public function batal(Request $request) {
		$batal = Daftar_asrama_non_reguler::find($request->id_daftar);
		$batal->verification = 2;
		$batal->save();
		Session::flash('menu','penghuni/pendaftaran_penghuni');
		return redirect()->route('pendaftaran_penghuni');
	}

	public function batalVerif(Request $request) {
		//Mengupdate tabel Daftar asrama non reguler
		$batalVerif = Daftar_asrama_non_reguler::find($request->id_daftar);
		$batalVerif->verification = 2;
		$batal->save();

		//Menghapus data di tabel taguhan
		$tagihan = Tagihan::where('daftar_asrama_id',$request->id_daftar)
							->where('daftar_asrama_type', '=', 'daftar_asrama_non_reguler')->get()->delete();

		//Menghapus data di tabel kamar penghuni
		$kamar = Kamar_penghuni::where('daftar_asrama_id', $request->id_daftar)
								->where('daftar_asrama_type', '=', 'Daftar_asrama_non_reguler')->get()->delete();

		Session::flash('menu','penghuni/pendaftaran_penghuni');
		return redirect()->route('pendaftaran_penghuni');
	}

    public function daftar(Request $request){
    	$this->Validate($request, [
	    	'jumlah' => 'required|numeric',
	    	'tanggal_masuk' => 'required|date',
	    	'tujuan_tinggal' => 'required',
		]);
		// Proses Pendaftaran
			Daftar_asrama_non_reguler::create([
				'id_user' => DormAuth::User()->id,
				'tujuan_tinggal' => $request->tujuan_tinggal,
				'preference' => $request->preference,
				'lokasi_asrama' => $request->lokasi_asrama,
				'verification' => 0,
				'is_difable' =>$request->difable,
				'ket_difable' => $request->ket_difable,
				'tanggal_masuk' => $request->tanggal_masuk,
				'tempo' => $request->tempo,
				'lama_tinggal' => $request->jumlah,
			]);
    		Session::flash('status2','Pendaftaran berhasil dilakukan, Pendaftaran berhasil dilakukan, selanjutnya tunggu konfirmasi dari sekretariat untuk verifikasi hingga rencana tinggal Anda disetujui.');
		    	return redirect()->route('pendaftaran_penghuni');
    }
}
