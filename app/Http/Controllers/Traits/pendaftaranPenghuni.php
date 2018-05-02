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
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;

trait pendaftaranPenghuni{
	public function getPendaftaranPenghuni(){
        	// Mendapatkan pendaftaran reguler yang belum tervalidasi
                if(Daftar_asrama_reguler::where(['verification' => 0])->count() > 0){
                        $Reg = DB::select('SELECT * FROM `daftar_asrama_reguler` LEFT JOIN users ON daftar_asrama_reguler.id_user = users.id WHERE daftar_asrama_reguler.verification = 0');
                        $i = 0;
                        foreach ($Reg as $rega) {
                                $tanggalMasuk[$i] = $this->dateTanggal($rega->tanggal_masuk);
                                $updated_at[$i] = $this->date($rega->updated_at);
                                $i += 1;

                        }
                }else{
                        $Reg = 0;
                        $tanggalMasuk = 0;
                        $updated_at = 0;
                }

                // Mendapatkan pendaftaran Non Reguler yang belum tervalidasi
                if(Daftar_asrama_non_reguler::where(['verification' => 0])->count() > 0){
                        $nonReg = DB::select('SELECT * FROM `daftar_asrama_non_reguler` LEFT JOIN users ON daftar_asrama_non_reguler.id_user = users.id WHERE daftar_asrama_non_reguler.verification = 0');
                        $i = 0;
                        foreach ($nonReg as $nonreg) {
                                $tanggalMasuk2[$i] = $this->dateTanggal($nonreg->tanggal_masuk);
                                $updated_at2[$i] = $this->date($nonreg->updated_at);
                                $i += 1;
                        }
                }else{
                        $nonReg = 0;
                        $tanggalMasuk2 = 0;
                        $updated_at2 = 0;
                }
                return (['tanggal_masuk' => $tanggalMasuk, 'updated_at' => $updated_at, 'tanggal_masuk2' => $tanggalMasuk2, 'updated_at2' => $updated_at2, 'nonReg' => $nonReg, 'Reg' => $Reg]);
        }
}


?>