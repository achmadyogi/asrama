<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Alokasi;
use App\Kamar;
use App\Asrama;
use App\KamarReguler;
use App\Gedung;
use App\User;

use DB;

class AlokasiController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{	
	    if (Auth::guest()) {
			return redirect('/home');
		} else {
			$user = Auth::user();
			if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
				return redirect('/dashboard');
			}
		}
	    return view('alokasi.index', []);
	}

	public function create(Request $request)
	{
	    if (Auth::guest()) {
			return redirect('/home');
		} else {
			$user = Auth::user();
			if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
				return redirect('/dashboard');
			}
		}
	    return view('alokasi.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
	    if (Auth::guest()) {
			return redirect('/home');
		} else {
			$user = Auth::user();
			if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
				return redirect('/dashboard');
			}
		}
		$alokasi = Alokasi::findOrFail($id);
		$asrama = Asrama::where('nama', $alokasi['asrama'])->first();
		$gedungs = Asrama::find($asrama['id_asrama'])->gedung;

/*		$kamars = collect();
		
		foreach($gedungs as $gedung) {
			$kamars = $kamars->merge(Gedung::find($gedung->id_gedung)->kamar);
		}*/
//		$kamars = $kamars->join('kamar_reguler');
		
		$tanggal = null;
		if($alokasi['tanggal_masuk'] < date("Y-m-d")) {
			$tanggal = date("Y-m-d");
		} else {
			$tanggal = $alokasi['tanggal_masuk'];
		}
		
		$kamars = DB::select('SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, jumlahPenghuniList.jumlah_penghuni, kamar.kapasitas, kamar.gender, kamar.status
								FROM
								(
									SELECT data_penghuni.id_kamar, count(*) as jumlah_penghuni
									FROM
									(
										SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, kamar.kapasitas, kamar.gender
											FROM
											(
												SELECT kamar.id_kamar, kamar.id_gedung, kamar.nama, kamar.kapasitas, kamar.gender
												FROM asrama JOIN gedung JOIN kamar
												WHERE asrama.id_asrama = '.$asrama['id_asrama'].' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
											) kamar
											JOIN
											(
												SELECT d.id_pendaftaran_reguler AS id_pendaftaran, tanggal_awal, tanggal_akhir, created, d.id_kamar, e.nama AS nama_kamar
												FROM
												(
													SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
													FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
													GROUP BY f.id_pendaftaran_reguler
												) kamarList
												JOIN kamar_reguler d JOIN kamar e JOIN daftar_asrama_reguler
												WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.id_pendaftaran_reguler = daftar_asrama_reguler.id_daftar AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar
													AND tanggal_masuk <= "'.$tanggal.'" AND "'.$tanggal.'" <= tanggal_keluar
												UNION ALL
												SELECT d.id_pendaftaran_non_reguler AS id_pendaftaran, tanggal_awal, tanggal_akhir, created, d.id_kamar, e.nama AS nama_kamar
												FROM
												(
													SELECT f.id_pendaftaran_non_reguler, MAX(f.created_at) as created
													FROM kamar_non_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
													GROUP BY f.id_pendaftaran_non_reguler
												) kamarList
												JOIN kamar_non_reguler d JOIN kamar e JOIN daftar_asrama_non_reguler
												WHERE d.id_pendaftaran_non_reguler = kamarList.id_pendaftaran_non_reguler AND d.id_pendaftaran_non_reguler = daftar_asrama_non_reguler.id_daftar AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar
												AND tanggal_masuk <= "'.$tanggal.'" AND "'.$tanggal.'" <= tanggal_keluar
											) penghuni
										ON kamar.id_kamar = penghuni.id_kamar
									) data_penghuni
									GROUP BY data_penghuni.id_kamar
								) jumlahPenghuniList
								RIGHT JOIN kamar
								ON jumlahPenghuniList.id_kamar = kamar.id_kamar
							');
		$kamars = collect($kamars);
		
//		$kamarReguler = KamarReguler::find($id);
		$kamarReguler = KamarReguler::where('id_pendaftaran_reguler', $id)->orderBy('created_at', 'desc')->get()->first();	

		
	    return view('alokasi.add', [
	        'model' => $alokasi,
			'kamars' => $kamars,
			'kamarReguler' => $kamarReguler,
//			'kamarReguler1' => $kamarReguler1,
		]);
	}

	public function show(Request $request, $id)
	{
	    if (Auth::guest()) {
			return view('404');
		} else {
			$user = Auth::user();
			if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
				return view('404');
			}
		}	
		$alokasi = Alokasi::findOrFail($id);
	    return view('alokasi.show', [
	        'model' => $alokasi	    ]);
	}

	// Penghuni status diterima
	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$user = Auth::user();
		
		if($user->is_admin == '1') {
			$select = "SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar, nama_kamar ";
			$presql = " FROM 
							(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar 
								FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND (status = 'Diterima') AND DATE(NOW()) <= tanggal_keluar) b 
								LEFT JOIN 
									(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
										FROM
										(
											SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
											FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
											GROUP BY f.id_pendaftaran_reguler
										) kamarList
									JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar) 
							c ON b.id_daftar = c.id_pendaftaran_reguler) a ";
		} else if ($user->is_pengelola == '1') {
			$asrama = DB::select('SELECT * FROM pengelola JOIN asrama
									WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = '.$user->id);
			$select = "SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar, nama_kamar ";
			$presql = " FROM 
							(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar 
								FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND (status = 'Diterima') AND DATE(NOW()) <= tanggal_keluar AND asrama = '".$asrama[0]->nama."') b
								LEFT JOIN 
									(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
										FROM
										(
											SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
											FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
											GROUP BY f.id_pendaftaran_reguler
										) kamarList
									JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar) 
							c ON b.id_daftar = c.id_pendaftaran_reguler) a ";		
		}
		
		$presql .= " WHERE a.asrama LIKE '%".$_GET['columns']['6']['search']['value']."%'";		
		$presql .= " AND a.nama_periode LIKE '%".$_GET['columns']['7']['search']['value']."%'";
		
		if($_GET['search']['value']) {	
			$presql .= " AND (a.id_daftar LIKE '%".$_GET['search']['value']."%' 
						OR a.id_user LIKE '%".$_GET['search']['value']."%'
						OR a.nama LIKE '%".$_GET['search']['value']."%'
						OR a.nomor_identitas LIKE '%".$_GET['search']['value']."%'
						OR a.jenis_identitas LIKE '%".$_GET['search']['value']."%'
						OR a.jenis_kelamin LIKE '%".$_GET['search']['value']."%'
						OR a.asrama LIKE '%".$_GET['search']['value']."%'
						OR a.nama_periode LIKE '%".$_GET['search']['value']."%'
						OR a.tanggal_masuk LIKE '%".$_GET['search']['value']."%'
						OR a.tanggal_keluar LIKE '%".$_GET['search']['value']."%'
						OR a.nama_kamar LIKE '%".$_GET['search']['value']."%')";
		}	
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_user) c".$presql);
		//print_r($qcount);
		$count = $qcount[0]->c;

		$results = DB::select($sql);
		$ret = [];
		foreach ($results as $row) {
			$r = [];
			foreach ($row as $value) {
				$r[] = $value;
			}
			$ret[] = $r;
		}

		$ret['data'] = $ret;
		$ret['recordsTotal'] = $count;
		$ret['iTotalDisplayRecords'] = $count;

		$ret['recordsFiltered'] = count($ret);
		$ret['draw'] = $_GET['draw'];

		$sqlAsrama = DB::select("SELECT nama FROM asrama");
		$dataAsrama = [];
		foreach ($sqlAsrama as $row) {
			$nama = null;
			foreach ($row as $value) {
				$nama = $value;
			}
			$dataAsrama[] = $nama;
		}


		$sqlPeriode = DB::select("SELECT nama FROM periodes");
		$dataPeriode = [];
		foreach ($sqlPeriode as $row) {
			$nama = null;
			foreach ($row as $value) {
				$nama = $value;
			}
			$dataPeriode[] = $nama;
		}
		
		$ret['yadcf_data_6'] = $dataAsrama;
		$ret['yadcf_data_7'] = $dataPeriode;
		echo json_encode($ret);

	}
	
	// Penghuni status teralokasi
	public function grid2(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$user = Auth::user();
		
		if($user->is_admin == '1') {
			$select = "SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar, nama_kamar ";
			$presql = " FROM 
							(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar 
								FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND (status = 'Teralokasi') AND DATE(NOW()) <= tanggal_keluar) b 
								LEFT JOIN 
									(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
										FROM
										(
											SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
											FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
											GROUP BY f.id_pendaftaran_reguler
										) kamarList
									JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar) 
							c ON b.id_daftar = c.id_pendaftaran_reguler) a ";
		} else if ($user->is_pengelola == '1') {
			$asrama = DB::select('SELECT * FROM pengelola JOIN asrama
									WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = '.$user->id);
			$select = "SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar, nama_kamar ";
			$presql = " FROM 
							(SELECT * FROM (SELECT id_daftar, id_user, nama, nomor_identitas, jenis_identitas, jenis_kelamin, asrama, nama_periode, tanggal_masuk, tanggal_keluar 
								FROM users JOIN daftar_asrama_reguler WHERE id = id_user AND (status = 'Teralokasi') AND DATE(NOW()) <= tanggal_keluar AND asrama = '".$asrama[0]->nama."') b
								LEFT JOIN 
									(SELECT d.id_pendaftaran_reguler, created, d.id_kamar, e.nama AS nama_kamar
										FROM
										(
											SELECT f.id_pendaftaran_reguler, MAX(f.created_at) as created
											FROM kamar_reguler f JOIN kamar g ON f.id_kamar = g.id_kamar
											GROUP BY f.id_pendaftaran_reguler
										) kamarList
									JOIN kamar_reguler d JOIN kamar e WHERE d.id_pendaftaran_reguler = kamarList.id_pendaftaran_reguler AND d.created_at = kamarList.created AND d.id_kamar = e.id_kamar) 
							c ON b.id_daftar = c.id_pendaftaran_reguler) a ";		
		}
		
		$presql .= " WHERE a.asrama LIKE '%".$_GET['columns']['6']['search']['value']."%'";		
		$presql .= " AND a.nama_periode LIKE '%".$_GET['columns']['7']['search']['value']."%'";
		
		if($_GET['search']['value']) {	
			$presql .= " AND (a.id_daftar LIKE '%".$_GET['search']['value']."%' 
						OR a.id_user LIKE '%".$_GET['search']['value']."%'
						OR a.nama LIKE '%".$_GET['search']['value']."%'
						OR a.nomor_identitas LIKE '%".$_GET['search']['value']."%'
						OR a.jenis_identitas LIKE '%".$_GET['search']['value']."%'
						OR a.jenis_kelamin LIKE '%".$_GET['search']['value']."%'
						OR a.asrama LIKE '%".$_GET['search']['value']."%'
						OR a.nama_periode LIKE '%".$_GET['search']['value']."%'
						OR a.tanggal_masuk LIKE '%".$_GET['search']['value']."%'
						OR a.tanggal_keluar LIKE '%".$_GET['search']['value']."%'
						OR a.nama_kamar LIKE '%".$_GET['search']['value']."%')";
		}	
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_user) c".$presql);
		//print_r($qcount);
		$count = $qcount[0]->c;

		$results = DB::select($sql);
		$ret = [];
		foreach ($results as $row) {
			$r = [];
			foreach ($row as $value) {
				$r[] = $value;
			}
			$ret[] = $r;
		}

		$ret['data'] = $ret;
		$ret['recordsTotal'] = $count;
		$ret['iTotalDisplayRecords'] = $count;

		$ret['recordsFiltered'] = count($ret);
		$ret['draw'] = $_GET['draw'];

		$sqlAsrama = DB::select("SELECT nama FROM asrama");
		$dataAsrama = [];
		foreach ($sqlAsrama as $row) {
			$nama = null;
			foreach ($row as $value) {
				$nama = $value;
			}
			$dataAsrama[] = $nama;
		}


		$sqlPeriode = DB::select("SELECT nama FROM periodes");
		$dataPeriode = [];
		foreach ($sqlPeriode as $row) {
			$nama = null;
			foreach ($row as $value) {
				$nama = $value;
			}
			$dataPeriode[] = $nama;
		}
		
		$ret['yadcf_data_6'] = $dataAsrama;
		$ret['yadcf_data_7'] = $dataPeriode;
		echo json_encode($ret);

	}	


	public function update(Request $request) {
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
		/*
				$kamarReguler = null;
		$idKamarLama = null;
		$kamarLama = null;
		$idKamarBaru = null;
		$kamarBaru = null;
		$valid = true;
		
		$kamarReguler = KamarReguler::find($request->id_pendaftaran_reguler);
		if($kamarReguler) {
			$kamarReguler = KamarReguler::findOrFail($request->id_pendaftaran_reguler);
			$idKamarLama = $kamarReguler->id_kamar;
		} else { 
			$kamarReguler = new KamarReguler;
		}
		
		$idKamarBaru = $request->id_kamar;
	    
		if(!($idKamarLama == $idKamarBaru)) {		
			$kamarReguler->id_pendaftaran_reguler = $request->id_pendaftaran_reguler;
			$kamarReguler->id_kamar = $request->id_kamar;
			$kamarReguler->tanggal_awal = date("Y-m-d");
			$kamarReguler->tanggal_akhir = date("Y-m-d");
							
			if($idKamarLama != null) {
				$kamarLama = Kamar::find($idKamarLama);
				$kamarLama->jumlah_penghuni--;
				if($kamarLama->jumlah_penghuni < 0) $valid = false;
			}				
			if($idKamarBaru != null) {
				$kamarBaru = Kamar::find($idKamarBaru);
				$kamarBaru->jumlah_penghuni++;
				if($kamarBaru->jumlah_penghuni > $kamarBaru->kapasitas) $valid = false;
			}
			
			if($valid) {
				if ($idKamarLama != null) $kamarLama->save();
				if ($idKamarBaru != null) $kamarBaru->save();
				if($kamarReguler->id_kamar == null) {
					$kamarReguler->delete();
				} else {
					$kamarReguler->save();
				}
			}
		}
		
		if(!$valid) {
			return redirect('/alokasi')->with('message', 'Gagal mengalokasikan kamar! Kamar penuh.');
		} else {
			return redirect('/alokasi');
		}
		*/
		
		$kamarRegulerLama = null;
		$kamarRegulerBaru = null;
		$idKamarLama = null;
		$kamarLama = null;
		$idKamarBaru = null;
		$kamarBaru = null;
		$valid = true;
		
		$kamarRegulerLama = KamarReguler::where('id_pendaftaran_reguler', $request->id_pendaftaran_reguler)->orderBy('created_at', 'desc')->get()->first();
		$alokasi = Alokasi::findOrFail($request->id_pendaftaran_reguler);
		if($kamarRegulerLama != null) {
			$idKamarLama = $kamarRegulerLama->id_kamar;
			if($request->tanggal_masuk > date("Y-m-d")) { // tanggal sekarang lebih awal dibanding tanggal masuk
				$kamarRegulerBaru = KamarReguler::where('id_pendaftaran_reguler', $request->id_pendaftaran_reguler)->orderBy('created_at', 'desc')->get()->first();
			} else {
				$kamarRegulerBaru = new KamarReguler;	
			};
		} else {
			$kamarRegulerBaru = new KamarReguler;
		}
		
		$idKamarBaru = $request->id_kamar;
	    
		if(!($idKamarLama == $idKamarBaru)) {		
			$kamarRegulerBaru->id_pendaftaran_reguler = $request->id_pendaftaran_reguler;
			$kamarRegulerBaru->id_kamar = $request->id_kamar;
			if($idKamarLama == null || ($request->tanggal_masuk > date("Y-m-d"))) {
				$kamarRegulerBaru->tanggal_awal = $request->tanggal_masuk;
			} else {
				$kamarRegulerBaru->tanggal_awal = date("Y-m-d");
			}
			
			$kamarRegulerBaru->tanggal_akhir =  $request->tanggal_keluar;
			
			if($idKamarLama != null) {
				if(!($request->tanggal_masuk > date("Y-m-d"))) $kamarRegulerLama->tanggal_akhir = date("Y-m-d");
			/*	$kamarLama = Kamar::find($idKamarLama);
				$kamarLama->jumlah_penghuni--;
				if($kamarLama->jumlah_penghuni < 0) $valid = false;*/
			}				
			if($idKamarBaru != null) {
			/*	$kamarBaru = Kamar::find($idKamarBaru);
				$kamarBaru->jumlah_penghuni++;
				if($kamarBaru->jumlah_penghuni > $kamarBaru->kapasitas) $valid = false; */
			}
			
			if($valid) {
/*				if ($idKamarLama != null) $kamarLama->save();
				if ($idKamarBaru != null) $kamarBaru->save();*/
				if($kamarRegulerLama == null) {
					
				} else {
					$kamarRegulerLama->save();
				}
				if($kamarRegulerBaru->id_kamar == null) {
				
				} else {
					$kamarRegulerBaru->save();
				}
				$alokasi->status = "Teralokasi";
				$alokasi->save();
			}
		}
		
		if(!$valid) {
			return redirect('/alokasi')->with('message', 'Gagal mengalokasikan kamar! Kamar penuh.');
		} else {
			return redirect('/alokasi');
		}

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$alokasi = Alokasi::findOrFail($id);

		$alokasi->delete();
		return "OK";
	    
	}

	
}