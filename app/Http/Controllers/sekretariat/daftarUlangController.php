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
use App\Penghuni;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Http\Controllers\Traits\editPeriode;
use App\Http\Controllers\Traits\currency;
use App\Http\Controllers\Traits\PembayaranPenghuniReguler;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Pembayaran;
use App\Tarif;
use App\Tagihan;
use App\Penangguhan;
use Illuminate\Support\Facades\Input;

class daftarUlangController extends Controller
{
	use initialDashboard;
    use tanggalWaktu;
    use tanggal;
    use editPeriode;
    use currency;
    use PembayaranPenghuniReguler;

    // REGULER

    public function indexReguler() {
    	$daful = DB::select("
    		SELECT id_daftar, daftar_asrama_reguler.id_user, periodes.id_periode, periodes.nama_periode, status_beasiswa, name, email, nim, registrasi, id_asrama, R.asrama, id_gedung, gedung, id_kamar, kamar, jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran FROM daftar_asrama_reguler 
			LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
			LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user
			LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode
			LEFT JOIN 
			(
				SELECT id_asrama, asrama, id_gedung, gedung, room.id_kamar, kamar, daftar_asrama_id, daftar_asrama_type FROM kamar_penghuni 
				LEFT JOIN 
				(
					SELECT id_asrama, asrama, building.id_gedung, gedung, id_kamar, kamar.nama as kamar FROM kamar 
					LEFT JOIN 
					(
						SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama as gedung FROM gedung 
						LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
					) AS building ON building.id_gedung = kamar.id_gedung
				) AS room ON room.id_kamar = kamar_penghuni.id_kamar
			) AS R ON R.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND R.daftar_asrama_type = 'daftar_asrama_reguler'
			LEFT JOIN
			(
				SELECT jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran, daftar_asrama_id, daftar_asrama_type FROM tagihan
				LEFT JOIN penangguhan ON penangguhan.id_tagihan = tagihan.id_tagihan
			) AS fee ON fee.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND fee.daftar_asrama_type = 'daftar_asrama_reguler'
			WHERE daftar_asrama_reguler.verification = 1");
    	$z = 0;
    	foreach ($daful as $daf) {
    		$tagihan[$z] = $this->getCurrency($daf->jumlah_tagihan);
    		$z += 1;
    	}
    	if($z == 0){
    		$tagihan[$z] = 0;
    	}
    	Session::flash('menu','daftarUlangReg');
	    $h = sizeof($daful);
    	return view('dashboard.sekretariat.daftarUlang', $this->getInitialDashboard())->with(['daful'=>$daful, 'h' => $h, 'tagihan' => $tagihan]);
    }

    public function submitDaful(Request $request){
    	if($request->id_penangguhan != NULL){
    		$t = Penangguhan::find($request->id_penangguhan);
    		if($request->sktm != NULL){
    			$t->is_sktm = 1;
    		}
    		if($request->formulir_penangguhan != NULL){
    			$t->formulir_penangguhan = 1;
    		}
    		$t->save();
    	}
    	// Perlengkapan daftar ulang
    	$penghuni = new Penghuni();
    	$penghuni->daftar_asrama_id = $request->id_daftar;
    	$penghuni->daftar_asrama_type = 'daftar_asrama_reguler';
    	if($request->ktm != NULL){
    		$penghuni->ktm = 1;
    	}else{
    		$penghuni->ktm = 0;
    	}
    	if($request->surat_perjanjian != NULL){
    		$penghuni->surat_perjanjian = 1;
    	}else{
    		$penghuni->surat_perjanjian = 0;
    	}
    	$penghuni->keterangan = $request->keterangan;
    	$penghuni->save();

    	// Daful
    	$daful = Daftar_asrama_reguler::find($request->id_daftar);
    	$daful->verification = 5;
    	$daful->save();

    	Session::flash('status2','Daftar ulang telah berhasil.');
    	return redirect()->back();
    }

    public function ajaxCariDaful(Request $request){
    	$cari = $request->cari;
    	$kategori = $request->kategori;
    	if($cari != NULL && strlen($cari) > 3){
    		if($kategori = 'nama'){
	    		$search = "name";
	    	}elseif($kategori = 'nim'){
	    		$search = "nim";
	    	}elseif($kategori = 'email'){
	    		$search = "email";
	    	}elseif($kategori = 'registrasi'){
	    		$search = "registrasi";
	    	}
	    	$daful = DB::select("
	    		SELECT id_daftar, daftar_asrama_reguler.id_user, periodes.id_periode, periodes.nama_periode, status_beasiswa, name, email, foto_profil, jenis_kelamin, nim, registrasi, id_asrama, R.asrama, id_gedung, gedung, id_kamar, kamar, jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran FROM daftar_asrama_reguler 
				LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
				LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user
				LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode
				LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_reguler.id_user
				LEFT JOIN 
				(
					SELECT id_asrama, asrama, id_gedung, gedung, room.id_kamar, kamar, daftar_asrama_id, daftar_asrama_type FROM kamar_penghuni 
					LEFT JOIN 
					(
						SELECT id_asrama, asrama, building.id_gedung, gedung, id_kamar, kamar.nama as kamar FROM kamar 
						LEFT JOIN 
						(
							SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama as gedung FROM gedung 
							LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
						) AS building ON building.id_gedung = kamar.id_gedung
					) AS room ON room.id_kamar = kamar_penghuni.id_kamar
				) AS R ON R.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND R.daftar_asrama_type = 'daftar_asrama_reguler'
				LEFT JOIN
				(
					SELECT jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran, daftar_asrama_id, daftar_asrama_type FROM tagihan
					LEFT JOIN penangguhan ON penangguhan.id_tagihan = tagihan.id_tagihan
				) AS fee ON fee.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND fee.daftar_asrama_type = 'daftar_asrama_reguler'
				WHERE daftar_asrama_reguler.verification = 1 AND $search like ?",["%".$cari."%"]);
	    	$z = 0;
	    	foreach ($daful as $daf) {
	    		$tagihan[$z] = $this->getCurrency($daf->jumlah_tagihan);
	    		$z += 1;
	    	}
	    	return view('dashboard.sekretariat.ajax.CariDaful', $this->getInitialDashboard())->with(['daful'=>$daful, 'tagihan' => $tagihan]);
    	}else{
    		$fail = 1;
    		return view('dashboard.sekretariat.ajax.CariDaful', $this->getInitialDashboard())->with(['fail'=>$fail]);
    	}
    }

    public function nextPrevDaful(Request $request){
    	$daful = DB::select("
    		SELECT id_daftar, daftar_asrama_reguler.id_user, periodes.id_periode, periodes.nama_periode, status_beasiswa, name, email, nim, registrasi, id_asrama, R.asrama, id_gedung, gedung, id_kamar, kamar, jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran FROM daftar_asrama_reguler 
			LEFT JOIN users ON users.id = daftar_asrama_reguler.id_user 
			LEFT JOIN user_nim ON user_nim.id_user = daftar_asrama_reguler.id_user
			LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode
			LEFT JOIN 
			(
				SELECT id_asrama, asrama, id_gedung, gedung, room.id_kamar, kamar, daftar_asrama_id, daftar_asrama_type FROM kamar_penghuni 
				LEFT JOIN 
				(
					SELECT id_asrama, asrama, building.id_gedung, gedung, id_kamar, kamar.nama as kamar FROM kamar 
					LEFT JOIN 
					(
						SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama as gedung FROM gedung 
						LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
					) AS building ON building.id_gedung = kamar.id_gedung
				) AS room ON room.id_kamar = kamar_penghuni.id_kamar
			) AS R ON R.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND R.daftar_asrama_type = 'daftar_asrama_reguler'
			LEFT JOIN
			(
				SELECT jumlah_tagihan, id_penangguhan, jumlah_tangguhan, alasan_penangguhan, deadline_pembayaran, daftar_asrama_id, daftar_asrama_type FROM tagihan
				LEFT JOIN penangguhan ON penangguhan.id_tagihan = tagihan.id_tagihan
			) AS fee ON fee.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND fee.daftar_asrama_type = 'daftar_asrama_reguler'
			WHERE daftar_asrama_reguler.verification = 1");
	    $count = $request->count;
	    $h = 0;
	    $c = 0;
	    foreach ($daful as $d) {
	    	if($h >= $count && $h <= $count+9){
	    		$tagihan[$h] = $this->getCurrency($d->jumlah_tagihan);
	    		$h += 1;
                $c += 1;
	    	}else{
	    		$h += 1;
	    	}
	    }
    	return view('dashboard.sekretariat.ajax.nextPrevDaful', $this->getInitialDashboard())->with(['daful'=>$daful, 'h' => $h, 'c'=>$c, 'count' => $count, 'tagihan' => $tagihan]);
    }

    // NON REGULER

    public function indexNonReguler(Request $request){
    	$daful = DB::select("
    		SELECT id_daftar, id, tujuan_tinggal, tempo, lama_tinggal, email, name, foto_profil, total, bayar.id_tagihan, jumlah_tagihan, jenis_kelamin, wil.kamar, wil.gedung, wil.asrama FROM daftar_asrama_non_reguler 
                LEFT JOIN users ON users.id = daftar_asrama_non_reguler.id_user
                LEFT JOIN 
                (
                    SELECT tagihan.id_tagihan, jumlah_tagihan, daftar_asrama_id, daftar_asrama_type, total FROM tagihan LEFT JOIN (SELECT id_tagihan, sum(jumlah_bayar) as total FROM pembayaran WHERE is_accepted = 0 GROUP BY id_tagihan) AS pay ON pay.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'daftar_asrama_non_reguler'
                ) as bayar ON bayar.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND bayar.daftar_asrama_type = 'Daftar_asrama_non_reguler'
                LEFT JOIN user_penghuni ON user_penghuni.id_user = daftar_asrama_non_reguler.id_user 
                LEFT JOIN 
                (
                    select kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, tempat.id_kamar, tempat.id_gedung, tempat.id_asrama, tempat.kamar, tempat.gedung, tempat.asrama from kamar_penghuni 
                    LEFT JOIN 
                    (
                        select kamar.id_kamar, kamar.nama as kamar, fasil.id_asrama, fasil.id_gedung, asrama, gedung from kamar 
                        LEFT JOIN 
                        (
                            select asrama.id_asrama, asrama.nama as asrama, gedung.id_gedung, gedung.nama as gedung from gedung 
                            LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
                        ) as fasil ON fasil.id_gedung = kamar.id_gedung
                    ) as tempat ON tempat.id_kamar = kamar_penghuni.id_kamar
                ) as wil ON wil.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND wil.daftar_asrama_type = 'Daftar_asrama_non_reguler' 
                WHERE daftar_asrama_non_reguler.verification = 1");
    	$z = 0;
    	foreach ($daful as $daf) {
    		$tagihan[$z] = $this->getCurrency($daf->jumlah_tagihan);
    		$total[$z] = $this->getCurrency($daf->total);
    		$detail_bayar[$z] = Pembayaran::where(['id_tagihan' => $daf->id_tagihan, 'is_accepted' => 0])->get();
    		$k = 0;
    		foreach ($detail_bayar[$z] as $det) {
    			$jumlah_bayar[$k] = $this->getCurrency($det->jumlah_bayar);
    			$tanggal_bayar[$k] = $this->date($det->tanggal_bayar);
    			$id_bayar[$k] = $det->id_pembayaran;
    				$k += 1;
    		}
    		if($k == 0){
    			$jumlah_bayar[$k] = 0;
    			$tanggal_bayar[$k] = 0;
    			$id_bayar[$k] = 0;
    		}
    		$z += 1;
    	}
    	if($z == 0){
    		$tagihan[$z] = 0;
    		$total[$z] = 0;
    		$detail_bayar[$z] = 0;
    		$jumlah_bayar[$z] = 0;
    		$tanggal_bayar[$z] = 0;
    		$id_bayar[$k] = 0;
    	}
    	Session::flash('menu','daftarUlangNon');
	    $h = sizeof($daful);
    	return view('dashboard.sekretariat.daftarUlangNon', $this->getInitialDashboard())
    		->with(['daful'=>$daful, 
    				'h' => $h, 
    				'tagihan' => $tagihan, 
    				'detail_bayar' => $detail_bayar, 
    				'total' => $total, 
    				'jumlah_bayar' => $jumlah_bayar, 
    				'tanggal_bayar' => $tanggal_bayar,
    				'id_bayar' => $id_bayar]);
    }

    public function submitDafulNon(Request $request){
    	// Verifikasi pembayaran
    	$id_bayar = $request->id_bayar;
    	for($c=0; $c<= sizeof($id_bayar) - 1; $c++) {
    		$bayar = Pembayaran::find($id_bayar[$c]);
    		$bayar->is_accepted = 1;
    		$bayar->keterangan = $request->keterangan;
    		$bayar->save();
    	}
    	// Perlengkapan daftar ulang
    	$penghuni = new Penghuni();
    	$penghuni->daftar_asrama_id = $request->id_daftar;
    	$penghuni->daftar_asrama_type = 'daftar_asrama_non_reguler';
    	$penghuni->ktm = 0;
    	if($request->surat_perjanjian != NULL){
    		$penghuni->surat_perjanjian = 1;
    	}else{
    		$penghuni->surat_perjanjian = 0;
    	}
    	$penghuni->keterangan = $request->keterangan;
    	$penghuni->save();

    	// Daful
    	$daful = Daftar_asrama_non_reguler::find($request->id_daftar);
    	$daful->verification = 5;
    	$daful->save();

    	Session::flash('status2','Daftar ulang telah berhasil.');
    	return redirect()->back();
    }



}