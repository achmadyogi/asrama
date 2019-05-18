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
use App\Http\Controllers\Traits\tanggal;
use App\Periode;
use dateTime;
use DB;
use Carbon\Carbon;

trait editPeriode{
	public function getEditPeriode(){
		// Untuk aktivasi link menu
		$menu_side = "sekretariat_buat/edit_periode";
		$now = new Carbon();
    	// Informasi dashboard
		$dashboard = $this->getInitialDashboard();
		$data_asrama = DB::table('asrama')->get();
	    if(Periode::all()->count() > 0){
	    	$periode = Periode::all()->sortByDesc('id_periode');
	    	$i = 0;
	    	foreach ($periode as $periode) {
	    		// Tanggal periode ditutup
	    		$kadaluarsa = $periode->tanggal_selesai_tinggal;
	    		$kadaluarsa = explode(' ', $kadaluarsa);
	    		$kadaluarsa_date = explode('-', $kadaluarsa[0]);
	    		$kadal = Carbon::createFromDate($kadaluarsa_date[0],$kadaluarsa_date[1],$kadaluarsa_date[2]);

	    		// Tanggal periode dibuka
	    		$dibuka = $periode->tanggal_mulai_tinggal;
	    		$dibuka = explode(' ', $dibuka);
	    		$dibuka_date = explode('-', $dibuka[0]);
	    		$buka = Carbon::createFromDate($dibuka_date[0],$dibuka_date[1],$dibuka_date[2]);
	    		if($now > $kadal){
	    			$aktif = 'ditutup';
	    		}elseif($now < $buka){
	    			$aktif = 'belum aktif';
	    		}else{
	    			$aktif = 'aktif';
	    		}
				$kadaluarsa_daftar = $periode->tanggal_selesai_tinggal;
				$kadaluarsa_daftar = explode(' ', $kadaluarsa_daftar);
				$kadaluarsa_daftar = explode('-', $kadaluarsa_daftar[0]);
				$exp_daftar = Carbon::createFromDate($kadaluarsa_daftar[0],$kadaluarsa_daftar[1],$kadaluarsa_daftar[2]);
	    		$nama_periode[$i] = $periode->nama_periode;
	    		$t_buka_daftar[$i] = $this->date($periode->tanggal_buka_daftar);
	    		$t_tutup_daftar[$i] = $this->date($periode->tanggal_tutup_daftar);
	    		$t_mulai_tinggal[$i ]= $this->dateTanggal($periode->tanggal_mulai_tinggal);
	    		$t_selesai_tinggal[$i] = $this->dateTanggal($periode->tanggal_selesai_tinggal);
	    		$jumlah_bulan[$i] = $periode->jumlah_bulan;
	    		$status[$i] = $aktif;
	    		$keterangan[$i] = $periode->keterangan;
	    		$id_periode[$i] = $periode->id_periode;
				$i += 1;				
	    	}    	
			$t_periode = 1;

	    	return (['user' => $dashboard['user'],
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
								        			'status' => $status,
								        			'keterangan' => $keterangan,
								        			'id_periode' => $id_periode,
													'periode' => $periode,
													't_periode' => $t_periode,
													'now' => $now,
													'kadaluarsa' => $exp_daftar,
													'list_asrama'=> $data_asrama]);
	    }else{
	    	$t_periode = 0;
	    	return (['user' => $dashboard['user'],
	    											'reguler'=>$dashboard['reguler'],
								        	        'nonReguler'=>$dashboard['nonReguler'],
									        		'userNim'=>$dashboard['userNim'],
									        		'userPenghuni'=>$dashboard['userPenghuni'],
													'pengelola'=>$dashboard['pengelola'],
								        			'pengelolaAsrama'=>$dashboard['pengelolaAsrama'],
													't_periode' => $t_periode,
													'now' => $now,
													'list_asrama'=> $data_asrama]);
	    }
	}
}

?>
