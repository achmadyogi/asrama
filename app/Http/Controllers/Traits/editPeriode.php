<?php
namespace App\Http\Controllers\Traits;

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
use App\Periode;
use dateTime;
use Carbon\Carbon;

trait editPeriode{
	public function getEditPeriode(){
		$now = Carbon::now();
    	// Informasi dashboard
    	$dashboard = $this->getInitialDashboard();
	    if(Periode::all()->count() > 0){
	    	$periode = Periode::all();
	    	foreach ($periode as $periode) {
	    		$kadaluarsa = $periode->tanggal_selesai_tinggal;
	    		$kadaluarsa = explode(' ', $kadaluarsa);
	    		$kadaluarsa_date = explode('-', $kadaluarsa[0]);
	    		$kadaluarsa_time = explode(':', $kadaluarsa[1]);
	    		$kadaluarsa = Carbon::create($kadaluarsa_date[0],$kadaluarsa_date[1],$kadaluarsa_date[2],$kadaluarsa_time[0],$kadaluarsa_time[1],$kadaluarsa_time[2]);
	    		if($tanggal_now > $kadaluarsa){
	    			$aktif[] = 0;
	    		}else{
	    			$aktif[] = 1;
	    		}
	    		$nama_periode[] = $periode->nama_periode;
	    		$t_buka_daftar[] = date($periode->tanggal_buka_daftar);
	    		$t_tutup_daftar[] = date($periode->tanggal_tutup_daftar);
	    		$t_mulai_tanggal[] = date($periode->tanggal_mulai_tanggal);
	    		$t_selesai_tinggal[] = date($periode->tanggal_selesai_tinggal);
	    		$jumlah_bulan[] = $periode->jumlah_bulan;
	    		$keterangan[] = $periode->keterangan;
	    	}
	    	$t_periode = 1;
	    	return (['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'], 
	    											'nama_periode' => $nama_periode,
	    											't_buka_daftar' => $t_buka_daftar,
	    											't_tutup_daftar' => $t_tutup_daftar,
	    											't_mulai_tanggal' => $t_mulai_tanggal,
	    											't_selesai_tinggal' => $t_selesai_tinggal,
	    											'jumlah_bulan' => $jumlah_bulan,
	    											'keterangan' => $keterangan,
	    											't_periode' => $t_periode,
	    											'aktif' => $aktif]);
	    }else{
	    	$t_periode = 0;
	    	return (['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
								                    'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
	    											't_periode' => $t_periode]);
	    }
	}
}

?>
