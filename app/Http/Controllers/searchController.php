<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User_nim;
use App\User_penghuni;
use App\Asrama;
use App\Next_periode;
use App\Periode;
use App\Blacklist;
use App\Keluar_asrama;
use App\kerusakan_kamar;
use App\Pengelola;
use App\Http\Controllers\Traits\initialDashboard;
use Session;
use App\Http\Controllers\Traits\tanggal;

class searchController extends Controller
{
    public function result(Request $request){
    	$search = $request->search;
    	// Pencarian di bagian pengumuman
    	$cariPengumuman = DB::select("SELECT * FROM pengumuman WHERE title LIKE ? OR isi LIKE ? ORDER BY id_pengumuman DESC",["%".$search."%","%".$search."%"]);
    	$count_p = 0;
    	foreach ($cariPengumuman as $carip) {
    		$judul_p[$count_p] = $carip->title;
    		$konten_p[$count_p] = $carip->isi;
    		$id_pengumuman[$count_p] = $carip->id_pengumuman;
    		$count_p += 1;
    	}
    	// Pencarian di bagian berita
    	$cariBerita = DB::select("SELECT * FROM berita WHERE title LIKE ? OR isi LIKE ? ORDER BY id_berita DESC",["%".$search."%","%".$search."%"]);
    	$count_b = 0;
    	foreach ($cariBerita as $carib) {
    		$judul_b[$count_b] = $carib->title;
    		$konten_b[$count_b] = $carib->isi;
    		$id_berita[$count_b] = $carib->id_berita;
    		$count_b += 1;
    	}
        // Pencarian di bagian download
        $cariDownload = DB::select("SELECT * FROM file_download WHERE nama_file LIKE ? OR deskripsi LIKE ? ORDER BY id_file DESC",["%".$search."%","%".$search."%"]);
        $count_d = 0;
        foreach ($cariDownload as $carid) {
            $judul_d[$count_d] = $carid->nama_file;
            $konten_d[$count_d] = $carid->deskripsi;
            $id_file[$count_d] = $carid->id_file;
            $count_d += 1;
        }

    	if($count_b == 0){
    		$id_berita = 0;
            $judul_b = 0;
            $konten_b = 0;
    	}
    	if($count_p == 0){
    		$id_pengumuman = 0;
            $judul_p = 0;
            $konten_p = 0;
    	}
        if($count_d == 0){
            $id_file = 0;
            $judul_d = 0;
            $konten_d = 0;
        }
    	return view('search', ['search'=>$search, 
                               'judul_p' => $judul_p, 
                               'konten_p' => $konten_p,
                               'judul_b' => $judul_b, 
                               'konten_b' => $konten_b,
                               'judul_d' => $judul_d, 
                               'konten_d' => $konten_d, 
                               'count_p' => $count_p, 
                               'count_b' => $count_b, 
                               'count_d' => $count_d, 
                               'id_berita' => $id_berita, 
                               'id_pengumuman' => $id_pengumuman, 
                               'id_file' => $id_file]);
    }
    public function index(){
        $zonk = 'yes';
        return view('search', ['zonk' => $zonk]);
    }
}
