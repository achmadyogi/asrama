<?php

namespace App\Http\Controllers\Penghuni;

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
    	// Memeriksa apakah mahasiswa atau bukan
    	if($data->mahasiswa == 1){
    		$this->Validate($data,['nim' => 'required|string|size:8']);
    	}
    	// Memeriksa input instansi apakah ITB atau bukan
		if($data['instansi'] == NULL){
			$instansi = 'Institut Teknologi Bandung';
		}else{
			$instansi = $data['instansi'];
			$this->Validate($data,['instansi' => 'required']);
		}
		$this->Validate($data, [
	    	'nomor_identitas' => 'required|unique:user_penghuni,nomor_identitas',
	    	'jenis_identitas' => 'required',
	    	'tempat_lahir' => 'required',
	    	'tanggal_lahir' => 'required|date',
	    	'kota' => 'required',
	    	'alamat' => 'required|max:225',
	    	'kodepos' => 'required',
	    	'agama' => 'required',
	    	'pekerjaan' => 'required',
	    	'telepon' => 'required',
	    	'kontak_darurat' => 'required',
		]);
		
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

	protected function showNIM() {
		$user = Auth::user();
		$nim = User_nim::where('id_user', $user->id)->get();
		$nama = $user->name;
		return view('dashboard.penghuni.editNIM', $this->getInitialDashboard())->with(['nim'=>$nim,
											   'nama'=>$nama]);
	}
	
	protected function editNIM (Request $request) {
		
		//Mencari prodi
		$nim_user = $request->nim;
		$id_prodi = substr(strval($request->nim), 0, 3);
		if(Prodi::where(['id_prodi'=>$id_prodi])->count() < 1){
			Session::flash('status1','Kode nim Anda tidak tersedia dalam daftar Prodi di ITB. Gunakan NIM yang valid.');
		}elseif(User_nim::where(['nim'=>$nim_user])->count() > 0){
			Session::flash('status1', 'NIM Anda sudah terdaftar pada database. Untuk mengganti NIM, silahkan masuk di aplikasi ganti NIM.');
		}else{
			$user = Auth::user();
			$user_nim = $user->user_nim->first();
			$user_nim->id_user = Auth::User()->id;
			$user_nim->id_prodi = $id_prodi;
			$user_nim->nim = $nim_user;
			$user_nim->status_nim = 1;
			$user_nim->save(); 
			
			Session::flash('status2','Pergantian NIM berhasil dilakukan.');
		}
    		
    	return view('dashboard.dashboard', $this->getInitialDashboard());
	}
}
