<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Session;
use App\Http\Controllers\Traits\initialDashboard;

class dataPenghuniController extends Controller
{
	use initialDashboard;

    protected function createPenghuni(Request $data){
    	/*
		return Validator::make($data, [
			'mahasiswa' => 'required',
	    	'nim' => 'numeric|size:8|',
	    	'nomor_identitas' => 'required|unique:user_penghuni,nomor_identitas',
	    	'jenis_identitas' => 'required',
	    	'tempat_lahir' => 'required',
	    	'tanggal_lahir' => 'required|date_format:YYYY-MM-DD',
	    	'gol_darah' => 'required',
	    	'kelamin' => 'required',
	    	'negara' => 'required',
	    	'propinsi' => 'required',
	    	'kota' => 'required',
	    	'alamat' => 'required|max:225',
	    	'kodepos' => 'required',
	    	'agama' => 'required',
	    	'pekerjaan' => 'required',
	    	'warga_negara' => 'required',
	    	'telepon' => 'required',
	    	'kontak_darurat' => 'required',
	    	'instansi' => 'required',
		]);
		*/

		// Memeriksa input instansi apakah ITB atau bukan
		if($data['instansi'] == NULL){
			$instansi = $data['instansi_itb'];
		}else{
			$instansi = $data['instansi'];
		}
		// Memeriksa keberadaan penghuni dan memasukkannya bila belum ada
		if(user_penghuni::where(['id_user'=>Auth::User()->id])->count() > 0){
    		Session::flash('status1', 'Status kepenghunian Anda sudah terdaftar. Untuk mengedit status kepenghunian Anda, silahkan edit di aplikasi kepenghunian.');
    	}else{
	    	$user_penghuni = User_penghuni::create([
				'id_user' => Auth::User()->id,
				'nomor_identitas' => $data['nomor_identitas'],
				'jenis_identitas' => $data['jenis_identitas'],
				'tempat_lahir' => $data['tempat_lahir'],
				'tanggal_lahir' => $data['tanggal_lahir'],
				'gol_darah' => $data['gol_darah'],
				'jenis_kelamin' => $data['kelamin'],
				'alamat' => $data['alamat'],
				'kodepos' => $data['kodepos'],
				'kota' => $data['kota'],
				'propinsi' => $data['propinsi'],
				'negara' => $data['negara'],
				'agama' => $data['agama'],
				'pekerjaan' => $data['pekerjaan'],
				'warga_negara' => $data['warga_negara'],
				'telepon' => $data['telepon'],
				'instansi' => $instansi,
				'kontak_darurat' => $data['kontak_darurat'],
				'nama_ortu_wali' => $data['nama_ortu_wali'],
				'pekerjaan_ortu_wali' => $data['pekerjaan_ortu_wali'],
				'alamat_ortu_wali' => $data['alamat_ortu_wali'],
				'telepon_ortu_wali' => $data['telepon_ortu_wali'],
			]);
    	}
    	// Memeriksa keberadaan NIM dan memasukkannya bila belum ada
		if($data['mahasiswa'] == '1'){
    		//Mencari prodi
    		$nim = substr(strval($data['nim']), 0, 3);
    		if(Prodi::where(['id_prodi'=>$nim])->count() < 1){
    			Session::flash('status1','Kode nim Anda tidak tersedia dalam daftar Prodi di ITB. Gunakan NIM yang valid.');
    		}elseif(User_nim::where(['id_prodi'=>$nim])->count() > 0){
    			Session::flash('status1', 'NIM Anda sudah terdaftar pada database. Untuk mengganti NIM, silahkan masuk di aplikasi ganti NIM.');
    		}else{
    			$user_nim = User_nim::create([
	    			'id_user' => Auth::User()->id,
	    			'id_prodi' => $nim,
	    			'nim' => $data['nim'],
	    			'status_nim' => 1,
	    		]);
	    		Session::flash('status2','Pendaftaran data diri penghuni berhasil dilakukan.');
    		}
    		
    	}
    	return view('dashboard.dashboard', $this->getInitialDashboard());
    }
}
