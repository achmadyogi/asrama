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
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_reguler;

class daftarRegulerController extends Controller
{
    use initialDashboard;
    use tanggalWaktu;
    use tanggal;

    public function index(){
        $dashboard = $this->getInitialDashboard();
        $list_periode = Periode::all();
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
        return view('dashboard.penghuni.formReguler', $this->getInitialDashboard())
                ->with(['list_periode' => $list_periode]);
    }

    public function daftar(Request $request){
        if(Daftar_asrama_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
    		$dashboard = $this->getInitialDashboard();
			// Mengotak-atik tanggal
			$i = 0;
			foreach ($dashboard['reguler'] as $reg) {
				$tanggal_daftar[$i] = $this->date($reg->created_at);
				$tanggal_masuk[$i] = $this->dateTanggal($reg->tanggal_masuk);
				$i += 1;
			}
			return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
								        			'tanggal_daftar' => $tanggal_daftar,
								        			'tanggal_masuk' => $tanggal_masuk]);
		}else{
			$user = Auth::user();

			$user_penghuni = $user->user_penghuni;
			$user_penghuni->status_daftar = 'Reguler';
			$user_penghuni->save();

			$daftar_asrama_reguler = new Daftar_asrama_reguler();
			$daftar_asrama_reguler->id_user = $user_penghuni->id_user;
			if ($request->preference == "Sendiri") {
				$daftar_asrama_reguler->preference = 1;
			} else if($request->preference == "Berdua") {
				$daftar_asrama_reguler->preference = 2;
			} else if($request->preference == "Bertiga"){
				$daftar_asrama_reguler->preference = 3;	
			};
			$daftar_asrama_reguler->verification = 0;
			$daftar_asrama_reguler->status_beasiswa = $request->beasiswa;
			$daftar_asrama_reguler->kampus_mahasiswa = $request->mahasiswa;
			$daftar_asrama_reguler->is_international = $request->inter;
			$daftar_asrama_reguler->id_periode = $request->periode;
			$daftar_asrama_reguler->tanggal_masuk = $request->tanggal_mulai;
			if($request->asrama == 'Asrama Jatinangor') {
				$daftar_asrama_reguler->lokasi_asrama = 'jatinangor';
			} else {
				$daftar_asrama_reguler->lokasi_asrama = 'ganesha';
			}
			$daftar_asrama_reguler->is_difable = $request->difable;
			if($request->difable == 1) {
				$daftar_asrama_reguler->ket_difable = $request->ket_difable;
			} else {
				$daftar_asrama_reguler->ket_difable = '-';
			}
			$daftar_asrama_reguler->has_penyakit = $request->penyakit;
			if($request->penyakit == 1) {
				$daftar_asrama_reguler->ket_penyakit = $request->ket_penyakit;
			} else {
				$daftar_asrama_reguler->ket_penyakit = '-';
			}
			$daftar_asrama_reguler->save();
    		$dashboard = $this->getInitialDashboard();
			// Mengotak-atik display tanggal
			$i = 0;
			foreach ($dashboard['reguler'] as $reg) {
				$tanggal_daftar[$i] = $this->date($reg->created_at);
				$tanggal_masuk[$i] = $this->dateTanggal($reg->tanggal_masuk);
				$i += 1;
			}
			Session::flash('status2','Pendaftaran berhasil dilakukan, silahkan lakukan pembayaran dan lakukan konfirmasi pada petugas kami untuk bisa melakukan aktivasi dan finalisasi.');
			return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
											        			'tanggal_daftar' => $tanggal_daftar,
								        						'tanggal_masuk' => $tanggal_masuk]);
		};
    	// $this->Validate($request, [
	    // 	'jumlah' => 'required|numeric',
	    // 	'tanggal_masuk' => 'required|date',
	    // 	'tujuan_tinggal' => 'required',
		// ]);
		// // Memeriksa keberadaan pendaftaran pada database
		// if(Daftar_asrama_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
    	// 	$dashboard = $this->getInitialDashboard();
		// 	// Mengotak-atik tanggal
		// 	$i = 0;
		// 	foreach ($dashboard['reguler'] as $reg) {
		// 		$tanggal_daftar[$i] = $this->date($reg->created_at);
		// 		$tanggal_masuk[$i] = $this->dateTanggal($reg->tanggal_masuk);
		// 		$i += 1;
		// 	}
		// 	return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
		// 						        			'tanggal_daftar' => $tanggal_daftar,
		// 						        			'tanggal_masuk' => $tanggal_masuk]);
		// }else{
		// 	Daftar_asrama_reguler::create([
		// 		'id_user' => Auth::User()->id,
        //         'preference' => $request->preference,
		// 		'lokasi_asrama' => $request->lokasi_asrama,
		// 		'verification' => 0,
        //         'is_difable' =>$request->difable,
        //         'is_internasional' => $request->international,
        //         'tanggal_masuk' => $request->tanggal_masuk,
        //         'status_mahasiswa' => $request->mahasiswa,
        //         'status_beasiswa' => $request->beasiswa,
        //         'ket_difable' => $request->ket_difable
		// 	]);
    	// 	$dashboard = $this->getInitialDashboard();
		// 	// Mengotak-atik display tanggal
		// 	$i = 0;
		// 	foreach ($dashboard['reguler'] as $reg) {
		// 		$tanggal_daftar[$i] = $this->date($reg->created_at);
		// 		$tanggal_masuk[$i] = $this->dateTanggal($reg->tanggal_masuk);
		// 		$i += 1;
		// 	}
		// 	Session::flash('status2','Pendaftaran berhasil dilakukan, silahkan lakukan pembayaran dan lakukan konfirmasi pada petugas kami untuk bisa melakukan aktivasi dan finalisasi.');
		// 	return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
		// 									        			'tanggal_daftar' => $tanggal_daftar,
		// 						        						'tanggal_masuk' => $tanggal_masuk]);
		// };

    }
}

