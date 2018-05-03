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
		$list_asrama = Asrama::orderBy('id_asrama', 'desc')->get();
		$tanggal = date("Y-m-d");
		
        
		// Query untuk mendapatkan data kamar pada sebuah asrama beserta jumlah penghuninya pada tanggal ini
		$kamars = DB::select('SELECT * 
                                FROM kamar LEFT JOIN 
                                (SELECT count(id_kamar) as jumlah_penghuni, id_kamar as id_kamar_penghuni 
                                    FROM kamar_penghuni GROUP BY id_kamar) as jumlah ON kamar.id_kamar = jumlah.id_kamar_penghuni');
        
		$kamars = collect($kamars);
		//dd($kamars);

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
					'nama_asrama' => isset($nama_asrama) ? $nama_asrama : ""]);
	}
}
