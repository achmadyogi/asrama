<?php

namespace App\Http\Controllers\keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\currency;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use App\Pembayaran;
use App\Asrama;
use App\Gedung;

class cekPembayaranController extends Controller
{
    use initialDashboard;
    use tanggalWaktu;
    use tanggal;
    use currency;

    public function index(){
        $periode = Periode::all();
        $gedung = DB::select("SELECT id_gedung, gedung.nama as gedung, gedung.id_asrama, asrama.nama as asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama");
    	session::flash('menu','keuangan_pembayaran_penghuni');
    	return view('dashboard.keuangan.cekPembayaran', $this->getInitialDashboard())->with(['gedung' => $gedung, 'periode' => $periode]);
    }

    public function tabelBayar(Request $request){
        // Prerequest
        $periode = Periode::all();
        $gedung = DB::select("SELECT id_gedung, gedung.nama as gedung, gedung.id_asrama, asrama.nama as asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama");

        // Ambil request
        $s_jalur = $request->jalur;
        $s_periode = $request->periode;
        $s_gedung = $request->gedung;

        // Memilah jalur pencarian hasil permintaan
        $kelunasan = $request->kelunasan;
            $user_reguler = DB::select("SELECT id_daftar, id_user, daftar_asrama_reguler.id_periode, nama_periode, verification, status_beasiswa, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_reguler LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL AND verification IN(5,6)");
            $y = 0;
            foreach ($user_reguler as $ur){
                    $r_id_user[$y] = $ur->id_user;
                    $r_id_periode[$y] = $ur->id_periode;
                    $r_nama_periode[$y] = $ur->nama_periode;
                    $r_status_beasiswa[$y] = $ur->status_beasiswa;
                    $r_kamar[$y] = $ur->kamar;
                    $r_id_gedung[$y] = $ur->id_gedung;
                    $r_gedung[$y] = $ur->gedung;
                    $r_asrama[$y] = $ur->asrama;
                    $r_jumlah_tagihan[$y] = $this->getCurrency($ur->jumlah_tagihan);
                    $r_keterangan[$y] = $ur->keterangan;
                    $r_total_bayar[$y] = $this->getCurrency($ur->total_bayar);
                    $r_deposit[$y] = $this->getCurrency($ur->total_bayar - $ur->jumlah_tagihan);
                    $r_depos[$y] = $ur->total_bayar - $ur->jumlah_tagihan;
                    $n_id_user[$y] = "";
                    $n_tujuan_tinggal[$y] = "";
                    $n_kamar[$y] = "";
                    $n_id_gedung[$y] = "";
                    $n_gedung[$y] = "";
                    $n_asrama[$y] = "";
                    $n_jumlah_tagihan[$y] = "";
                    $n_keterangan[$y] = "";
                    $n_total_bayar[$y] = "";
                    $n_deposit[$y] = "";
                    $n_depos[$y] = "";
                    $y += 1;
            }
            $user_non = DB::select("SELECT id_daftar, id_user, verification, tujuan_tinggal, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_non_reguler LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_non_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL AND verification IN(5,6)");
            foreach ($user_non as $un) {
                $n_id_user[$y] = $un->id_user;
                $n_tujuan_tinggal[$y] = $un->tujuan_tinggal;
                $n_kamar[$y] = $un->kamar;
                $n_id_gedung[$y] = $un->id_gedung;
                $n_gedung[$y] = $un->gedung;
                $n_asrama[$y] = $un->asrama;
                $n_jumlah_tagihan[$y] = $this->getCurrency($un->jumlah_tagihan);
                $n_keterangan[$y] = $un->keterangan;
                $n_total_bayar[$y] = $this->getCurrency($un->total_bayar);
                $n_deposit[$y] = $this->getCurrency($un->total_bayar - $un->jumlah_tagihan);
                $n_depos[$y] = $un->total_bayar - $un->jumlah_tagihan;
                $r_id_user[$y] = "";
                $r_id_periode[$y] = "";
                $r_nama_periode[$y] = "";
                $r_status_beasiswa[$y] = "";
                $r_kamar[$y] = "";
                $r_id_gedung[$y] = "";
                $r_gedung[$y] = "";
                $r_asrama[$y] = "";
                $r_jumlah_tagihan[$y] = "";
                $r_keterangan[$y] = "";
                $r_total_bayar[$y] = "";
                $r_deposit[$y] = "";
                $r_depos[$y] = "";
                $y += 1;
            }
    	
        // Ambil tabelnya
        $user = DB::select("
            SELECT id, name, email, foto_profil, prod.nama_prodi, prod.nim, prod.registrasi, pay.tagihan_total, pay.pembayaran, pay_non.tagihan_total_non, pay_non.pembayaran_non, nomor_identitas, jenis_identitas, jenis_kelamin, telepon, telepon_ortu_wali FROM users 
            LEFT JOIN 
            (
                SELECT user_nim.id_prodi, id_user, registrasi, nim, prodi.nama_prodi FROM user_nim 
                LEFT JOIN prodi ON prodi.id_prodi = user_nim.id_prodi
            ) AS prod ON prod.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total, sum(detail.total_bayar) as pembayaran FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted = 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_reguler ON daftar_asrama_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_reguler' AND daftar_asrama_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user
            ) AS pay ON pay.id_user = users.id 
            LEFT JOIN user_penghuni ON user_penghuni.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total_non, sum(detail.total_bayar) as pembayaran_non FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted= 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_non_reguler ON daftar_asrama_non_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' AND daftar_asrama_non_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user) AS pay_non ON pay_non.id_user = users.id WHERE pay.tagihan_total IS NOT NULL OR pay_non.tagihan_total_non IS NOT NULL");
        $x = 0;
        foreach ($user as $u) {
            $depos[$x] = $u->pembayaran + $u->pembayaran_non - $u->tagihan_total - $u->tagihan_total_non;
            // Filter lunas atau belum lunas
            if($request->kelunasan == 0 || $request->kelunasan == 1 && $depos[$x] >= 0 || $request->kelunasan == 2 && $depos[$x] < 0){
                $id[$x] = $u->id;
                $name[$x] = $u->name;
                $email[$x] = $u->email;
                $foto_profil[$x] = $u->foto_profil;
                $nama_prodi[$x] = $u->nama_prodi;
                $nim[$x] = $u->nim;
                $registrasi[$x] = $u->registrasi;
                $tagihan_total[$x] = $this->getCurrency($u->tagihan_total + $u->tagihan_total_non);
                $pembayaran_total[$x] = $this->getCurrency($u->pembayaran + $u->pembayaran_non);
                $deposit[$x] = $this->getCurrency($depos[$x]);
                $nomor_identitas[$x] = $u->nomor_identitas;
                $jenis_identitas[$x] = $u->jenis_identitas;
                $jenis_kelamin[$x] = $u->jenis_kelamin;
                $telepon[$x] = $u->telepon;
                $telepon_ortu_wali[$x] = $u->telepon_ortu_wali;
                $x += 1;
            }
        }

        if($x == 0){
            $id[$x] = "";
            $name[$x] = "";
            $email[$x] = "";
            $foto_profil[$x] = "";
            $nama_prodi[$x] = "";
            $nim[$x] = "";
            $registrasi[$x] = "";
            $tagihan_total[$x] = "";
            $pembayaran_total[$x] = "";
            $deposit[$x] = "";
            $nomor_identitas[$x] = "";
            $jenis_identitas[$x] = "";
            $jenis_kelamin[$x] = "";
            $telepon[$x] = "";
            $telepon_ortu_wali[$x] = "";
        }else{
            // Melakukan filter periode dan asrama
            $h = 0;
            $h_count = 0;
            for($a=0; $a <= $x-1; $a++){
                if($s_jalur == 1){
                    for($r=0; $r<=sizeof($r_id_user)-1; $r++){
                        if($r_id_user[$r] == $id[$a]){
                            if($s_gedung == 0 || $r_id_gedung[$r] == $s_gedung){
                                $fr_id_user[$h] = $r_id_user[$r];
                                $fr_id_periode[$h] = $r_id_periode[$r];
                                $fr_nama_periode[$h] = $r_nama_periode[$r];
                                $fr_status_beasiswa[$h] = $r_status_beasiswa[$r];
                                $fr_kamar[$h] = $r_kamar[$r];
                                $fr_gedung[$h] = $r_gedung[$r];
                                $fr_asrama[$h] = $r_asrama[$r];
                                $fr_jumlah_tagihan[$h] = $r_jumlah_tagihan[$r];
                                $fr_keterangan[$h] = $r_keterangan[$r];
                                $fr_total_bayar[$h] = $r_total_bayar[$r];
                                $fr_deposit[$h] = $r_deposit[$r];
                                $fr_depos[$h] = $r_depos[$r];
                                $fn_id_user[$h] = $n_id_user[$r];
                                $fn_tujuan_tinggal[$h] = $n_tujuan_tinggal[$r];
                                $fn_kamar[$h] = $n_kamar[$r];
                                $fn_gedung[$h] = $n_gedung[$r];
                                $fn_asrama[$h] = $n_asrama[$r];
                                $fn_jumlah_tagihan[$h] = $n_jumlah_tagihan[$r];
                                $fn_keterangan[$h] = $n_keterangan[$r];
                                $fn_total_bayar[$h] = $n_total_bayar[$r];
                                $fn_deposit[$h] = $n_deposit[$r];
                                $fn_depos[$h] = $n_depos[$r];
                                if($r_id_periode[$r] == $request->periode){
                                    $h_count += 1; 
                                }
                                $h += 1;
                            }
                        }
                    }
                }elseif($s_jalur == 2){
                    for($n=0; $n<=sizeof($r_id_user)-1; $n++){
                        if($n_id_user[$n] == $id[$a]){
                            if($s_gedung == 0 || $n_id_gedung[$n] == $s_gedung){
                                $fn_id_user[$h] = $n_id_user[$n];
                                $fn_tujuan_tinggal[$h] = $n_tujuan_tinggal[$n];
                                $fn_kamar[$h] = $n_kamar[$n];
                                $fn_gedung[$h] = $n_gedung[$n];
                                $fn_asrama[$h] = $n_asrama[$n];
                                $fn_jumlah_tagihan[$h] = $n_jumlah_tagihan[$n];
                                $fn_keterangan[$h] = $n_keterangan[$n];
                                $fn_total_bayar[$h] = $n_total_bayar[$n];
                                $fn_deposit[$h] = $n_deposit[$n];
                                $fn_depos[$h] = $n_depos[$n];
                                $fr_id_user[$h] = $r_id_user[$n];
                                $fr_id_periode[$h] = $r_id_periode[$n];
                                $fr_nama_periode[$h] = $r_nama_periode[$n];
                                $fr_status_beasiswa[$h] = $r_status_beasiswa[$n];
                                $fr_kamar[$h] = $r_kamar[$n];
                                $fr_gedung[$h] = $r_gedung[$n];
                                $fr_asrama[$h] = $r_asrama[$n];
                                $fr_jumlah_tagihan[$h] = $r_jumlah_tagihan[$n];
                                $fr_keterangan[$h] = $r_keterangan[$n];
                                $fr_total_bayar[$h] = $r_total_bayar[$n];
                                $fr_deposit[$h] = $n_deposit[$n];
                                $fr_depos[$h] = $r_depos[$n];
                                $h += 1;
                                $h_count += 1;
                            }
                        }
                    }
                }
            }
        }
        if($h == 0){
            $fr_id_user[$h] = "";
            $fr_id_periode[$h] = "";
            $fr_nama_periode[$h] = "";
            $fr_status_beasiswa[$h] = "";
            $fr_kamar[$h] = "";
            $fr_gedung[$h] = "";
            $fr_asrama[$h] = "";
            $fr_jumlah_tagihan[$h] = "";
            $fr_keterangan[$h] = "";
            $fr_total_bayar[$h] = "";
            $fr_deposit[$h] = "";
            $fr_depos[$h] = "";
            $fn_id_user[$h] = "";
            $fn_tujuan_tinggal[$h] = "";
            $fn_kamar[$h] = "";
            $fn_gedung[$h] = "";
            $fn_asrama[$h] = "";
            $fn_jumlah_tagihan[$h] = "";
            $fn_keterangan[$h] = "";
            $fn_total_bayar[$h] = "";
            $fn_deposit[$h] = "";
            $fn_depos[$h] = "";
        }
        // Ambil parameter filter
        // Berdasarkan lunas dan tidak lunas
        if($request->kelunasan == 0){
            $dasar_lunas = "lunas dan belum lunas";
        }elseif($request->kelunasan == 1){
            $dasar_lunas = "lunas";
        }else{
            $dasar_lunas = "belum lunas";
        }
        // Berdasarkan jalur
        if($request->jalur == 0){
            $s_jalur = 'Semua jalur';
        }elseif($request->jalur == 1){
            $s_jalur = 'Reguler';
        }else{
            $s_jalur = 'Non Reguler';
        }
        // Berdasarkan periode
        if($request->periode == 0){
            $s_periode = 'Semua periode';
        }else{
            $s_periode = Periode::find($request->periode)->nama_periode;
        }
        // Berdasarkan gedung
        if($request->gedung == 0){
            $s_gedung = 'Semua gedung';
        }else{
            $as = DB::select("SELECT id_gedung, gedung.nama as gedung, gedung.id_asrama, asrama.nama as asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama WHERE id_gedung = ?",[$request->gedung]);
            foreach ($as as $a) {
                $s_gedung = Gedung::find($request->gedung)->nama." - ".$a->asrama;
            }
        }
    	session::flash('menu', 'keuangan_pembayaran_penghuni');
    	return view('dashboard.keuangan.cekPembayaran', $this->getInitialDashboard())
    			->with([
    				'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'foto_profil' => $foto_profil,
                    'nama_prodi' => $nama_prodi,
                    'nim' => $nim,
                    'registrasi' => $registrasi,
                    'tagihan_total' => $tagihan_total,
                    'pembayaran_total' => $pembayaran_total,
                    'deposit' => $deposit,
                    'depos' => $depos,
                    'nomor_identitas' => $nomor_identitas,
                    'jenis_identitas' => $jenis_identitas,
                    'jenis_kelamin' => $jenis_kelamin,
                    'telepon' => $telepon,
                    'telepon_ortu_wali' => $telepon_ortu_wali,
                    'fr_id_user' => $fr_id_user,
                    'fr_id_periode' => $fr_id_periode,
                    'fr_nama_periode' => $fr_nama_periode,
                    'fr_status_beasiswa' => $fr_status_beasiswa,
                    'fr_kamar' => $fr_kamar,
                    'fr_gedung' => $fr_gedung,
                    'fr_asrama' => $fr_asrama,
                    'fr_jumlah_tagihan' => $fr_jumlah_tagihan,
                    'fr_keterangan' => $fr_keterangan,
                    'fr_total_bayar' => $fr_total_bayar,
                    'fr_depos' => $fr_depos,
                    'fr_deposit' => $fr_deposit,
                    'fn_id_user' => $fn_id_user,
                    'fn_kamar' => $fn_kamar,
                    'fn_gedung' => $fn_gedung,
                    'fn_asrama' => $fn_asrama,
                    'fn_jumlah_tagihan' => $fn_jumlah_tagihan,
                    'fn_keterangan' => $fn_keterangan,
                    'fn_total_bayar' => $fn_total_bayar,
                    'fn_depos' => $fn_depos,
                    'fn_deposit' => $fn_deposit,
                    'fn_tujuan_tinggal' => $fn_tujuan_tinggal,
                    'dasar_lunas' => $dasar_lunas,
                    's_jalur' => $s_jalur,
                    's_periode' => $s_periode,
                    's_gedung' => $s_gedung,
                    'sa_jalur' => $request->jalur,
                    'sa_periode' => $request->periode,
                    'sa_gedung' => $request->gedung,
                    'periode' => $periode,
                    'gedung' => $gedung,
                    'h' => $h,
                    'h_count' => $h_count,
                    'x' => $x
    			]); 
    }

    public function nextPrevTabelBayar(Request $request){
        // Prerequest
        $periode = Periode::all();
        $gedung = DB::select("SELECT id_gedung, gedung.nama as gedung, gedung.id_asrama, asrama.nama as asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama");

        // Ambil request
        $s_jalur = $request->jalur;
        $s_periode = $request->periode;
        $s_gedung = $request->gedung;
        $count = $request->count;

        // Memilah jalur pencarian hasil permintaan
        $kelunasan = $request->kelunasan;
            $user_reguler = DB::select("SELECT id_daftar, id_user, daftar_asrama_reguler.id_periode, nama_periode, verification, status_beasiswa, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_reguler LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL AND verification IN(5,6)");
            $y = 0;
            foreach ($user_reguler as $ur){
                    $r_id_user[$y] = $ur->id_user;
                    $r_id_periode[$y] = $ur->id_periode;
                    $r_nama_periode[$y] = $ur->nama_periode;
                    $r_status_beasiswa[$y] = $ur->status_beasiswa;
                    $r_kamar[$y] = $ur->kamar;
                    $r_id_gedung[$y] = $ur->id_gedung;
                    $r_gedung[$y] = $ur->gedung;
                    $r_asrama[$y] = $ur->asrama;
                    $r_jumlah_tagihan[$y] = $this->getCurrency($ur->jumlah_tagihan);
                    $r_keterangan[$y] = $ur->keterangan;
                    $r_total_bayar[$y] = $this->getCurrency($ur->total_bayar);
                    $r_deposit[$y] = $this->getCurrency($ur->total_bayar - $ur->jumlah_tagihan);
                    $r_depos[$y] = $ur->total_bayar - $ur->jumlah_tagihan;
                    $n_id_user[$y] = "";
                    $n_tujuan_tinggal[$y] = "";
                    $n_kamar[$y] = "";
                    $n_id_gedung[$y] = "";
                    $n_gedung[$y] = "";
                    $n_asrama[$y] = "";
                    $n_jumlah_tagihan[$y] = "";
                    $n_keterangan[$y] = "";
                    $n_total_bayar[$y] = "";
                    $n_deposit[$y] = "";
                    $n_depos[$y] = "";
                    $y += 1;
            }
            $user_non = DB::select("SELECT id_daftar, id_user, verification, tujuan_tinggal, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_non_reguler LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_non_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL AND verification IN(5,6)");
            foreach ($user_non as $un) {
                $n_id_user[$y] = $un->id_user;
                $n_tujuan_tinggal[$y] = $un->tujuan_tinggal;
                $n_kamar[$y] = $un->kamar;
                $n_id_gedung[$y] = $un->id_gedung;
                $n_gedung[$y] = $un->gedung;
                $n_asrama[$y] = $un->asrama;
                $n_jumlah_tagihan[$y] = $this->getCurrency($un->jumlah_tagihan);
                $n_keterangan[$y] = $un->keterangan;
                $n_total_bayar[$y] = $this->getCurrency($un->total_bayar);
                $n_deposit[$y] = $this->getCurrency($un->total_bayar - $un->jumlah_tagihan);
                $n_depos[$y] = $un->total_bayar - $un->jumlah_tagihan;
                $r_id_user[$y] = "";
                $r_id_periode[$y] = "";
                $r_nama_periode[$y] = "";
                $r_status_beasiswa[$y] = "";
                $r_kamar[$y] = "";
                $r_id_gedung[$y] = "";
                $r_gedung[$y] = "";
                $r_asrama[$y] = "";
                $r_jumlah_tagihan[$y] = "";
                $r_keterangan[$y] = "";
                $r_total_bayar[$y] = "";
                $r_deposit[$y] = "";
                $r_depos[$y] = "";
                $y += 1;
            }
        
        // Ambil tabelnya
        $user = DB::select("SELECT id, name, email, foto_profil, prod.nama_prodi, prod.nim, prod.registrasi, pay.tagihan_total, pay.pembayaran, pay_non.tagihan_total_non, pay_non.pembayaran_non, nomor_identitas, jenis_identitas, jenis_kelamin, telepon, telepon_ortu_wali FROM users 
            LEFT JOIN 
            (
                SELECT user_nim.id_prodi, id_user, registrasi, nim, prodi.nama_prodi FROM user_nim 
                LEFT JOIN prodi ON prodi.id_prodi = user_nim.id_prodi
            ) AS prod ON prod.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total, sum(detail.total_bayar) as pembayaran FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted = 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_reguler ON daftar_asrama_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_reguler' AND daftar_asrama_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user
            ) AS pay ON pay.id_user = users.id 
            LEFT JOIN user_penghuni ON user_penghuni.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total_non, sum(detail.total_bayar) as pembayaran_non FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted= 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_non_reguler ON daftar_asrama_non_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' AND daftar_asrama_non_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user) AS pay_non ON pay_non.id_user = users.id WHERE pay.tagihan_total IS NOT NULL OR pay_non.tagihan_total_non IS NOT NULL");
        $x = 0;
        foreach ($user as $u) {
            $depos[$x] = $u->pembayaran + $u->pembayaran_non - $u->tagihan_total - $u->tagihan_total_non;
            // Filter lunas atau belum lunas
            if($request->kelunasan == 0 || $request->kelunasan == 1 && $depos[$x] >= 0 || $request->kelunasan == 2 && $depos[$x] < 0){
                $id[$x] = $u->id;
                $name[$x] = $u->name;
                $email[$x] = $u->email;
                $foto_profil[$x] = $u->foto_profil;
                $nama_prodi[$x] = $u->nama_prodi;
                $nim[$x] = $u->nim;
                $registrasi[$x] = $u->registrasi;
                $tagihan_total[$x] = $this->getCurrency($u->tagihan_total + $u->tagihan_total_non);
                $pembayaran_total[$x] = $this->getCurrency($u->pembayaran + $u->pembayaran_non);
                $deposit[$x] = $this->getCurrency($depos[$x]);
                $nomor_identitas[$x] = $u->nomor_identitas;
                $jenis_identitas[$x] = $u->jenis_identitas;
                $jenis_kelamin[$x] = $u->jenis_kelamin;
                $telepon[$x] = $u->telepon;
                $telepon_ortu_wali[$x] = $u->telepon_ortu_wali;
                $x += 1;
            }
        }

        if($x == 0){
            $id[$x] = "";
            $name[$x] = "";
            $email[$x] = "";
            $foto_profil[$x] = "";
            $nama_prodi[$x] = "";
            $nim[$x] = "";
            $registrasi[$x] = "";
            $tagihan_total[$x] = "";
            $pembayaran_total[$x] = "";
            $deposit[$x] = "";
            $nomor_identitas[$x] = "";
            $jenis_identitas[$x] = "";
            $jenis_kelamin[$x] = "";
            $telepon[$x] = "";
            $telepon_ortu_wali[$x] = "";
        }else{
            // Melakukan filter periode dan asrama
            $h = 0;
            $h_count = 0;
            for($a=0; $a <= $x-1; $a++){
                if($s_jalur == 1){
                    for($r=0; $r<=sizeof($r_id_user)-1; $r++){
                        if($r_id_user[$r] == $id[$a]){
                            if($s_gedung == 0 || $r_id_gedung[$r] == $s_gedung){
                                $fr_id_user[$h] = $r_id_user[$r];
                                $fr_id_periode[$h] = $r_id_periode[$r];
                                $fr_nama_periode[$h] = $r_nama_periode[$r];
                                $fr_status_beasiswa[$h] = $r_status_beasiswa[$r];
                                $fr_kamar[$h] = $r_kamar[$r];
                                $fr_gedung[$h] = $r_gedung[$r];
                                $fr_asrama[$h] = $r_asrama[$r];
                                $fr_jumlah_tagihan[$h] = $r_jumlah_tagihan[$r];
                                $fr_keterangan[$h] = $r_keterangan[$r];
                                $fr_total_bayar[$h] = $r_total_bayar[$r];
                                $fr_deposit[$h] = $r_deposit[$r];
                                $fr_depos[$h] = $r_depos[$r];
                                $fn_id_user[$h] = $n_id_user[$r];
                                $fn_tujuan_tinggal[$h] = $n_tujuan_tinggal[$r];
                                $fn_kamar[$h] = $n_kamar[$r];
                                $fn_gedung[$h] = $n_gedung[$r];
                                $fn_asrama[$h] = $n_asrama[$r];
                                $fn_jumlah_tagihan[$h] = $n_jumlah_tagihan[$r];
                                $fn_keterangan[$h] = $n_keterangan[$r];
                                $fn_total_bayar[$h] = $n_total_bayar[$r];
                                $fn_deposit[$h] = $n_deposit[$r];
                                $fn_depos[$h] = $n_depos[$r];
                                if($r_id_periode[$r] == $request->periode){
                                    $h_count += 1; 
                                }
                                $h += 1;
                            }
                        }
                    }
                }elseif($s_jalur == 2){
                    for($n=0; $n<=sizeof($r_id_user)-1; $n++){
                        if($n_id_user[$n] == $id[$a]){
                            if($s_gedung == 0 || $n_id_gedung[$n] == $s_gedung){
                                $fn_id_user[$h] = $n_id_user[$n];
                                $fn_tujuan_tinggal[$h] = $n_tujuan_tinggal[$n];
                                $fn_kamar[$h] = $n_kamar[$n];
                                $fn_gedung[$h] = $n_gedung[$n];
                                $fn_asrama[$h] = $n_asrama[$n];
                                $fn_jumlah_tagihan[$h] = $n_jumlah_tagihan[$n];
                                $fn_keterangan[$h] = $n_keterangan[$n];
                                $fn_total_bayar[$h] = $n_total_bayar[$n];
                                $fn_deposit[$h] = $n_deposit[$n];
                                $fn_depos[$h] = $n_depos[$n];
                                $fr_id_user[$h] = $r_id_user[$n];
                                $fr_id_periode[$h] = $r_id_periode[$n];
                                $fr_nama_periode[$h] = $r_nama_periode[$n];
                                $fr_status_beasiswa[$h] = $r_status_beasiswa[$n];
                                $fr_kamar[$h] = $r_kamar[$n];
                                $fr_gedung[$h] = $r_gedung[$n];
                                $fr_asrama[$h] = $r_asrama[$n];
                                $fr_jumlah_tagihan[$h] = $r_jumlah_tagihan[$n];
                                $fr_keterangan[$h] = $r_keterangan[$n];
                                $fr_total_bayar[$h] = $r_total_bayar[$n];
                                $fr_deposit[$h] = $n_deposit[$n];
                                $fr_depos[$h] = $r_depos[$r];
                                $h_count += 1; 
                                $h += 1;
                            }
                        }
                    }
                }
            }
        }
        if($h == 0){
            $fr_id_user[$h] = "";
            $fr_id_periode[$h] = "";
            $fr_nama_periode[$h] = "";
            $fr_status_beasiswa[$h] = "";
            $fr_kamar[$h] = "";
            $fr_gedung[$h] = "";
            $fr_asrama[$h] = "";
            $fr_jumlah_tagihan[$h] = "";
            $fr_keterangan[$h] = "";
            $fr_total_bayar[$h] = "";
            $fr_deposit[$h] = "";
            $fr_depos[$h] = "";
            $fn_id_user[$h] = "";
            $fn_tujuan_tinggal[$h] = "";
            $fn_kamar[$h] = "";
            $fn_gedung[$h] = "";
            $fn_asrama[$h] = "";
            $fn_jumlah_tagihan[$h] = "";
            $fn_keterangan[$h] = "";
            $fn_total_bayar[$h] = "";
            $fn_deposit[$h] = "";
            $fn_depos[$h] = "";
        }
        // Ambil parameter filter
        // Berdasarkan lunas dan tidak lunas
        if($request->kelunasan == 0){
            $dasar_lunas = "lunas dan belum lunas";
        }elseif($request->kelunasan == 1){
            $dasar_lunas = "lunas";
        }else{
            $dasar_lunas = "belum lunas";
        }
        // Berdasarkan jalur
        if($request->jalur == 0){
            $s_jalur = 'Semua jalur';
        }elseif($request->jalur == 1){
            $s_jalur = 'Reguler';
        }else{
            $s_jalur = 'Non Reguler';
        }
        // Berdasarkan periode
        if($request->periode == 0){
            $s_periode = 'Semua periode';
        }else{
            $s_periode = Periode::find($request->periode)->nama_periode;
        }
        // Berdasarkan gedung
        if($request->gedung == 0){
            $s_gedung = 'Semua gedung';
        }else{
            $as = DB::select("SELECT id_gedung, gedung.nama as gedung, gedung.id_asrama, asrama.nama as asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama WHERE id_gedung = ?",[$request->gedung]);
            foreach ($as as $a) {
                $s_gedung = Gedung::find($request->gedung)->nama." - ".$a->asrama;
            }
        }
        session::flash('menu', 'keuangan_pembayaran_penghuni');
        return view('dashboard.keuangan.ajax.ajax_tabel_keuangan', $this->getInitialDashboard())
                ->with([
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'foto_profil' => $foto_profil,
                    'nama_prodi' => $nama_prodi,
                    'nim' => $nim,
                    'registrasi' => $registrasi,
                    'tagihan_total' => $tagihan_total,
                    'pembayaran_total' => $pembayaran_total,
                    'deposit' => $deposit,
                    'depos' => $depos,
                    'nomor_identitas' => $nomor_identitas,
                    'jenis_identitas' => $jenis_identitas,
                    'jenis_kelamin' => $jenis_kelamin,
                    'telepon' => $telepon,
                    'telepon_ortu_wali' => $telepon_ortu_wali,
                    'fr_id_user' => $fr_id_user,
                    'fr_id_periode' => $fr_id_periode,
                    'fr_nama_periode' => $fr_nama_periode,
                    'fr_status_beasiswa' => $fr_status_beasiswa,
                    'fr_kamar' => $fr_kamar,
                    'fr_gedung' => $fr_gedung,
                    'fr_asrama' => $fr_asrama,
                    'fr_jumlah_tagihan' => $fr_jumlah_tagihan,
                    'fr_keterangan' => $fr_keterangan,
                    'fr_total_bayar' => $fr_total_bayar,
                    'fr_depos' => $fr_depos,
                    'fr_deposit' => $fr_deposit,
                    'fn_id_user' => $fn_id_user,
                    'fn_kamar' => $fn_kamar,
                    'fn_gedung' => $fn_gedung,
                    'fn_asrama' => $fn_asrama,
                    'fn_jumlah_tagihan' => $fn_jumlah_tagihan,
                    'fn_keterangan' => $fn_keterangan,
                    'fn_total_bayar' => $fn_total_bayar,
                    'fn_depos' => $fn_depos,
                    'fn_deposit' => $fn_deposit,
                    'fn_tujuan_tinggal' => $fn_tujuan_tinggal,
                    'dasar_lunas' => $dasar_lunas,
                    's_jalur' => $s_jalur,
                    's_periode' => $s_periode,
                    's_gedung' => $s_gedung,
                    'sa_jalur' => $request->jalur,
                    'sa_periode' => $request->periode,
                    'sa_gedung' => $request->gedung,
                    'periode' => $periode,
                    'gedung' => $gedung,
                    'h' => $h,
                    'h_count' => $h_count,
                    'x' => $x,
                    'count' => $count
                ]); 
    }

    public function cariBayarAjax(Request $request){
        // Ambil parameter
        $input = $request->cariBayar;
        $filter = $request->filter_fast;
        if($filter == ""){
            $gagal = 1;
            return view('dashboard.keuangan.ajax.cariBayarCepat', $this->getInitialDashboard())
                ->with(['gagal' => $gagal]);
        }
        // Memilah jalur pencarian hasil permintaan
            $user_reguler = DB::select("SELECT id_daftar, id_user, daftar_asrama_reguler.id_periode, nama_periode, verification, status_beasiswa, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_reguler LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL");
            $y = 0;
            foreach ($user_reguler as $ur){
                    $r_id_user[$y] = $ur->id_user;
                    $r_nama_periode[$y] = $ur->nama_periode;
                    $r_status_beasiswa[$y] = $ur->status_beasiswa;
                    $r_kamar[$y] = $ur->kamar;
                    $r_gedung[$y] = $ur->gedung;
                    $r_asrama[$y] = $ur->asrama;
                    $r_jumlah_tagihan[$y] = $this->getCurrency($ur->jumlah_tagihan);
                    $r_keterangan[$y] = $ur->keterangan;
                    $r_total_bayar[$y] = $this->getCurrency($ur->total_bayar);
                    $r_deposit[$y] = $this->getCurrency($ur->total_bayar - $ur->jumlah_tagihan);
                    $r_depos[$y] = $ur->total_bayar - $ur->jumlah_tagihan;
                    $n_id_user[$y] = "";
                    $n_tujuan_tinggal[$y] = "";
                    $n_kamar[$y] = "";
                    $n_gedung[$y] = "";
                    $n_asrama[$y] = "";
                    $n_jumlah_tagihan[$y] = "";
                    $n_keterangan[$y] = "";
                    $n_total_bayar[$y] = "";
                    $n_deposit[$y] = "";
                    $n_depos[$y] = "";
                    $y += 1;
            }
            $user_non = DB::select("SELECT id_daftar, id_user, verification, tujuan_tinggal, place.id_kamar, place.kamar, place.id_gedung, place.gedung, place.id_asrama, place.asrama, bill.id_tagihan, bill.jumlah_tagihan, bill.keterangan, bill.total_bayar FROM daftar_asrama_non_reguler LEFT JOIN (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, room.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT kamar.id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar left join (SELECT asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung FROM gedung left join asrama on asrama.id_asrama = gedung.id_asrama) as dorm on dorm.id_gedung = kamar.id_gedung) as room on room.id_kamar = kamar_penghuni.id_kamar WHERE kamar_penghuni.daftar_asrama_type = 'daftar_asrama_non_reguler') AS place ON place.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar LEFT JOIN (SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(jumlah_bayar) as total_bayar FROM tagihan LEFT JOIN (SELECT * FROM pembayaran WHERE is_accepted = 1) AS pembayaran ON pembayaran.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' GROUP BY tagihan.id_tagihan) AS bill ON bill.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE bill.jumlah_tagihan IS NOT NULL");
            foreach ($user_non as $un) {
                $n_id_user[$y] = $un->id_user;
                $n_tujuan_tinggal[$y] = $un->tujuan_tinggal;
                $n_kamar[$y] = $un->kamar;
                $n_gedung[$y] = $un->gedung;
                $n_asrama[$y] = $un->asrama;
                $n_jumlah_tagihan[$y] = $this->getCurrency($un->jumlah_tagihan);
                $n_keterangan[$y] = $un->keterangan;
                $n_total_bayar[$y] = $this->getCurrency($un->total_bayar);
                $n_deposit[$y] = $this->getCurrency($un->total_bayar - $un->jumlah_tagihan);
                $n_depos[$y] = $un->total_bayar - $un->jumlah_tagihan;
                $r_id_user[$y] = "";
                $r_nama_periode[$y] = "";
                $r_status_beasiswa[$y] = "";
                $r_kamar[$y] = "";
                $r_gedung[$y] = "";
                $r_asrama[$y] = "";
                $r_jumlah_tagihan[$y] = "";
                $r_keterangan[$y] = "";
                $r_total_bayar[$y] = "";
                $r_total_bayar[$y] = "";
                $r_deposit[$y] = "";
                $y += 1;
            }
        
        // Ambil tabelnya
        $user = DB::select("SELECT id, name, email, foto_profil, prod.nama_prodi, prod.nim, prod.registrasi, pay.tagihan_total, pay.pembayaran, pay_non.tagihan_total_non, pay_non.pembayaran_non, nomor_identitas, jenis_identitas, jenis_kelamin, telepon, telepon_ortu_wali FROM users 
            LEFT JOIN 
            (
                SELECT user_nim.id_prodi, id_user, registrasi, nim, prodi.nama_prodi FROM user_nim 
                LEFT JOIN prodi ON prodi.id_prodi = user_nim.id_prodi
            ) AS prod ON prod.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total, sum(detail.total_bayar) as pembayaran FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted = 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_reguler ON daftar_asrama_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_reguler' AND daftar_asrama_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user
            ) AS pay ON pay.id_user = users.id 
            LEFT JOIN user_penghuni ON user_penghuni.id_user = users.id 
            LEFT JOIN 
            (
                SELECT detail.id_user, sum(detail.jumlah_tagihan) as tagihan_total_non, sum(detail.total_bayar) as pembayaran_non FROM 
                (
                    SELECT id_user, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, tagihan.keterangan, sum(bayar.jumlah_bayar) as total_bayar FROM tagihan 
                    LEFT JOIN 
                    (
                        SELECT pembayaran.id_pembayaran, id_tagihan, jumlah_bayar, jenis_pembayaran, is_accepted FROM pembayaran WHERE is_accepted= 1 AND jenis_pembayaran IN (0,1)
                    ) AS bayar ON bayar.id_tagihan = tagihan.id_tagihan 
                    LEFT JOIN daftar_asrama_non_reguler ON daftar_asrama_non_reguler.id_daftar = tagihan.daftar_asrama_id WHERE daftar_asrama_type = 'Daftar_asrama_non_reguler' AND daftar_asrama_non_reguler.verification
                    IN (5,6) GROUP BY tagihan.id_tagihan
                ) AS detail GROUP BY detail.id_user) AS pay_non ON pay_non.id_user = users.id WHERE pay.tagihan_total IS NOT NULL OR pay_non.tagihan_total_non IS NOT NULL");
        $x = 0;
        foreach ($user as $u) {
            $depos[$x] = $u->pembayaran + $u->pembayaran_non - $u->tagihan_total - $u->tagihan_total_non;
            $yes = 0;
            if($filter == "nim"){
                if(stripos($u->nim,$input) !== false){
                    $yes = 1;
                }
            }elseif($filter == "registrasi"){
                if(stripos($u->registrasi,$input) !== false){
                    $yes = 1;
                }
            }elseif($filter == "nama"){
                if(stripos($u->name,$input) !== false){
                    $yes = 1;
                }
            }elseif($filter == "email"){
                if(stripos($u->email,$input) !== false){
                    $yes = 1;
                }
            }
            if($yes == 1){
                $id[$x] = $u->id;
                $name[$x] = $u->name;
                $email[$x] = $u->email;
                $foto_profil[$x] = $u->foto_profil;
                $nama_prodi[$x] = $u->nama_prodi;
                $nim[$x] = $u->nim;
                $registrasi[$x] = $u->registrasi;
                $tagihan_total[$x] = $this->getCurrency($u->tagihan_total + $u->tagihan_total_non);
                $pembayaran_total[$x] = $this->getCurrency($u->pembayaran + $u->pembayaran_non);
                $deposit[$x] = $this->getCurrency($depos[$x]);
                $nomor_identitas[$x] = $u->nomor_identitas;
                $jenis_identitas[$x] = $u->jenis_identitas;
                $jenis_kelamin[$x] = $u->jenis_kelamin;
                $telepon[$x] = $u->telepon;
                $telepon_ortu_wali[$x] = $u->telepon_ortu_wali;
                $x += 1;
            }
        }

        if($x == 0){
            $id[$x] = "";
            $name[$x] = "";
            $email[$x] = "";
            $foto_profil[$x] = "";
            $nama_prodi[$x] = "";
            $nim[$x] = "";
            $registrasi[$x] = "";
            $tagihan_total[$x] = "";
            $pembayaran_total[$x] = "";
            $deposit[$x] = "";
            $nomor_identitas[$x] = "";
            $jenis_identitas[$x] = "";
            $jenis_kelamin[$x] = "";
            $telepon[$x] = "";
            $telepon_ortu_wali[$x] = "";
        }

        return view('dashboard.keuangan.ajax.cariBayarCepat', $this->getInitialDashboard())
                ->with([
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'foto_profil' => $foto_profil,
                    'nama_prodi' => $nama_prodi,
                    'nim' => $nim,
                    'registrasi' => $registrasi,
                    'tagihan_total' => $tagihan_total,
                    'pembayaran_total' => $pembayaran_total,
                    'deposit' => $deposit,
                    'depos' => $depos,
                    'nomor_identitas' => $nomor_identitas,
                    'jenis_identitas' => $jenis_identitas,
                    'jenis_kelamin' => $jenis_kelamin,
                    'telepon' => $telepon,
                    'telepon_ortu_wali' => $telepon_ortu_wali,
                    'x' => $x,
                    'r_id_user' => $r_id_user,
                    'r_nama_periode' => $r_nama_periode,
                    'r_status_beasiswa' => $r_status_beasiswa,
                    'r_kamar' => $r_kamar,
                    'r_gedung' => $r_gedung,
                    'r_asrama' => $r_asrama,
                    'r_jumlah_tagihan' => $r_jumlah_tagihan,
                    'r_keterangan' => $r_keterangan,
                    'r_total_bayar' => $r_total_bayar,
                    'r_depos' => $r_depos,
                    'r_deposit' => $r_deposit,
                    'n_id_user' => $n_id_user,
                    'n_kamar' => $n_kamar,
                    'n_gedung' => $n_gedung,
                    'n_asrama' => $n_asrama,
                    'n_jumlah_tagihan' => $n_jumlah_tagihan,
                    'n_keterangan' => $n_keterangan,
                    'n_total_bayar' => $n_total_bayar,
                    'n_depos' => $n_depos,
                    'n_deposit' => $n_deposit,
                    'n_tujuan_tinggal' => $n_tujuan_tinggal,
                    'input' => $input
                ]);
    }
}
