<?php
namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User_nim;
use App\User_penghuni;
use App\Asrama;
use App\Next_periode;
use App\Periode;
use App\Blacklist;
use App\Keluar_asrama;
use App\kerusakan_kamar;
use App\Pengelola;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Kamar_penghuni;
use App\Tagihan;
use App\Checkout;
use App\Pembayaran;
use App\Fakultas;

trait initialDashboard{
	public function getInitialDashboard(){
	    // Get user ID
        $userID = Auth::User()->id;
        // Get user information
        $user = User::find($userID);
        // Mengambil data pada tabel reguler
        if(Daftar_asrama_reguler::where(['id_user'=>$userID])->count() < 1){
        	// passing variable
            $nama_kamar_reguler = 0;
            $nama_gedung_reguler = 0;
            $nama_asrama_reguler = 0;
            $total_reguler = 0;
            $out_reguler = 0;
            $bill_reguler = 0;
    	    $reguler = '0';
            $lunas_reguler = 0;
            $nama_periode = 0;
        }else{
            $reguler = User::find($userID)->Daftar_asrama_reguler;
            $i = 0;
            foreach ($reguler as $reg) {
                if(Kamar_penghuni::where(['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler'])->count() > 0){
                    // ambil data dari tabel kamar_penghuni + kamar + gedung + asrama
                    $rinci_reguler = DB::select("SELECT kamar_penghuni.id_kamar, daftar_asrama_id, daftar_asrama_type, bangunan.id_gedung, bangunan.id_asrama, bangunan.nama, bangunan.building, room FROM kamar_penghuni LEFT JOIN (SELECT kamar.id_kamar,kamar.nama as room, kamar.id_gedung, dorm.id_asrama, dorm.building, dorm.nama FROM kamar LEFT JOIN (SELECT gedung.id_gedung, gedung.nama as building, gedung.id_asrama, asrama.nama FROM gedung LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama) AS dorm ON kamar.id_gedung = dorm.id_gedung) AS bangunan ON kamar_penghuni.id_kamar = bangunan.id_kamar WHERE daftar_asrama_id = :id_daftar AND daftar_asrama_type = :type",['id_daftar'=>$reg->id_daftar, 'type'=> 'Daftar_asrama_reguler']);
                    foreach ($rinci_reguler as $rinci) {
                            $nama_kamar_reguler[$i] = $rinci->room;
                            $nama_gedung_reguler[$i] = $rinci->building;
                            $nama_asrama_reguler[$i] = $rinci->nama;
                    }
                    // ambil data tagihan
                    $tagih_reguler = DB::select("SELECT * FROM tagihan WHERE daftar_asrama_id = :daftar_asrama_id AND daftar_asrama_type = :daftar_asrama_type", ['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler']);
                    foreach ($tagih_reguler as $tagih) {
                        $jumlah_tagihan_reguler = $tagih->jumlah_tagihan;
                        if(strlen($jumlah_tagihan_reguler) < 7 && strlen($jumlah_tagihan_reguler) > 3){
                            $total_reguler[$i] = "Rp".substr($jumlah_tagihan_reguler, -6, (strlen($jumlah_tagihan_reguler)-3)).".".substr($jumlah_tagihan_reguler, -3).",00";
                        }elseif(strlen($jumlah_tagihan_reguler) > 6 && strlen($jumlah_tagihan_reguler) < 10){
                            $total_reguler[$i] = "Rp".substr($jumlah_tagihan_reguler, -9, (strlen($jumlah_tagihan_reguler)-6)).".".substr($jumlah_tagihan_reguler, -6, (strlen($jumlah_tagihan_reguler)-4)).".".substr($jumlah_tagihan_reguler, -3).",00";
                        }else{
                            $total_reguler[$i] = "Rp".$jumlah_tagihan_reguler.",00";
                        }
                    }
                    // Ambil data pembayaran
                    $bayar_reguler = DB::select("SELECT pembayaran.id_tagihan, pembayaran.is_accepted, pembayaran.jumlah_bayar, data.jumlah_tagihan, data.id_daftar FROM pembayaran RIGHT JOIN (SELECT jumlah_tagihan, id_daftar, id_tagihan FROM tagihan LEFT JOIN daftar_asrama_reguler ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'daftar_asrama_reguler' AND id_daftar = ?) AS data ON data.id_tagihan = pembayaran.id_tagihan WHERE pembayaran.is_accepted = 1",[$reg->id_daftar]);
                    $j = 0;
                    $total_bayar_reguler = 0;
                    foreach ($bayar_reguler as $bayar) {
                            $total_bayar_reguler = $total_bayar_reguler + $bayar->jumlah_bayar;
                            
                            $j += 1;
                    }
                    if($total_bayar_reguler == 0){
                            $bill_reguler[$i] = 0;
                    }else{
                        if(strlen($total_bayar_reguler) < 7 && strlen($total_bayar_reguler) > 3){
                                $bill_reguler[$i] = "Rp".substr($total_bayar_reguler, -6, (strlen($total_bayar_reguler)-3)).".".substr($total_bayar_reguler, -3).",00";
                        }elseif(strlen($total_bayar_reguler) > 6 && strlen($total_bayar_reguler) < 10){
                                $bill_reguler[$i] = "Rp".substr($total_bayar_reguler, -9, (strlen($total_bayar_reguler)-6)).".".substr($total_bayar_reguler, -6, (strlen($total_bayar_reguler)-4)).".".substr($total_bayar_reguler, -3).",00";
                        }
                    }

                    // Periksa apakah sudah lunas atau belum
                    if($total_bayar_reguler - $jumlah_tagihan_reguler < 0){
                            $lunas_reguler[$i] = 1;
                    }else{
                            $lunas_reguler[$i] = 2;
                    }
                    // periksa apakah sudah check out
                    if(Checkout::where(['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler'])->count() >= 1){
                            $out_reguler[$i] = "Checkout";
                    }else{
                            $out_reguler[$i] = "Aktif";
                    }
                }else{
                    // passing variable
                    $nama_kamar_reguler[$i] = 0;
                    $nama_gedung_reguler[$i] = 0;
                    $nama_asrama_reguler[$i] = 0;
                    $total_reguler[$i] = 0;
                    $out_reguler[$i] = 0;
                    $bill_reguler[$i] = 0;
                    $lunas_reguler[$i] = 0;
                }
                // Ambil periode
                $take_period = Daftar_asrama_reguler::find($reg->id_daftar)->id_periode;
                $nama_periode[$i] = Periode::find($take_period)->nama_periode;
                $i += 1;
            }
        }
        // Mengambil data pada tabel non reguler
        if(Daftar_asrama_non_reguler::where(['id_user'=>$userID])->count() < 1){
                // passing variable
                $nama_kamar = 0;
                $nama_gedung = 0;
                $nama_asrama = 0;
                $total = 0;
                $out = 0;
                $bill = 0;
        	    $nonReguler = '0';
                $lunas = 0;
        }else{
        	$nonReguler = User::find($userID)->Daftar_asrama_non_reguler;
            // Memeriksa pendaftaran sudah tervalidasi atau belum
            $x = 0;
            foreach ($nonReguler as $nonReg) {
            if(Kamar_penghuni::where(['daftar_asrama_id'=>$nonReg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_non_reguler'])->count() > 0){
                // ambil data dari tabel kamar_penghuni + kamar + gedung + asrama
                $rinci = DB::select("SELECT kamar_penghuni.id_kamar, daftar_asrama_id, daftar_asrama_type, bangunan.id_gedung, bangunan.id_asrama, bangunan.nama, bangunan.building, room FROM kamar_penghuni LEFT JOIN (SELECT kamar.id_kamar,kamar.nama as room, kamar.id_gedung, dorm.id_asrama, dorm.building, dorm.nama FROM kamar LEFT JOIN (SELECT gedung.id_gedung, gedung.nama as building, gedung.id_asrama, asrama.nama FROM gedung LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama) AS dorm ON kamar.id_gedung = dorm.id_gedung) AS bangunan ON kamar_penghuni.id_kamar = bangunan.id_kamar WHERE daftar_asrama_id = :id_daftar AND daftar_asrama_type = :type",['id_daftar'=>$nonReg->id_daftar, 'type'=> 'Daftar_asrama_non_reguler']);
                foreach ($rinci as $rinci) {
                    $nama_kamar[$x] = $rinci->room;
                    $nama_gedung[$x] = $rinci->building;
                    $nama_asrama[$x] = $rinci->nama;
                }
                // ambil data tagihan
                $tagih = DB::select("SELECT * FROM tagihan WHERE daftar_asrama_id = :daftar_asrama_id AND daftar_asrama_type = :daftar_asrama_type", ['daftar_asrama_id'=>$nonReg->id_daftar, 'daftar_asrama_type'=>'daftar_asrama_non_reguler']);
                foreach ($tagih as $tagih) {
                    $jumlah_tagihan = $tagih->jumlah_tagihan;
                    if(strlen($jumlah_tagihan) < 7 && strlen($jumlah_tagihan) > 3){
                        $total[$x] = "Rp".substr($jumlah_tagihan, -6, (strlen($jumlah_tagihan)-3)).".".substr($jumlah_tagihan, -3).",00";
                    }elseif(strlen($jumlah_tagihan) > 6 && strlen($jumlah_tagihan) < 10){
                        $total[$x] = "Rp".substr($jumlah_tagihan, -9, (strlen($jumlah_tagihan)-6)).".".substr($jumlah_tagihan, -6, (strlen($jumlah_tagihan)-4)).".".substr($jumlah_tagihan, -3).",00";
                    }
                }
                // Ambil data pembayaran
                $bayar = DB::select("SELECT pembayaran.id_tagihan, pembayaran.jumlah_bayar, data.jumlah_tagihan, data.id_daftar FROM pembayaran RIGHT JOIN (SELECT jumlah_tagihan, id_daftar, id_tagihan FROM tagihan LEFT JOIN daftar_asrama_non_reguler ON tagihan.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'daftar_asrama_non_reguler' AND id_daftar = ?) AS data ON data.id_tagihan = pembayaran.id_tagihan WHERE pembayaran.is_accepted = 1",[$nonReg->id_daftar]);
                $y = 0;
                $total_bayar = 0;
                foreach ($bayar as $bayar) {
                    $total_bayar = $total_bayar + $bayar->jumlah_bayar;
                    $y += 1;
                }
                if($y == 0 || $y == 1 && $bayar->jumlah_bayar == NULL){
                    $bill[$x] = 0;
                }else{
                    if(strlen($total_bayar) < 7 && strlen($total_bayar) > 3){
                        $bill[$x] = "Rp".substr($total_bayar, -6, (strlen($total_bayar)-3)).".".substr($total_bayar, -3).",00";
                    }elseif(strlen($total_bayar) > 6 && strlen($total_bayar) < 10){
                        $bill[$x] = "Rp".substr($total_bayar, -9, (strlen($total_bayar)-6)).".".substr($total_bayar, -6, (strlen($total_bayar)-4)).".".substr($total_bayar, -3).",00";
                    }
                }
                // Periksa apakah sudah lunas atau belum
                if($total_bayar - $jumlah_tagihan < 0){
                    $lunas[$x] = 1;
                }else{
                    $lunas[$x] = 2;
                }
                // periksa apakah sudah check out
                if(Checkout::where(['daftar_asrama_id'=>$nonReg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_non_reguler'])->count() >= 1){
                    $out[$x] = "Checkout";
                }else{
                    $out[$x] = "Aktif";
                }
                $x += 1;
            }
        }
        if($x == 0){
            // passing variable
            $nama_kamar[$x] = 0;
            $nama_gedung[$x] = 0;
            $nama_asrama[$x] = 0;
            $total[$x] = 0;
            $out[$x] = 0;
            $bill[$x] = 0;
            $lunas[$x] = 0;
        }
        }
        // Mengambil data dari nim penghuni
        if(User_penghuni::where(['id_user'=>$userID])->count() < 1){
        	$userPenghuni = '0';
        }else{
        	$userPenghuni = User::find($userID)->user_penghuni;
        }
        // Mengambil data nim user
        if(User_nim::where(['id_user'=>$userID])->count() < 1){
        	$userNim = '0';
        }else{
        	$userNim = User::find($userID)->user_nim;
        }
        // Mengambil data pengelola
        if(Pengelola::where(['id_user'=>$userID])->count() < 1){
        	$pengelola = '0';
        	$pengelolaAsrama = '0';
        }else{
        	$pengelola = User::find($userID)->pengelola;
        	$pengelolaAsrama = Pengelola::find($pengelola->id_pengelola)->asrama;
        }
        // Mengambil data fakultas dan jurusan
        $fakultas = Fakultas::all();
        $asrama = Asrama::all();
        
        $prodiUser = DB::select('SELECT * from user_nim,prodi,fakultas WHERE user_nim.id_prodi = prodi.id_prodi AND prodi.id_fakultas = fakultas.id_fakultas AND user_nim.id_user = ?',[$userID]);
        $asramaUser = DB::select('SELECT kamar.nama as kamar, asrama.nama as asrama from daftar_asrama_reguler,kamar_penghuni,kamar,gedung,asrama WHERE daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id AND kamar_penghuni.id_kamar = kamar.id_kamar AND kamar.id_gedung = gedung.id_gedung AND gedung.id_asrama = asrama.id_asrama AND daftar_asrama_reguler.id_user = ?',[$userID]);
        $periodeUser = DB::select('SELECT * from daftar_asrama_reguler,periodes WHERE daftar_asrama_reguler.id_periode = periodes.id_periode AND daftar_asrama_reguler.id_user = ?',[$userID]);
        
         //Syarat_data untuk surat keluar
        $data_syarat = DB::select('SELECT daftar_asrama_reguler.id_daftar, tagihan.id_tagihan, periodes.nama_periode, pembayaran.jumlah_bayar, tagihan.jumlah_tagihan,pembayaran.is_accepted
                                   from users, daftar_asrama_reguler, tagihan, pembayaran, periodes WHERE users.id = daftar_asrama_reguler.id_user AND
                                   daftar_asrama_reguler.id_daftar = tagihan.daftar_asrama_id AND tagihan.id_tagihan = pembayaran.id_tagihan AND 
                                   daftar_asrama_reguler.id_periode = periodes.id_periode AND users.id = ? AND daftar_asrama_reguler.verification = 5',[$userID]);
        
        //Menghitung jumlah uang yang sudah dibayarkan
        $jumlah_bayar=0;
        $status = 0;
        if(isset($data_syarat)){
                foreach($data_syarat as $data) {
                        if($data->is_accepted = 1) {
                          $jumlah_bayar += $data->jumlah_bayar; 
                          if ($data->jumlah_tagihan > $jumlah_bayar) {
                        $status = 0;
                } else {
                        $status = 1;
                }
                        }
                }
                
        } else {
                $jumlah_bayar = 0;
                $data_syarat = 0;
                $status = 0;
        }
        
        
        //Mengambil data apakah calon penghuni merupakan penghuni aktif
        $data_penghuni=DB::select('SELECT * FROM daftar_asrama_reguler WHERE id_user = ? AND verification = 5',[$userID]);
        $pass_penghuni=0;
        if(isset($data_penghuni)){
            foreach($data_penghuni as $data) {
                $pass_penghuni++;
            }    
        } else {
            $pass_penghuni = 0;
        }
        

        return (['reguler'=>$reguler,
        	        'nonReguler'=>$nonReguler,
        		'userNim'=>$userNim,
        		'userPenghuni'=>$userPenghuni,
        		'user'=>$user,
                        'pengelola'=>$pengelola,
        		'pengelolaAsrama'=>$pengelolaAsrama,
                        'nama_kamar'=>$nama_kamar,
                        'nama_kamar_reguler'=>$nama_kamar_reguler,
                        'nama_gedung' =>$nama_gedung,
                        'nama_gedung_reguler'=>$nama_gedung_reguler,
                        'nama_asrama' =>$nama_asrama,
                        'nama_asrama_reguler' =>$nama_asrama_reguler,
                        'total' => $total,
                        'total_reguler' => $total_reguler,
                        'out' => $out,
                        'out_reguler' => $out_reguler,
                        'bill' => $bill,
                        'bill_reguler' => $bill_reguler,
                        'lunas' => $lunas,
                        'lunas_reguler' => $lunas_reguler,
                        'fakultas'=>$fakultas,
                        'asrama'=>$asrama,
                        'prodi' => 0,
                        'asramaUser' => $asramaUser,
                        'prodiUser' => $prodiUser,
                        'periodeUser' => $periodeUser,
                        'nama_periode' => $nama_periode,
                        'data_syarat'=>$data_syarat,
                        'jumlah_bayar'=>$jumlah_bayar,
                        'status'=>$status,
                        'pass_penghuni'=>$pass_penghuni]);
	}
}
?>