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
                $nama_asrama_reguler = 0;
                $total_reguler = 0;
                $out_reguler = 0;
                $bill_reguler = 0;
        	$reguler = '0';
                $lunas_reguler = 0;
        }else{
                $reguler = User::find($userID)->Daftar_asrama_reguler;
                $i = 0;
                foreach ($reguler as $reg) {
                        if(Kamar_penghuni::where(['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler'])->count() > 0){
                                // ambil data dari tabel kamar_penghuni + kamar + gedung + asrama
                                $rinci_reguler = DB::select("SELECT kamar_penghuni.id_kamar, daftar_asrama_id, daftar_asrama_type, bangunan.id_gedung, bangunan.id_asrama, bangunan.nama, room FROM kamar_penghuni LEFT JOIN (SELECT kamar.id_kamar,kamar.nama as room, kamar.id_gedung, dorm.id_asrama, dorm.nama FROM kamar LEFT JOIN (SELECT gedung.id_gedung, gedung.id_asrama, asrama.nama FROM gedung LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama) AS dorm ON kamar.id_gedung = dorm.id_gedung) AS bangunan ON kamar_penghuni.id_kamar = bangunan.id_kamar WHERE daftar_asrama_id = :id_daftar AND daftar_asrama_type = :type",['id_daftar'=>$reg->id_daftar, 'type'=> 'Daftar_asrama_reguler']);
                                foreach ($rinci_reguler as $rinci) {
                                        $nama_kamar_reguler[$i] = $rinci->room;
                                        $nama_asrama_reguler[$i] = $rinci->nama;
                                }
                                // ambil data tagihan
                                $tagih_reguler = DB::select("SELECT * FROM tagihan WHERE daftar_asrama_id = :daftar_asrama_id AND daftar_asrama_type = :daftar_asrama_type", ['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler']);
                                foreach ($tagih_reguler as $tagih) {
                                        $jumlah_tagihan_reguler = $tagih->jumlah_tagihan;
                                        if(strlen($jumlah_tagihan_reguler) < 7 && strlen($jumlah_tagihan_reguler) > 3){
                                                $total_reguler[$i] = "Rp".substr($jumlah_tagihan_reguler, -6, (strlen($jumlah_tagihan_reguler)-3)).".".substr($jumlah_tagihan_reguler, -3).",00";
                                        }elseif(strlen($jumlah_tagihan_reguler) > 6 && strlen($jumlah_tagihan_reguler) < 10){
                                                $total_reguler[$i] = "Rp".substr($jumlah_tagihan_reguler, -9, (strlen($jumlah_tagihan_reguler)-6)).".".substr($jumlah_tagihan_reguler, -6, (strlen($jumlah_tagihan_reguler)-3)).".".substr($jumlah_tagihan_reguler, -3).",00";
                                        }
                                }
                                // Ambil data pembayaran
                                $bayar_reguler = DB::select("SELECT pembayaran.id_tagihan, pembayaran.jumlah_bayar, data.jumlah_tagihan, data.id_daftar FROM pembayaran LEFT JOIN (SELECT jumlah_tagihan, id_daftar, id_tagihan FROM tagihan LEFT JOIN daftar_asrama_reguler ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'Daftar_asrama_reguler' AND id_daftar = ?) AS data ON data.id_tagihan = pembayaran.id_tagihan",[$reg->id_daftar]);
                                $j = 0;
                                $total_bayar_reguler = 0;
                                foreach ($bayar as $bayar) {
                                        $total_bayar_reguler = $total_bayar_reguler + $bayar_reguler->jumlah_bayar;
                                        $j += 1;
                                }
                                if($j == 0){
                                        $bill_reguler = 0;
                                }else{
                                        if(strlen($total_bayar_reguler) < 7 && strlen($total_bayar_reguler) > 3){
                                                $bill_reguler[$x] = "Rp".substr($total_bayar_reguler, -6, (strlen($total_bayar_reguler)-3)).".".substr($total_bayar_reguler, -3).",00";
                                        }elseif(strlen($total_bayar_reguler) > 6 && strlen($total_bayar_reguler) < 10){
                                                $bill_reguler[$x] = "Rp".substr($total_bayar_reguler, -9, (strlen($total_bayar_reguler)-6)).".".substr($total_bayar_reguler, -6, (strlen($total_bayar_reguler)-3)).".".substr($total_bayar_reguler, -3).",00";
                                        }
                                }
                                // Periksa apakah sudah lunas atau belum
                                if($total_bayar_reguler - $jumlah_tagihan_reguler < 0){
                                        $lunas_reguler = "Belum lunas";
                                }else{
                                        $lunas_reguler = "Lunas";
                                }
                                // periksa apakah sudah check out
                                if(Checkout::where(['daftar_asrama_id'=>$reg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_reguler'])->count() < 0){
                                        $out_reguler[$x] = "Checkout";
                                }else{
                                        $out_reguler[$x] = "Aktif";
                                }
                        }else{
                                // passing variable
                                $nama_kamar_reguler = 0;
                                $nama_asrama_reguler = 0;
                                $total_reguler = 0;
                                $out_reguler = 0;
                                $bill_reguler = 0;
                                $lunas_reguler = 0;
                        }
                        $i += 1;
                }
        }
        // Mengambil data pada tabel non reguler
        if(Daftar_asrama_non_reguler::where(['id_user'=>$userID])->count() < 1){
                // passing variable
                $nama_kamar = 0;
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
                                $rinci = DB::select("SELECT kamar_penghuni.id_kamar, daftar_asrama_id, daftar_asrama_type, bangunan.id_gedung, bangunan.id_asrama, bangunan.nama, room FROM kamar_penghuni LEFT JOIN (SELECT kamar.id_kamar,kamar.nama as room, kamar.id_gedung, dorm.id_asrama, dorm.nama FROM kamar LEFT JOIN (SELECT gedung.id_gedung, gedung.id_asrama, asrama.nama FROM gedung LEFT JOIN asrama ON gedung.id_asrama = asrama.id_asrama) AS dorm ON kamar.id_gedung = dorm.id_gedung) AS bangunan ON kamar_penghuni.id_kamar = bangunan.id_kamar WHERE daftar_asrama_id = :id_daftar AND daftar_asrama_type = :type",['id_daftar'=>$nonReg->id_daftar, 'type'=> 'Daftar_asrama_non_reguler']);
                                foreach ($rinci as $rinci) {
                                        $nama_kamar[$x] = $rinci->room;
                                        $nama_asrama[$x] = $rinci->nama;
                                }
                                // ambil data tagihan
                                $tagih = DB::select("SELECT * FROM tagihan WHERE daftar_asrama_id = :daftar_asrama_id AND daftar_asrama_type = :daftar_asrama_type", ['daftar_asrama_id'=>$nonReg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_non_reguler']);
                                foreach ($tagih as $tagih) {
                                        $jumlah_tagihan = $tagih->jumlah_tagihan;
                                        if(strlen($jumlah_tagihan) < 7 && strlen($jumlah_tagihan) > 3){
                                                $total[$x] = "Rp".substr($jumlah_tagihan, -6, (strlen($jumlah_tagihan)-3)).".".substr($jumlah_tagihan, -3).",00";
                                        }elseif(strlen($jumlah_tagihan) > 6 && strlen($jumlah_tagihan) < 10){
                                                $total[$x] = "Rp".substr($jumlah_tagihan, -9, (strlen($jumlah_tagihan)-6)).".".substr($jumlah_tagihan, -6, (strlen($jumlah_tagihan)-3)).".".substr($jumlah_tagihan, -3).",00";
                                        }
                                }
                                // Ambil data pembayaran
                                $bayar = DB::select("SELECT pembayaran.id_tagihan, pembayaran.jumlah_bayar, data.jumlah_tagihan, data.id_daftar FROM pembayaran LEFT JOIN (SELECT jumlah_tagihan, id_daftar, id_tagihan FROM tagihan LEFT JOIN daftar_asrama_non_reguler ON tagihan.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'Daftar_asrama_non_reguler' AND id_daftar = ?) AS data ON data.id_tagihan = pembayaran.id_tagihan",[$nonReg->id_daftar]);
                                $y = 0;
                                $total_bayar = 0;
                                foreach ($bayar as $bayar) {
                                        $total_bayar = $total_bayar + $bayar->jumlah_bayar;
                                        $y += 1;
                                }
                                if($y == 0){
                                        $bill = 0;
                                }else{
                                        if(strlen($total_bayar) < 7 && strlen($total_bayar) > 3){
                                                $bill[$x] = "Rp".substr($total_bayar, -6, (strlen($total_bayar)-3)).".".substr($total_bayar, -3).",00";
                                        }elseif(strlen($total_bayar) > 6 && strlen($total_bayar) < 10){
                                                $bill[$x] = "Rp".substr($total_bayar, -9, (strlen($total_bayar)-6)).".".substr($total_bayar, -6, (strlen($total_bayar)-3)).".".substr($total_bayar, -3).",00";
                                        }
                                }
                                // Periksa apakah sudah lunas atau belum
                                if($total_bayar - $jumlah_tagihan < 0){
                                        $lunas = "Belum lunas";
                                }else{
                                        $lunas = "Lunas";
                                }
                                // periksa apakah sudah check out
                                if(Checkout::where(['daftar_asrama_id'=>$nonReg->id_daftar, 'daftar_asrama_type'=>'Daftar_asrama_non_reguler'])->count() < 0){
                                        $out[$x] = "Checkout";
                                }else{
                                        $out[$x] = "Aktif";
                                }
                        }else{
                                // passing variable
                                $nama_kamar = 0;
                                $nama_asrama = 0;
                                $total = 0;
                                $out = 0;
                                $bill = 0;
                                $lunas = 0;
                        }
                        $x += 1;
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
        // Mengambil data jurusan dan fakultas dari User NIM bila ada
        return (['reguler'=>$reguler,
        	        'nonReguler'=>$nonReguler,
        		'userNim'=>$userNim,
        		'userPenghuni'=>$userPenghuni,
        		'user'=>$user,
                        'pengelola'=>$pengelola,
        		'pengelolaAsrama'=>$pengelolaAsrama,
                        'nama_kamar'=>$nama_kamar,
                        'nama_kamar_reguler'=>$nama_kamar_reguler,
                        'nama_asrama' =>$nama_asrama,
                        'nama_asrama_reguler' =>$nama_asrama_reguler,
                        'total' => $total,
                        'total_reguler' => $total_reguler,
                        'out' => $out,
                        'out_reguler' => $out_reguler,
                        'bill' => $bill,
                        'bill_reguler' => $bill_reguler,
                        'lunas' => $lunas,
                        'lunas_reguler' => $lunas_reguler]);
	}
}
?>