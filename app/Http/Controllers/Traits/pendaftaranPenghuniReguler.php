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
use App\Daftar_asrama_reguler;
use App\Asrama;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;

trait pendaftaranPenghuniReguler{
	public function getPendaftaranPenghuniReguler(){
        	// Mendapatkan pendaftaran reguler yang belum tervalidasi
                if(Daftar_asrama_reguler::whereIn('verification', [0,4])->count() > 0){
                        $Reg = DB::table('daftar_asrama_reguler')
                                ->leftjoin('users', 'daftar_asrama_reguler.id_user', '=', 'users.id')
                                ->leftjoin('user_penghuni','daftar_asrama_reguler.id_user', '=', 'user_penghuni.id_user')
                                ->leftjoin('periodes','daftar_asrama_reguler.id_periode', '=', 'periodes.id_periode')
                                ->whereIn('daftar_asrama_reguler.verification', ['0','4'])
                                ->select('id_daftar','nama_periode', 'daftar_asrama_reguler.id_user', 'name','daftar_asrama_reguler.created_at', 'daftar_asrama_reguler.id_periode','preference', 'daftar_asrama_reguler.updated_at', 'daftar_asrama_reguler.verification', 'jenis_kelamin', 'status_beasiswa', 'lokasi_asrama', 'tanggal_masuk','is_difable', 'ket_difable', 'asrama')
                                ->paginate(10);
                        //$Reg = $Reg->items();
                        //$Reg = DB::select('SELECT * FROM `daftar_asrama_reguler` LEFT JOIN users ON daftar_asrama_reguler.id_user = users.id WHERE daftar_asrama_reguler.verification = 0');
                        $x = 0;
                        foreach ($Reg as $reg) {
                                $tanggalMasuk[$x] = $this->dateTanggal($reg->tanggal_masuk);
                                $tanggalDaftar[$x] = $this->date($reg->created_at);
                                $updated_at[$x] = $this->date($reg->updated_at);
                                $x += 1;
                        }
                }else{
                        $Reg = 0;
                        $tanggalMasuk = 0;
                        $tanggalDaftar = 0;
                        $updated_at = 0;
                }
                return (['tanggal_masuk' => $tanggalMasuk, 
                         'tanggal_daftar' => $tanggalDaftar,
                         'updated_at' => $updated_at,
                         'Reg' => $Reg]);
        }
}


?>