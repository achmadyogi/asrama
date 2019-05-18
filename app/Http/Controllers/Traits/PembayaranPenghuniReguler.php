<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pembayaran;
use App\Daftar_asrama_reguler;
use App\Tagihan;
use App\User;
use dateTime;
use Carbon\Carbon;
use Session;

//Trait untuk mengambil data pembayaran untuk ValidasiPembayaranReguler
trait PembayaranPenghuniReguler {
    public function getPembayaranPenghuniReguler() {
        if(Pembayaran::where(['is_accepted' => 0])->count() > 0) {
            $pay_reg = DB::table('penangguhan')
                        ->rightjoin('pembayaran','pembayaran.id_pembayaran','=','penangguhan.id_pembayaran')
                        ->join('tagihan','tagihan.id_tagihan','=','pembayaran.id_tagihan')
                        ->join('daftar_asrama_reguler','tagihan.daftar_asrama_id','=','daftar_asrama_reguler.id_daftar')
                        ->join('users','daftar_asrama_reguler.id_user','=','users.id')
                        ->where('pembayaran.is_accepted','0')
                        ->select('*')
                        ->orderBy('name','asc')
                        ->paginate(10);
            $x = 0;
            //dd($pay_reg);
            foreach ($pay_reg as $reg) {
                    $tanggalBayar[$x] = $this->date($reg->tanggal_bayar);
                    
                    if(strlen($reg->jumlah_bayar) < 7 && strlen($reg->jumlah_bayar) > 3){
                        $jumlahBayar[$x] = "Rp".substr($reg->jumlah_bayar, -6, (strlen($reg->jumlah_bayar)-3)).".".substr($reg->jumlah_bayar, -3).",00";
                    }elseif(strlen($reg->jumlah_bayar) > 6 && strlen($reg->jumlah_bayar) < 10){
                        $jumlahBayar[$x] = "Rp".substr($reg->jumlah_bayar, -9, (strlen($reg->jumlah_bayar)-6)).".".substr($reg->jumlah_bayar, -6, (strlen($reg->jumlah_bayar)-4)).".".substr($reg->jumlah_bayar, -3).",00";
                    } 
                    $x += 1;
            }
            
        } else {
            $pay_reg = 0;
            $tanggalBayar = 0;
            $jumlahBayar = 0;
        }
        //dd($tanggalBayar);
        return (['bayar_reguler' => $pay_reg,
                 'tanggal_bayar' => $tanggalBayar,
                 'jumlah_bayar' => $jumlahBayar]);
    }

}

?>