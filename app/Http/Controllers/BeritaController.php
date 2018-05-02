<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;

class BeritaController extends Controller
{
    public function showBerita($id_berita) {
        $berita = Berita::where('id_berita', $id_berita)->get()->first();
        $list_berita = Berita::all();
        return view('berita.show')
            ->with(['berita' => $berita,
                    'list_berita' => $list_berita,]);
    }

    public function index() {
        $list_berita = Berita::all();
        return view('berita.index')
            ->with(['list_berita' => $list_berita]);
    }
}
