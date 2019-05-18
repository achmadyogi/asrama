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
use App\Tagihan;
use App\Kamar_penghuni;
use Illuminate\Support\Facades\DB;
use Session;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use ITBdorm;
use DormAuth;

class daftarRegulerController extends Controller
{
    public function index(){
        $periode = Periode::all();
        $now = Carbon::now()->toDateTimeString();
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
        return view('dashboard.penghuni.formReguler', ['periode'=>$periode, 'now' => $now]);
	}
	
	public function batal(Request $request) {
		$batal = Daftar_asrama_reguler::find($request->id_daftar);
		$batal->verification = 2;
		$batal->save();
		Session::flash('status1','Pembatalan pendaftaran berhasil dilakukan');
		Session::flash('menu','penghuni/pendaftaran_penghuni');
		return redirect()->back();
	}

	public function batalVerif(Request $request) {
		
		//Menghapus data di tabel taguhan
		$tagihan = Tagihan::where('daftar_asrama_id',$request->id_daftar)
							->where('daftar_asrama_type', '=', 'daftar_asrama_reguler');
		$tagihan->delete();

		//Menghapus data di tabel kamar penghuni
		$kamar = Kamar_penghuni::where('daftar_asrama_id', $request->id_daftar)
								->where('daftar_asrama_type', '=', 'Daftar_asrama_reguler');
		$kamar->delete();

		//Mengupdate tabel Daftar asrama non reguler
		$batalVerif = Daftar_asrama_reguler::find($request->id_daftar);
		$batalVerif->verification = 2;
		$batalVerif->save();

		Session::flash('status1','Pembatalan pendaftaran berhasil dilakukan');
		Session::flash('menu','penghuni/pendaftaran_penghuni');
		return redirect()->back();
	}

    public function editDaftar(Request $request){
    	$id_daftar = $request->id_daftar;
    	$id_periode = $request->id_periode;
    	$nama_periode = Periode::find($id_periode)->nama_periode;
        $periode = Periode::all();
        $now = Carbon::now()->toDateTimeString();
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
        return view('dashboard.penghuni.formEditReguler', ['periode'=>$periode, 'now' => $now, 'nama_periode' => $nama_periode, 'id_periode' => $id_periode, 'id_daftar' => $id_daftar]);
    }

    public function saveEditDaftar(Request $request){
    	// Ambil data beasiswa
		if($request->beasiswa == 'Lainnya'){
			$beasiswa = $request->r_beasiswa;
		}else{
			$beasiswa = $request->beasiswa;
		}
		// Ambil data lokasi_asrama
		if($request->mahasiswa == 'Kampus Ganesha'){
			$lokasi_asrama = 'ganesha';
		}else{
			$lokasi_asrama = 'jatinangor';
		}
		// Ambil Keterangan Penyakit
		if($request->ket_penyakit == ""){
			$ket_penyakit = "";
		}else{
			$ket_penyakit = $request->ket_penyakit;
		}
		// Ambil Keterangan difable
		if($request->ket_difable == ""){
			$ket_difable = "";
		}else{
			$ket_difable = $request->ket_difable;
		}
    	$id_daftar = $request->id_daftar;
    	$daftar = Daftar_asrama_reguler::find($id_daftar);
    	$daftar->id_periode = $request->periode;
    	$daftar->preference = $request->preference;
    	$daftar->asrama = $lokasi_asrama;
    	$daftar->status_beasiswa = $beasiswa;
    	$daftar->kampus_mahasiswa = $request->mahasiswa;
    	$daftar->has_penyakit = $request->penyakit;
    	$daftar->ket_penyakit = $ket_penyakit;
    	$daftar->is_difable = $request->difable;
    	$daftar->ket_difable = $request->ket_difable;
    	$daftar->is_international = $request->inter;
    	$daftar->tanggal_masuk = $request->tanggal;
    	$daftar->save();

    	Session::flash('status2','Edit pendaftaran telah berhasil dilakukan.');
    	return redirect()->route('pendaftaran_penghuni');

    }

    public function daftar(Request $request){
		// Proses Pendaftaran
		// Ambil data beasiswa
		if($request->beasiswa == 'Lainnya'){
			$beasiswa = $request->r_beasiswa;
		}else{
			$beasiswa = $request->beasiswa;
		}
		// Ambil data lokasi_asrama
		if($request->mahasiswa == 'Kampus Ganesha'){
			$lokasi_asrama = 'ganesha';
		}else{
			$lokasi_asrama = 'jatinangor';
		}
		// Ambil Keterangan Penyakit
		if($request->ket_penyakit == ""){
			$ket_penyakit = "";
		}else{
			$ket_penyakit = $request->ket_penyakit;
		}
		// Ambil Keterangan difable
		if($request->ket_difable == ""){
			$ket_difable = "";
		}else{
			$ket_difable = $request->ket_difable;
		}
		// Periksa apakah dalam periode yang sama daftar 2 kali
		$user = DormAuth::User()->id;
		$regis = DB::select("SELECT * FROM `daftar_asrama_reguler` WHERE id_user = ? AND (verification = 1 OR verification = 0 OR verification = 5)",[$user]);
		$re=0;
		foreach($regis as $regis) {
			if($request->periode == $regis->id_periode ){
				$re++;
			}
		}
		if($re > 0){
			Session::flash('status1','Pendaftaran gagal. Anda sudah mendaftarkan diri di periode ini. Silahkan edit pendaftaran Anda bila ditemukan kesalahan data dalam mendaftar.');
			return redirect()->back();
		}
		// Proses pendaftaran
		Daftar_asrama_reguler::create([
			'id_user' => DormAuth::User()->id,
			'id_periode' => $request->periode,
			'preference' => $request->preference,
			'asrama' => $request->asrama,
			'lokasi_asrama' => $lokasi_asrama,
			'verification' => 0,
			'status_beasiswa' => $beasiswa,
			'kampus_mahasiswa'=> $request->mahasiswa,
			'has_penyakit'=> $request->penyakit,
			'ket_penyakit' => $ket_penyakit,
			'is_difable' =>$request->difable,
			'ket_difable' => $ket_difable,
			'is_international' => $request->inter,
			'tanggal_masuk' => $request->tanggal,
		]);
    	Session::flash('status2','Pendaftaran berhasil dilakukan, selanjutnya tunggu konfirmasi dari sekretariat untuk verifikasi hingga rencana tinggal Anda disetujui.');
		Session::flash('menu','penghuni/pendaftaran_penghuni');
		return redirect()->route('pendaftaran_penghuni');
	}
}

