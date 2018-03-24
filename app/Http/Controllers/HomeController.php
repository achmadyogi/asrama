<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model_Pengumuman;
use App\Model_Berita;

class HomeController extends Controller
{
    public function load_all_pengumuman() {
      $pengumuman = Model_Pengumuman::all()->sortByDesc("updated_at")->take(5);
      return view('/pengumuman', ['pengumuman'=> $pengumuman, 'user' => Auth::user()]);
    }

    public function load_all_pengumuman_welcome() {
      $pengumuman = Model_Pengumuman::all()->sortByDesc("updated_at")->take(5);
      $berita = Model_Berita::all()->sortByDesc("updated_at")->take(5);
      return view('/welcome', ['pengumuman'=> $pengumuman,
        'berita' => $berita,
        'user' => Auth::user()]);
    }

    public function load_all_berita() {
      $berita = Model_Berita::all()->sortByDesc("updated_at")->take(5);
      return view('/berita', ['berita'=>$berita, 'user' => Auth::user()]);
    }
}
