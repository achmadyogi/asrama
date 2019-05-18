<?php

namespace App\Http\Controllers\sekretariat;

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
use Mail;
use App\Mail\VerifikasiReguler;
use App\Mail\VerifikasiNonReguler;
use App\Asrama;

class periksaPenghuniAktifController extends Controller
{
    use initialDashboard;
	use tanggalWaktu;
	use tanggal;
	use editPeriode;
    use pendaftaranPenghuni;

    public function index(){
    	$asrama = Asrama::all();
    	Session::flash('menu','periksa_penghuni_aktif');
    	return view('dashboard.sekretariat.periksaPenghuniAktif', $this->getInitialDashboard())->with(['asrama'=>$asrama]);
    }

    public function periksaPenghuniAktif(request $request){
    	$id_asrama = $request->asrama;
        $jalur = $request->jalur;
        // Reguler
        if($jalur == 1){
            $rincian = DB::select("
                SELECT id_daftar, name, email, daftar_asrama_reguler.id_user, periodes.id_periode, nama_periode, status_beasiswa, has_penyakit, ket_penyakit, jenis_kelamin, prod.nim, prod.registrasi, prod.id_prodi, prod.nama_prodi, place.id_asrama, place.id_kamar, place.kamar, place.gedung, place.id_gedung FROM daftar_asrama_reguler 
                LEFT JOIN 
                (
                    SELECT daftar_asrama_id, daftar_asrama_type, kamar_penghuni.id_kamar, room.id_gedung, room.id_asrama, kamar, gedung FROM kamar_penghuni 
                    LEFT JOIN 
                    (  
                        SELECT kamar.id_kamar, gedung.id_gedung, kamar.nama AS kamar, gedung.nama AS gedung, gedung.id_asrama  FROM kamar 
                        LEFT JOIN gedung ON gedung.id_gedung = kamar.id_gedung
                    ) AS room ON room.id_kamar = kamar_penghuni.id_kamar
                ) AS place ON place.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND place.daftar_asrama_type = 'Daftar_asrama_reguler' 
                LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
                LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode 
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user 
                LEFT JOIN 
                (
                    SELECT id_user, nim, registrasi, prodi.id_prodi, nama_prodi FROM user_nim 
                    LEFT JOIN prodi ON prodi.id_prodi = user_nim.id_prodi
                ) AS prod ON prod.id_user = daftar_asrama_reguler.id_user WHERE daftar_asrama_reguler.verification = 5 AND place.id_asrama = ? ORDER BY place.kamar ASC",[$id_asrama]);
            $type = "reguler";
        }elseif($jalur == 2){
            $rincian = DB::select("
                SELECT id_daftar, name, email, daftar_asrama_non_reguler.id_user, tujuan_tinggal, tempo, lama_tinggal,  jenis_kelamin, place.id_asrama, place.id_kamar, place.kamar, place.gedung, place.id_gedung FROM daftar_asrama_non_reguler 
                LEFT JOIN 
                (
                    SELECT daftar_asrama_id, daftar_asrama_type, kamar_penghuni.id_kamar, room.id_gedung, room.id_asrama, kamar, gedung FROM kamar_penghuni 
                    LEFT JOIN 
                    (  
                        SELECT kamar.id_kamar, gedung.id_gedung, kamar.nama AS kamar, gedung.nama AS gedung, gedung.id_asrama  FROM kamar 
                        LEFT JOIN gedung ON gedung.id_gedung = kamar.id_gedung
                    ) AS room ON room.id_kamar = kamar_penghuni.id_kamar
                ) AS place ON place.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND place.daftar_asrama_type = 'Daftar_asrama_non_reguler' 
                LEFT JOIN users ON users.id = daftar_asrama_non_reguler.id_user 
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_non_reguler.id_user 
                WHERE daftar_asrama_non_reguler.verification = 5 AND place.id_asrama = ? ORDER BY place.kamar ASC",[$id_asrama]);
            $type = "non reguler";
        }
        // Detail Pencarian
        $asrama = Asrama::all();
        $asramaFilter = Asrama::find($id_asrama);
    	
    	Session::flash('menu','periksa_penghuni_aktif');
    	return view('dashboard.sekretariat.periksaPenghuniAktif', $this->getInitialDashboard())->with(['rincian'=>$rincian, 'type' => $type, 'asramaFilter' => $asramaFilter, 'asrama' => $asrama]);
    }
}
