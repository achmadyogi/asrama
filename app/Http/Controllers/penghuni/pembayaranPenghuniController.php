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
use App\Penangguhan;
use ITBdorm;
use DormAuth;

class pembayaranPenghuniController extends Controller
{
    public function form(){
    	// NON REGULER
        $bayar_non = ITBdorm::DataNonReguler(DormAuth::User()->id);

        // REGULER
        $bayar_reg = ITBdorm::DataReguler(DormAuth::User()->id);

    	Session::flash('menu','pembayaran_penghuni');
    	return view('dashboard.penghuni.pembayaranPenghuni',[
            'bayar_non' => $bayar_non,
            'bayar_reg' => $bayar_reg]);
	}
	
	public function formRekening(){
    	// NON REGULER
        $bayar_non = ITBdorm::DataNonReguler(DormAuth::User()->id);

        // REGULER
        $bayar_reg = ITBdorm::DataReguler(DormAuth::User()->id);

        Session::flash('menu','pembayaran_penghuni_rekening');
        return view('dashboard.penghuni.pembayaranPenghuniRekening',[
            'bayar_non' => $bayar_non,
            'bayar_reg' => $bayar_reg]);
	}
	
	public function formPenangguhan(){
        // REGULER
        $bayar_reg = ITBdorm::DataReguler(DormAuth::User()->id);

    	Session::flash('menu','penangguhan_penghuni');
    	return view('dashboard.penghuni.penangguhanPembayaran', ['bayar_reg'=>$bayar_reg]);
    }

    // PENGUMPULAN PEMBAYARAN
    public function index(Request $request){
    	$this->Validate($request, [
    		'tanggal_bayar' => 'required|date',
    		'nomor_transaksi' => 'required',
    		'jumlah_bayar' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|required'
    	]);
    	if(Pembayaran::where(['nomor_transaksi'=>$request->nomor_transaksi])->count() > 0) {
    		Session::flash('status1','Nomor transaksi sudah terdaftar. Silahkan periksa kembali data pembayaran Anda apabila sudah melakukan upload bukti pembayaran!');
    		return redirect()->back();
    	}else{
	    	// FILE UPLOAD

	    	// Retrieve file from post method
			$file = $_FILES['file'];
			
			// Get file properties
			$fileSize = $file['size'];

            //Check file size criteria
            if($fileSize >= 500000){
                Session::flash('status1','Ukuran file terlalu besar. Maksimal file yang diperbolehkan adalah 500 KB');
                return redirect()->back();
            }

            $uploadFile = $request->file('file');
            $path = $uploadFile->store('public/pembayaran');

			$pay = new Pembayaran();
			$pay->id_tagihan = $request->list;
			$pay->tanggal_bayar = $request->tanggal_bayar;
			$pay->nomor_transaksi = $request->nomor_transaksi;
			$pay->jumlah_bayar = $request->jumlah_bayar;
			$pay->jenis_pembayaran = 0;
			$pay->nama_pengirim = '-';
			$pay->bank_asal = '-';
			$pay->file = $path;
			$pay->is_accepted = 0;
			$pay->save();

			Session::flash('status2','Upload berhasil dilakukan');
	    	Session::flash('menu','pembayaran_penghuni');
	    	return redirect()->back();
	    }
	}
	
	public function indexRekening(Request $request){
    	$this->Validate($request, [
    		'tanggal_bayar' => 'required|date',
    		'nomor_transaksi' => 'required',
			'jumlah_bayar' => 'required',
			'nama_pengirim' => 'required',
			'bank_asal' => 'required',
			'keterangan' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|required'
    	]);
    	if(Pembayaran::where(['nomor_transaksi'=>$request->nomor_transaksi])->count() > 0) {
    		Session::flash('status1','Nomor transaksi sudah terdaftar. Silahkan periksa kembali data pembayaran Anda apabila sudah melakukan upload bukti pembayaran!');
    		return redirect()->back();
    	}else{
	    	// FILE UPLOAD
	    	// Retrieve file from post method
			$file = $_FILES['file'];
			
			// Get file properties
			$fileSize = $file['size'];

            //Check file size criteria
            if($fileSize >= 500000){
                Session::flash('status1','Ukuran file terlalu besar. Maksimal file yang diperbolehkan adalah 500 KB');
                return redirect()->back();
            }

            $uploadFile = $request->file('file');
            $path = $uploadFile->store('public/pembayaran');
			
			$pay = new Pembayaran();
			$pay->id_tagihan = $request->list;
			$pay->tanggal_bayar = $request->tanggal_bayar;
			$pay->nomor_transaksi = $request->nomor_transaksi;
			$pay->jumlah_bayar = $request->jumlah_bayar;
			$pay->jenis_pembayaran = 1;
			$pay->nama_pengirim = $request->nama_pengirim;
			$pay->bank_asal = $request->bank_asal;
			$pay->keterangan = $request->keterangan;
			$pay->file = $path;
			$pay->is_accepted = 0;
			$pay->save();
			Session::flash('status2','Upload berhasil dilakukan');
	    	Session::flash('menu','pembayaran_penghuni_rekening');
	    	return redirect()->back();
	    }
	}
	
	public function indexPenangguhan(Request $request){
    	$this->Validate($request, [
    		'jumlah_tangguhan' => 'required',
    		'terbilang' => 'required',
			'rincian_bulan' => 'required',
			'alasan' => 'required',
			'pelunasan' => 'required|date'
    	]);

		// Pemeriksaan data penangguhan
    	if(Penangguhan::where(['id_tagihan' => $request->list])->count() < 1){

            $pay = new Penangguhan();
            $pay->id_tagihan = $request->list;
            $pay->jumlah_tangguhan = $request->jumlah_tangguhan;
            $pay->alasan_penangguhan = $request->alasan;
            $pay->deadline_pembayaran = $request->pelunasan;
            $pay->is_sktm = 0;
            $pay->formulir_penangguhan = 0;
            $pay->is_bayar = 0;
            $pay->save();

            Session::flash('status2','Form berhasil di upload');
            return redirect()->back();
        }else{
            Session::flash('status1','Periode tinggal tersebut sudah ditangguhkan. Penangguhan hanya dapat dilakukan satu kali. Silahkan lihat list penangguhan Anda.');
            return redirect()->back();
        }
	
    }
}
