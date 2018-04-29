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
use App\Daftar_asrama_non_reguler;

class daftarNonRegulerController extends Controller
{
    use initialDashboard;
    use tanggalWaktu;
    use tanggal;

    public function index(){
    	$dashboard = $this->getInitialDashboard();
    	Session::flash('menu','penghuni/pendaftaran_penghuni');
    	return view('dashboard.penghuni.formNonReguler', $this->getInitialDashboard());
    }

    public function daftar(Request $request){
    	$this->Validate($request, [
	    	'jumlah' => 'required|numeric',
	    	'tanggal_masuk' => 'required|date',
	    	'tujuan_tinggal' => 'required',
		]);
		// Memeriksa keberadaan pendaftaran pada database
		if(Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
    		$dashboard = $this->getInitialDashboard();
			// Mengotak-atik tanggal
			$i = 0;
			foreach ($dashboard['nonReguler'] as $nonReg) {
				$tanggal_daftar[$i] = $this->date($nonReg->created_at);
				$tanggal_masuk[$i] = $this->dateTanggal($nonReg->tanggal_masuk);
				$i += 1;
			}
			return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
								        			'tanggal_daftar' => $tanggal_daftar,
								        			'tanggal_masuk' => $tanggal_masuk]);
		}else{
			Daftar_asrama_non_reguler::create([
				'id_user' => Auth::User()->id,
				'tujuan_tinggal' => $request->tujuan_tinggal,
				'preference' => $request->preference,
				'lokasi_asrama' => $request->lokasi_asrama,
				'verification' => 0,
				'is_difable' =>$request->difable,
				'tanggal_masuk' => $request->tanggal_masuk,
				'tempo' => $request->tempo,
				'lama_tinggal' => $request->jumlah,
			]);
    		$dashboard = $this->getInitialDashboard();
			// Mengotak-atik display tanggal
			$i = 0;
			foreach ($dashboard['nonReguler'] as $nonReg) {
				$tanggal_daftar[$i] = $this->date($nonReg->created_at);
				$tanggal_masuk[$i] = $this->dateTanggal($nonReg->tanggal_masuk);
				$i += 1;
			}
			Session::flash('status2','Pendaftaran berhasil dilakukan, silahkan lakukan pembayaran dan lakukan konfirmasi pada petugas kami untuk bisa melakukan aktivasi dan finalisasi.');
			return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with([
											        			'tanggal_daftar' => $tanggal_daftar,
								        						'tanggal_masuk' => $tanggal_masuk]);
		};

    }
}
