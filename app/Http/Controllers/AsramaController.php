<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Asrama;
use App\Gedung;
use App\Kamar;
use App\KamarReguler;
use App\KamarNonReguler;
use App\Pengelola;
use Illuminate\Support\Facades\Auth;

class AsramaController extends Controller
{
	public function index() {
		$user = Auth::user();
		$list_asrama = Asrama::orderBy('id_asrama', 'desc')->get();
		if ($user && $user->is_pengelola == '1') {
			$pengelola = Pengelola::find($user->id);
			$nama_asrama = Asrama::find($pengelola->id_asrama)->nama;
		}
		
		$tanggal = date("Y-m-d");
		
		
		// Query untuk mendapatkan data kamar pada sebuah asrama beserta jumlah penghuninya pada tanggal ini
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
												WHERE asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
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
		

		foreach ($list_asrama as $asrama) {
			$asrama->total_penghuni = 0;
			$asrama->kapasitas = 0;
			$list_gedung = Gedung::where('id_asrama', $asrama->id_asrama)->get();
			foreach ($list_gedung as $gedung) {
				$gedung->list_kamar = Kamar::where('id_gedung', $gedung->id_gedung)->get();
				$gedung->total_penghuni = 0;
				foreach ($gedung->list_kamar as $kamar) {
					$kamar->jumlah_penghuni = 0;
					foreach ($kamars as $kamarElement) {
						if ($kamarElement->id_kamar == $kamar->id_kamar) {
							$kamar->jumlah_penghuni = $kamarElement->jumlah_penghuni;
						}
					}				
					$gedung->total_penghuni += $kamar->jumlah_penghuni;
					$asrama->kapasitas += $kamar->kapasitas;
				}
				$asrama->total_penghuni += $gedung->total_penghuni;
			}
		}

		return view('asrama.index')
			->with(['list_asrama' => $list_asrama,
					'user' => $user,
					'nama_asrama' => isset($nama_asrama) ? $nama_asrama : ""]);
	}

	public function showCreateAsramaForm() {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_admin == '1') {
				return view('asrama.createAsrama');
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function createAsrama(Request $request) {
		$file = $request->file('img');
		$filename = $file->getClientOriginalName();
		$file->move(public_path("uploads"), $filename);

		$asrama = new Asrama();
		$asrama->nama = $request->nama;
		$asrama->deskripsi = $request->deskripsi;
		$asrama->alamat = $request->alamat;
		$asrama->filename = $filename;
		$asrama->save();

		return redirect('/asrama');
	}

	public function showEditAsramaForm($id_asrama) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				$data = Asrama::where('id_asrama', $id_asrama)->first();

				return view('asrama.editAsrama')
					->with(['data' => $data]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function editAsrama(Request $request) {
		$file = $request->file('img');
		if ($file != NULL) {
			$filename = $file->getClientOriginalName();
			$file->move(public_path("uploads"), $filename);
		}

		$asrama = Asrama::find($request->id);
		$asrama->nama = $request->nama;
		$asrama->deskripsi = $request->deskripsi;
		$asrama->alamat = $request->alamat;
		if ($file != NULL) {
			$asrama->filename = $filename;
		}
		$asrama->save();

		return redirect('/asrama');
	}

	public function deleteAsrama($id_asrama) {
		$list_gedung = Gedung::where('id_asrama', $id_asrama)->get();
		foreach ($list_gedung as $gedung) {
			$list_kamar = Kamar::where('id_gedung', $gedung->id_gedung)->get();
			foreach ($list_kamar as $kamar) {
				$kamar->delete();
			}
			
			$gedung->delete();
		}

		Asrama::find($id_asrama)->delete();

		return redirect('/asrama');
	}

	public function detailAsrama($id_asrama) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				$list_gedung = Gedung::where('id_asrama', $id_asrama)->get();
		
				$tanggal = date("Y-m-d");
				
				
				// Query untuk mendapatkan data kamar pada sebuah asrama beserta jumlah penghuninya pada tanggal ini
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
														WHERE asrama.id_asrama = '.$id_asrama.' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
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
										RIGHT JOIN kamar ON jumlahPenghuniList.id_kamar = kamar.id_kamar
										JOIN gedung JOIN asrama
										WHERE asrama.id_asrama = '.$id_asrama.' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung
									');
				$kamars = collect($kamars);		
				
				foreach ($list_gedung as $gedung) {
					$gedung->list_kamar = Kamar::where('id_gedung', $gedung->id_gedung)->get();
					$gedung->total_penghuni = 0;
					foreach ($gedung->list_kamar as $kamar) {

						$kamar->jumlah_penghuni = 0;
						foreach ($kamars as $kamarElement) {
							if ($kamarElement->id_kamar == $kamar->id_kamar) {
								$kamar->jumlah_penghuni = $kamarElement->jumlah_penghuni;
							}
						}
						
						$gedung->total_penghuni += $kamar->jumlah_penghuni;
					}
				}

				return view('Asrama.detailAsrama')
					->with(['id_asrama' => $id_asrama,
							'list_gedung' => $list_gedung]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function showCreateGedungForm($id_asrama) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				return view('asrama.createGedung')
						->with(['id_asrama' => $id_asrama]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function createGedung(Request $request, $id_asrama) {
		$gedung = new Gedung();
		$gedung->id_asrama = $id_asrama;
		$gedung->nama = $request->nama;
		$gedung->save();

		return redirect('/asrama/'.$id_asrama);
	}

	public function deleteGedung($id_asrama, $id_gedung) {
		$list_kamar = Kamar::where('id_gedung', $id_gedung)->get();
		foreach ($list_kamar as $kamar) {
			$kamar->delete();
		}

		Gedung::find($id_gedung)->delete();

		return redirect('/asrama/'.$id_asrama);
	}

	public function showEditGedungForm($id_asrama, $id_gedung) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				$gedung = Gedung::find($id_gedung);

				return view('asrama.editGedung')
						->with(['gedung' => $gedung,
								'id_asrama' => $id_asrama]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function editGedung(Request $request, $id_asrama, $id_gedung) {
		$gedung = Gedung::find($id_gedung);
		$gedung->nama = $request->nama;
		$gedung->save();

		return redirect('/asrama/'.$id_asrama);
	}

	public function showFormCreateKamar($id_asrama, $id_gedung) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				$gedung = Gedung::find($id_gedung);

				return view('asrama.createKamar')
					->with(['id_asrama' => $id_asrama,
							'gedung' => $gedung]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function createKamar(Request $request, $id_asrama, $id_gedung) {
		$kamar = new Kamar();
		$kamar->id_gedung = $id_gedung;
		$kamar->nama = $request->no_kamar;
		$kamar->kapasitas = $request->kapasitas;
		$kamar->status = $request->status;
		$kamar->gender = $request->gender;
		$kamar->save();

		return redirect('/asrama/'.$id_asrama."/".$id_gedung."/create_kamar");
	}

	public function showEditKamarForm($id_asrama, $id_gedung, $id_kamar) {
		if (Auth::guest()) {
			return redirect('/home');
		}
		else {
			$user = Auth::user();
			if ($user->is_pengelola == '1') {
				$kamar = Kamar::find($id_kamar);
				$gedung = Gedung::find($id_gedung);

				return view('asrama.editKamar')
						->with(['id_asrama' => $id_asrama,
								'kamar' => $kamar,
								'gedung' => $gedung]);
			}
			else {
				return redirect('/dashboard');
			}
		}
	}

	public function editKamar(Request $request, $id_asrama, $id_gedung, $id_kamar) {
		$kamar = Kamar::find($id_kamar);
		$kamar->nama = $request->no_kamar;
		$kamar->kapasitas = $request->kapasitas;
		$kamar->status = $request->status;
		$kamar->gender = $request->gender;
		$kamar->save();

		return redirect('/asrama/'.$id_asrama);
	}

	public function deleteKamar($id_asrama, $id_gedung, $id_kamar) {
		Kamar::find($id_kamar)->delete();

		return redirect('/asrama/'.$id_asrama);
	}
}
