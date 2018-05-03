<?php

namespace App\Http\Controllers\penghuni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Asrama;
use App\User_penghuni;
//use App\Daftar_asrama_reguler;
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
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;

class pendaftaranPenghuniController extends Controller
{
	use initialDashboard;
    use tanggalWaktu;
	use tanggal;
	use editPeriode;

    public function index(){
    	// Mendapatkan informasi parameter dashboard awal
	    $dashboard = $this->getInitialDashboard();
    	// Memeriksa apakah sudah mendaftarkan diri di reguler
    	if(Daftar_asrama_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){

		}
		// Memeriksa apakah sudah mendaftarkan diri di non reguler
		if(Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
			// Mengotak-atik tanggal
			$i = 0;
			foreach ($dashboard['nonReguler'] as $nonReg) {
				$tanggal_daftar[$i] = $this->date($nonReg->created_at);
				$tanggal_masuk[$i] = $this->dateTanggal($nonReg->tanggal_masuk);
				$i += 1;
			}
			// Memeriksa bila sudah ada yang terverifikasi
			Session::flash('menu','penghuni/pendaftaran_penghuni');
			return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with(['tanggal_daftar' => $tanggal_daftar,
									        			'tanggal_masuk' => $tanggal_masuk]);
		}
		// Apabila belum daftar reguler dan non reguler
		if(Daftar_asrama_reguler::where(['id_user'=>Auth::User()->id])->count() < 1 && Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id])->count() < 1){
	    	$now = Carbon::now();
	    	if(Periode::all()->count() > 0){
		    	$periode = Periode::all()->sortByDesc('id_periode');
		    	$i = 0;
		    	foreach ($periode as $periode) {
		    		$kadaluarsa = $periode->tanggal_tutup_daftar;
		    		$kadaluarsa = explode(' ', $kadaluarsa);
		    		$kadaluarsa_date = explode('-', $kadaluarsa[0]);
		    		$kadaluarsa_time = explode(':', $kadaluarsa[1]);
		    		$kadal = Carbon::create($kadaluarsa_date[0],$kadaluarsa_date[1],$kadaluarsa_date[2],$kadaluarsa_time[0],$kadaluarsa_time[1],$kadaluarsa_time[2]);
		    		if($now < $kadal){
		    			$nama_periode[$i] = $periode->nama_periode;
			    		$t_buka_daftar[$i] = $this->date($periode->tanggal_buka_daftar);
			    		$t_tutup_daftar[$i] = $this->date($periode->tanggal_tutup_daftar);
			    		$t_mulai_tinggal[$i ]= $this->dateTanggal($periode->tanggal_mulai_tinggal);
			    		$t_selesai_tinggal[$i] = $this->dateTanggal($periode->tanggal_selesai_tinggal);
			    		$jumlah_bulan[$i] = $periode->jumlah_bulan;
			    		$keterangan[$i] = $periode->keterangan;
			    		$id_periode[$i] = $periode->id_periode;
		    			$i += 1;
		    		}
		    	}
		    	if($i == 0){
		    		$pass_periode = 0;
		    		Session::flash('menu','penghuni/pendaftaran_penghuni');
		    		return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with(['pass_periode' => $pass_periode]);
		    	}else{
			    	$pass_periode = 1;    	
			    	Session::flash('menu','penghuni/pendaftaran_penghuni');
			    	return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with(['nama_periodes' => $nama_periode,
									        			't_buka_daftar' => $t_buka_daftar,
									        			't_tutup_daftar' => $t_tutup_daftar,
									        			't_mulai_tinggal' => $t_mulai_tinggal,
									        			't_selesai_tinggal' => $t_selesai_tinggal,
									        			'jumlah_bulan' => $jumlah_bulan,
									        			'keterangan' => $keterangan,
									        			'id_periode' => $id_periode,
									        			'periode' => $periode,
		    											'pass_periode' => $pass_periode]);
		    	}
		    	
		    }else{
		    	$pass_periode = 0;
		    	Session::flash('menu','penghuni/pendaftaran_penghuni');
		    	return view('dashboard.penghuni.infoPendaftaran', $this->getInitialDashboard())->with(['pass_periode' => $pass_periode]);
		    }
		}
	}
	public function showFormReguler() {
		$dashboard = $this->getInitialDashboard();
		if (Auth::guest()) {
            return redirect('/login');
        } 
        else {
            $user_penghuni_info = Auth::user()->user_penghuni;
            if ($user_penghuni_info->status_daftar == NULL) {
                $list_asrama = Asrama::all();
                $list_periode = Periode::all();

                return view('dashboard.penghuni.daftar_reguler')
					->with(['list_asrama' => $list_asrama,
							'list_periode' => $list_periode]);
            }
            else {
                return redirect('/dashboard');
            }
        }
	}

	public function daftarReguler(Request $request) {
		if(Daftar_asrama_non_reguler::where(['id_user'=>Auth::User()->id])->count() > 0){
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
			} else {
				$daftar_asrama_reguler->preference = 3;	
			};
			$daftar_asrama_reguler->verification = 0;
			$daftar_asrama_reguler->status_beasiswa = $request->beasiswa;
			$daftar_asrama_reguler->status_mahasiswa = $request->mahasiswa;
			$daftar_asrama_reguler->kepenghunian = 'Penghuni';
			$daftar_asrama_reguler->is_difable = $request->difable == 'Sehat' ? '0' : '1';
			$daftar_asrama_reguler->is_international = $request->internasional == 'Mahasiswa Internasional' ? '1' : '0';
			$daftar_asrama_reguler->id_periode = $request->periode;
			$daftar_asrama_reguler->tanggal_masuk = $request->tanggal_mulai;
			
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
    }


}
