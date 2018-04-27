<?php

namespace App\Http\Controllers\penghuni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Asrama;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Periode;
use dateTime;
use Carbon\Carbon;

class pendaftaranPenghuniController extends Controller
{
	use initialDashboard;
    use tanggalWaktu;
	use tanggal;
	use editPeriode;

    public function index(){
    	$dashboard = $this->getInitialDashboard();
    	$tarif = DB::Select('select * from tarif left join asrama on tarif.id_asrama = asrama.id_asrama');
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
	    		return view('dashboard.penghuni.infoPendaftaran', ['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
	    											'pass_periode' => $pass_periode,
	    											'tarif' => $tarif]);
	    	}else{
		    	$pass_periode = 1;    	
		    	Session::flash('menu','penghuni/pendaftaran_penghuni');
		    	return view('dashboard.penghuni.infoPendaftaran', ['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
								        			'nama_periodes' => $nama_periode,
								        			't_buka_daftar' => $t_buka_daftar,
								        			't_tutup_daftar' => $t_tutup_daftar,
								        			't_mulai_tinggal' => $t_mulai_tinggal,
								        			't_selesai_tinggal' => $t_selesai_tinggal,
								        			'jumlah_bulan' => $jumlah_bulan,
								        			'keterangan' => $keterangan,
								        			'id_periode' => $id_periode,
								        			'periode' => $periode,
	    											'pass_periode' => $pass_periode,
	    											'tarif' => $tarif]);
	    	}
	    	
	    }else{
	    	$pass_periode = 0;
	    	Session::flash('menu','penghuni/pendaftaran_penghuni');
	    	return view('dashboard.penghuni.infoPendaftaran', ['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
	    											'pass_periode' => $pass_periode,
	    											'tarif' => $tarif]);
	    }
	}
	
	public function showFormReguler() {
    	if (Auth::guest()) {
            return redirect('/login');
        } 
        else {
            $user_penghuni_info = Auth::user()->user_penghuni;
            if ($user_penghuni_info->status_daftar == NULL) {
                $list_asrama = Asrama::all();
				$list_periode = $this->getEditPeriode();

                return view('dashboard.penghuni.daftar_reguler')
                    ->with(['list_asrama' => $list_asrama,
                            'list_periode' => $list_periode]);
            }
            else {
                return redirect('/dashboard');
            }
        }
    }

}
