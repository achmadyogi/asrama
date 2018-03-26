<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model_Pengumuman;
use App\Model_Berita;

class HomeController extends Controller
{
    //untuk menampilkan halaman pengumuman
    public function load_all_pengumuman() {
      $pengumuman = Model_Pengumuman::all()->sortByDesc("updated_at")->take(5);
      return view('/pengumuman', ['pengumuman'=> $pengumuman, 'user' => Auth::user()]);
    }

    //untuk menampilkan pengumuman dan berita di halaman awal web
    public function load_all_pengumuman_welcome() {
      $pengumuman = Model_Pengumuman::all()->sortByDesc("updated_at")->take(5);
      $berita = Model_Berita::all()->sortByDesc("updated_at")->take(5);
      return view('/welcome', ['pengumuman'=> $pengumuman,
        'berita' => $berita,
        'user' => Auth::user()]);
    }

    //untuk menampilkan halaman berita
    public function load_all_berita() {
      $berita = Model_Berita::all()->sortByDesc("updated_at")->take(5);
      return view('/berita', ['berita'=>$berita, 'user' => Auth::user()]);
    }
}
