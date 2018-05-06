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
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\pendaftaranPenghuni;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;
use App\Pembayaran;

class pembayaranPenghuniController extends Controller
{
    use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    use pendaftaranPenghuni;

    public function form(){
    	$user = Auth::User()->id;
    	// NON REGULER
    	$bayar_non = DB::select("SELECT id_daftar, id_user, tujuan_tinggal, bayar.id_tagihan, tanggal_bayar, nomor_transaksi,jumlah_bayar, bayar.keterangan, id_pembayaran, is_accepted FROM `daftar_asrama_non_reguler` RIGHT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, tanggal_bayar, nomor_transaksi, pembayaran.keterangan, id_pembayaran, is_accepted, jumlah_bayar FROM tagihan RIGHT JOIN pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler') AS bayar ON bayar.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE id_user = ?",[$user]);
    	$count = 0;
    	foreach ($bayar_non as $non) {
    		$tanggal_bayar[$count] = $this->date($non->tanggal_bayar);
    		$count += 1;
    	}
    	if($count == 0){
    		$tanggal_bayar = 0;
    		$non_exist = 0;
    	}else{
    		$non_exist = 1;
    	}

    	// REGULER
    	$bayar_reg = DB::select("SELECT id_daftar, id_user, nama_periode, periodes.id_periode, bayar.id_tagihan, tanggal_bayar, nomor_transaksi, bayar.keterangan, id_pembayaran, is_accepted FROM `daftar_asrama_reguler` RIGHT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, tanggal_bayar, nomor_transaksi, pembayaran.keterangan, id_pembayaran, is_accepted FROM tagihan RIGHT JOIN pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_reguler') AS bayar ON bayar.daftar_asrama_id = daftar_asrama_reguler.id_daftar LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode WHERE id_user = ?",[$user]);
    	$count = 0;
    	foreach ($bayar_reg as $reg) {
    		$tanggal_bayar_reg[$count] = $this->date($reg->tanggal_bayar);
    		$count += 1;
    	}
    	if($count == 0){
    		$tanggal_bayar_reg = 0;
    		$reg_exist = 0;
    	}else{
    		$reg_exist = 1;
    	}

    	// LIST UNTUK PEMBAYARAN DI FORM DROPDOWN
    	$list_non = DB::select("SELECT id_tagihan, id_daftar, id_user, tujuan_tinggal FROM daftar_asrama_non_reguler LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND tagihan.daftar_asrama_type = 'Daftar_asrama_non_reguler' WHERE id_user = ?",[$user]);
    	$list_reg = DB::select("SELECT id_tagihan, id_daftar, id_user, daftar_asrama_reguler.id_periode, nama_periode FROM daftar_asrama_reguler LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND tagihan.daftar_asrama_type = 'Daftar_asrama_reguler' LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode WHERE id_user = ?",[$user]);
    	Session::flash('menu','pembayaran_penghuni');
    	return view('dashboard.penghuni.pembayaranPenghuni',$this->getInitialDashboard())->with(['non_exist'=>$non_exist, 'bayar_non'=>$bayar_non, 'tanggal_bayar'=>$tanggal_bayar, 'reg_exist'=> $reg_exist, 'tanggal_bayar_reg'=>$tanggal_bayar_reg,'list_non'=>$list_non,'list_reg'=>$list_reg]);
    }

    // PENGUMPULAN PEMBAYARAN
    public function index(Request $request){
    	$this->Validate($request, [
    		'tanggal_bayar' => 'required|date',
    		'nomor_transaksi' => 'required',
    		'jumlah_bayar' => 'required'
    	]);
    	// DATA BASIC DARI SHOW FORM
    	$user = Auth::User()->id;
    	// NON REGULER
    	$bayar_non = DB::select("SELECT id_daftar, id_user, tujuan_tinggal, bayar.id_tagihan, tanggal_bayar, nomor_transaksi,jumlah_bayar, bayar.keterangan, id_pembayaran, is_accepted FROM `daftar_asrama_non_reguler` RIGHT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, tanggal_bayar, nomor_transaksi, pembayaran.keterangan, id_pembayaran, is_accepted, jumlah_bayar FROM tagihan RIGHT JOIN pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler') AS bayar ON bayar.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE id_user = ?",[$user]);
    	$count = 0;
    	foreach ($bayar_non as $non) {
    		$tanggal_bayar[$count] = $this->date($non->tanggal_bayar);
    		$count += 1;
    	}
    	if($count == 0){
    		$tanggal_bayar = 0;
    		$non_exist = 0;
    	}else{
    		$non_exist = 1;
    	}

    	// REGULER
    	$bayar_reg = DB::select("SELECT id_daftar, id_user, nama_periode, periodes.id_periode, bayar.id_tagihan, tanggal_bayar, nomor_transaksi, bayar.keterangan, id_pembayaran, is_accepted FROM `daftar_asrama_reguler` RIGHT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, tanggal_bayar, nomor_transaksi, pembayaran.keterangan, id_pembayaran, is_accepted FROM tagihan RIGHT JOIN pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_reguler') AS bayar ON bayar.daftar_asrama_id = daftar_asrama_reguler.id_daftar LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode WHERE id_user = ?",[$user]);
    	$count = 0;
    	foreach ($bayar_reg as $reg) {
    		$tanggal_bayar_reg[$count] = $this->date($reg->tanggal_bayar);
    		$count += 1;
    	}
    	if($count == 0){
    		$tanggal_bayar_reg = 0;
    		$reg_exist = 0;
    	}else{
    		$reg_exist = 1;
    	}

    	// LIST UNTUK PEMBAYARAN DI FORM DROPDOWN
    	$list_non = DB::select("SELECT id_tagihan, id_daftar, id_user, tujuan_tinggal FROM daftar_asrama_non_reguler LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND tagihan.daftar_asrama_type = 'Daftar_asrama_non_reguler' WHERE id_user = ?",[$user]);
    	$list_reg = DB::select("SELECT id_tagihan, id_daftar, id_user, daftar_asrama_reguler.id_periode, nama_periode FROM daftar_asrama_reguler LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND tagihan.daftar_asrama_type = 'Daftar_asrama_reguler' LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode WHERE id_user = ?",[$user]);
    	if(Pembayaran::where(['nomor_transaksi'=>$request->nomor_transaksi])->count() > 0) {
    		Session::flash('status1','Pembayaran Anda sudah kami rekam.');
    		return redirect()->back();
    	}else{
	    	// FILE UPLOAD
	    	// Mencari id pembayaran untuk nama
	    	$id_bayar = DB::select('SELECT MAX(id_pembayaran) FROM pembayaran');
	    	$i = 0;
	    	foreach ($id_bayar as $id_bayar) {
	    		$i += 1;
	    	}
	    	if($i == 0){
	    		$bayar_img = 1;
	    	}else{
	    		$bayar_img = $i+1;
	    	}
	    	// Retrieve file from post method
			$file = $_FILES['file'];
			
			// Get file properties
			$fileName = $file['name'];
			$fileTmpName = $file['tmp_name'];
			$fileSize = $file['size'];
			$fileError = $file['error']; //is this file or not
			$fileType = $file['type'];
			
			//Separate name and file extension
			$fileExt = explode('.', $fileName);
			//Set to always lowercase
			$fileActualExt = strtolower(end($fileExt));
			
			//Set any extension allowed
			$allowed = array('jpg','jpeg','png');
			
			//Check whether file extension is allowed
			if(in_array($fileActualExt, $allowed)){
				if($fileError === 0){
					//Check file size criteria
					if($fileSize <= 1000000){
						//Define your custom file name
						$fileNameNew = $request->list.".".$fileActualExt;
						//Define file destination
						$fileDestination = 'img/pembayaran/'.$fileNameNew;
						//php uploading files
						move_uploaded_file($fileTmpName, $fileDestination);
						
					} else{
						Session::flash('status1','Ukuran file terlalu besar. Maksimal file yang diperbolehkan adalah 1MB');
						return view('dashboard.penghuni.pembayaranPenghuni',$this->getInitialDashboard())->with(['non_exist'=>$non_exist, 'bayar_non'=>$bayar_non, 'tanggal_bayar'=>$tanggal_bayar, 'reg_exist'=> $reg_exist, 'tanggal_bayar_reg'=>$tanggal_bayar_reg,'list_non'=>$list_non,'list_reg'=>$list_reg]);
					}
				} else{
					Session::flash('status1','Upload gagal dilakukan');
						return view('dashboard.penghuni.pembayaranPenghuni',$this->getInitialDashboard())->with(['non_exist'=>$non_exist, 'bayar_non'=>$bayar_non, 'tanggal_bayar'=>$tanggal_bayar, 'reg_exist'=> $reg_exist, 'tanggal_bayar_reg'=>$tanggal_bayar_reg,'list_non'=>$list_non,'list_reg'=>$list_reg]);
				}
			} else{
				Session::flash('status1','Ekstensi tersebut tidak diperbolehkan. Gunakan jpg, jpeg, atau png.');
						return view('dashboard.penghuni.pembayaranPenghuni',$this->getInitialDashboard())->with(['non_exist'=>$non_exist, 'bayar_non'=>$bayar_non, 'tanggal_bayar'=>$tanggal_bayar, 'reg_exist'=> $reg_exist, 'tanggal_bayar_reg'=>$tanggal_bayar_reg,'list_non'=>$list_non,'list_reg'=>$list_reg]);
			}
			$pay = Pembayaran::create([
				'id_tagihan' => $request->list,
				'tanggal_bayar' => $request->tanggal_bayar,
				'nomor_transaksi' => $request->nomor_transaksi,
				'jumlah_bayar' => $request->jumlah_bayar,
				'file'=>$fileNameNew,
				'is_accepted' => 0,
			]);
			Session::flash('status2','Upload berhasil dilakukan');
	    	Session::flash('menu','pembayaran_penghuni');
	    	return view('dashboard.penghuni.pembayaranPenghuni',$this->getInitialDashboard())->with(['non_exist'=>$non_exist, 'bayar_non'=>$bayar_non, 'tanggal_bayar'=>$tanggal_bayar, 'reg_exist'=> $reg_exist, 'tanggal_bayar_reg'=>$tanggal_bayar_reg,'list_non'=>$list_non,'list_reg'=>$list_reg]);
	    }
    }
}
