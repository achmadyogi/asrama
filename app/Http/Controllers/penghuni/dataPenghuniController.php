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
use DormAuth;

class dataPenghuniController extends Controller
{
    public function createPenghuni(Request $data){
    	// TENTANG REGISTRASI
    	// Memeriksa apakah mahasiswa atau bukan
    	if($data->mahasiswa == 1){
    		// Memeriksa sudah punya nim apa belum
    		if($data->nomor_NIM == 1){
    			// Validasi NIM
	    		$this->Validate($data,['nim' => 'required|string|size:8']);
	    		$nomor_NIM = $data->nim;
    		}else{
    			$nomor_NIM = '-';
    			$prod = Prodi::where(['id_fakultas'=>$data->fakultas])->get();
    			echo $prod;
    			foreach ($prod as $prod) {
    				if(strpos($prod->nama_prodi, 'Tahap') !== false){
    					$id_prod = $prod->id_prodi;
    				}
    			}
    		}
    	} else {
    		$nomor_NIM = 0;
    		$id_prod = 0;
    		$data->registrasi = 0;
    	}
    	// Memeriksa input instansi apakah ITB atau bukan
		if($data['instansi'] == NULL){
			$instansi = 'Institut Teknologi Bandung';
		}else{
			$instansi = $data['instansi'];
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
		// Memeriksa keberadaan NIM dan memasukkannya bila belum ada
		if($nomor_NIM !== '-'){
    		//Mencari prodi
    		$nim = $data['nim'];
    		$id_prod = substr(strval($data['nim']), 0, 3);
    		if(Prodi::where(['id_prodi'=>$id_prod])->count() < 1){
    			Session::flash('status1','Kode nim Anda tidak tersedia dalam daftar Prodi di ITB. Gunakan NIM yang valid.');
    		}elseif(User_nim::where(['nim'=>$nim])->count() > 0){
    			Session::flash('status1', 'NIM yang Anda masukkan sudah terdaftar pada database. Periksa NIM Anda kembali apakah sudah benar atau terdapat kesalahan.');
    			return redirect()->back();
    		}else{
    			$user_nim = User_nim::create([
	    			'id_user' => DormAuth::User()->id,
	    			'id_prodi' => $id_prod,
	    			'registrasi' => $data->registrasi,
	    			'nim' => $nim,
	    			'status_nim' => 1,
	    		]);
	    		Session::flash('status2','Pendaftaran data diri penghuni berhasil dilakukan.');
    		}
    	}else{
    		$user_nim = User_nim::create([
	    			'id_user' => DormAuth::User()->id,
	    			'id_prodi' => $id_prod,
	    			'registrasi' => $data->registrasi,
	    			'nim' => $nomor_NIM,
	    			'status_nim' => 1,
	    	]);
	    	Session::flash('status2','Pendaftaran data diri penghuni berhasil dilakukan.');
    	}
		// Memeriksa keberadaan penghuni dan memasukkannya bila belum ada
		if(user_penghuni::where(['id_user'=>DormAuth::User()->id])->count() > 0){
    		Session::flash('status1', 'Status kepenghunian Anda sudah terdaftar. Untuk mengedit status kepenghunian Anda, silahkan edit di aplikasi kepenghunian.');
    	}else{
	    	$user_penghuni = User_penghuni::create([
				'id_user' => DormAuth::User()->id,
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
    	return redirect()->route('dashboard');
	}

	protected function showNIM() {
		Session::flash('menu','editNim');
		return view('dashboard.penghuni.editNIM');
	}

	protected function showRegistrasi() {
		Session::flash('menu','editRegis');
		return view('dashboard.penghuni.editRegistrasi');
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
			$user = DormAuth::User();
			$user_nim = $user->user_nim->first();
			$user_nim->id_user = DormAuth::User()->id;
			$user_nim->id_prodi = $id_prodi;
			$user_nim->nim = $nim_user;
			$user_nim->status_nim = 1;
			$user_nim->save(); 
			
			Session::flash('status2','Pergantian NIM berhasil dilakukan.');
		}
    	return redirect()->back();
	}

	protected function editRegistrasi (Request $request) {
		
		$user = DormAuth::User();
		$prodi = User_nim::where('id_user', $user->id)->get();
		$user_nim = $user->user_nim->first();
		$user_nim->id_user = DormAuth::User()->id;
		$user_nim->registrasi = $request->registrasi;
		$user_nim->status_nim = 1;
		$user_nim->save(); 
		
		Session::flash('status2','Pergantian Nomor Registrasi berhasil dilakukan.');
    	return redirect()->back();
	}

	protected function edit_data_penghuni() {
        return view('dashboard.penghuni.editDataPenghuni');
	}

	protected function save_data_penghuni(Request $data) {
		$this->Validate($data, [
	    	'nomor_identitas' => 'required',
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
		
		//Menyimpan data
		$user = DormAuth::User();
		$id = DormAuth::User()->id;
		$user_penghuni = $user->user_penghuni->where('id_user', $id)->first();
		$user_penghuni->id_user = DormAuth::User()->id;
		$user_penghuni->nomor_identitas = $data->nomor_identitas;
		$user_penghuni->jenis_identitas = $data->jenis_identitas;
		$user_penghuni->tempat_lahir = $data->tempat_lahir;
		$user_penghuni->tanggal_lahir = $data->tanggal_lahir;
		$user_penghuni->gol_darah = $data->gol_darah;
		$user_penghuni->jenis_kelamin = $data->kelamin;
		$user_penghuni->alamat = $data->alamat;
		$user_penghuni->kodepos = $data->kodepos;
		$user_penghuni->kota = $data->kota;
		$user_penghuni->propinsi = $data->propinsi;
		$user_penghuni->negara = $data->negara;
		$user_penghuni->agama = $data->agama;
		$user_penghuni->pekerjaan = $data->pekerjaan;
		$user_penghuni->warga_negara = $data->warga_negara;
		$user_penghuni->telepon = $data->telepon;
		$user_penghuni->instansi = $data->instansi;
		$user_penghuni->kontak_darurat = $data->kontak_darurat;
		$user_penghuni->nama_ortu_wali = $data->nama_ortu_wali;
		$user_penghuni->pekerjaan_ortu_wali = $data->pekerjaan_ortu_wali;
		$user_penghuni->alamat_ortu_wali = $data->alamat_ortu_wali;
		$user_penghuni->telepon_ortu_wali = $data->telepon_ortu_wali;
		$user_penghuni->save();

		Session::flash('status2','Pergantian data penghuni berhasil dilakukan.');		
		return redirect()->back();

	}
}
