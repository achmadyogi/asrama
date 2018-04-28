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
    	return view('dashboard.penghuni.formNonReguler', ['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama']]);
    }

    public function daftar(Request $request){
    	$dashboard = $this->getInitialDashboard();
    	$this->Validate($request, [
	    	'jumlah' => 'required|numeric',
	    	'tanggal_masuk' => 'required|date',
	    	'tujuan_tinggal' => 'required',
		]);
		// Memeriksa keberadaan pendaftaran pada database
		if(Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
			$nonReguler = Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id]);
			return view('dashboard.penghuni.infoPendaftaran', ['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
								        			'check' => $nonReguler]);
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
			$daftarNonReguler = Daftar_asrama_non_reguler::where(['id_user' => Auth::User()->id]);
			Session::flash('status2','Pendaftaran berhasil dilakukan, silahkan lakukan pembayaran dan lakukan konfirmasi pada petugas kami untuk bisa melakukan aktivasi dan finalisasi.');
			return view('dashboard.penghuni.infoPendaftaran', ['daftar'=> $daftarNonReguler,
																'user' => $dashboard['user'],
				    											'reguler'=>$dashboard['reguler'],
											        	        'nonReguler'=>$dashboard['nonReguler'],
												        		'userNim'=>$dashboard['userNim'],
												        		'userPenghuni'=>$dashboard['userPenghuni'],
											                    'pengelola'=>$dashboard['pengelola'],
											        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
											        			'check' => $daftarNonReguler]);
		};

    }
}
