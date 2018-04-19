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
use App\Http\Controllers\Traits\tanggal;
use App\Periode;
use dateTime;

class editPeriodeController extends Controller
{
	use initialDashboard;
	use tanggal;
    // Memanggil Periode
	$tanggal_now = date("Y-m-d");
    if(Periode::all()->count > 0){
    	$periode = Periode::all()
    	foreach ($periode as $periode) {
    		$kadaluarsa = $periode->tanggal_selesai_tinggal;
    		$kadaluarsa = explode('-', $kadaluarsa);
    		$t_kadaluarsa = date("Y-m-d",mktime(0,0,0,$kadaluarsa[1],$kadaluarsa[2],$kadaluarsa[0]));
    		if(strtotime($t_kadaluarsa) - strtotime($tanggal_now) < 0){
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
    	return view('sekretariat.edit_periode', [$this->getInitialDashboard(), 
    											'nama_periode' => $nama_periode,
    											't_buka_daftar' => $t_buka_daftar,
    											't_tutup_daftar' => $t_tutup_daftar,
    											't_mulai_tanggal' => $t_mulai_tanggal,
    											't_selesai_tinggal' => $t_selesai_tinggal,
    											'jumlah_bulan' => $jumlah_bulan,
    											'keterangan' => $keterangan,
    											'periode' => $periode]);
    }else{
    	$t_periode = 0;
    	return view('sekretariat.edit_periode', ['periode' => $periode]);
    }
}
