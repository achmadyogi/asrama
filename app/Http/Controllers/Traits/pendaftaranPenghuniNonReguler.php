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
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;

trait pendaftaranPenghuniNonReguler{
	public function getPendaftaranPenghuniNonReguler(){
                
        if(Daftar_asrama_non_reguler::whereIn('verification',[0,4])->count() > 0){
            $nonReg = DB::table('daftar_asrama_non_reguler')
                    ->leftjoin('users', 'daftar_asrama_non_reguler.id_user', '=', 'users.id')
                    ->whereIn('daftar_asrama_non_reguler.verification', ['0','4'])
                    ->select('*')
                    ->paginate(10);
            //$nonReg = $nonReg->items();
            //$nonReg = DB::select("SELECT * FROM `daftar_asrama_non_reguler` LEFT JOIN users ON daftar_asrama_non_reguler.id_user = users.id WHERE daftar_asrama_non_reguler.verification = 0");
            $i = 0;
            foreach ($nonReg as $nonreg) {
                $tanggalMasuk2[$i] = $this->dateTanggal($nonreg->tanggal_masuk);
                $tanggalDaftar2[$i] = $this->date($nonreg->created_at);
                $updated_at2[$i] = $this->date($nonreg->updated_at);
                $i += 1; 
            } 
        }else{
                $nonReg = 0;
                $tanggalMasuk2 = 0;
                $tanggalDaftar2 = 0;
                $updated_at2 = 0;
        }
        return (['tanggal_masuk2' => $tanggalMasuk2, 
                 'tanggal_daftar2' => $tanggalDaftar2, 
                 'updated_at2' => $updated_at2, 
                 'nonReg' => $nonReg]);
    }
}


?>