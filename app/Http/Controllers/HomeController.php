<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Berita;
use App\Pengumuman;
use App\Http\Controllers\Traits\tanggalWaktu;

class HomeController extends Controller
{
    use tanggalWaktu;
    //untuk menampilkan aplikasi
    public function index() {
      // Menampilkan aplikasi berita
      if(Berita::all()->count() > 0){
        $berita = Berita::all()->sortByDesc("updated_at")->take(4);
        $i = 0;
        foreach($berita as $date){
          $dateResult[$i] = $this->date($date->updated_at);
          $i += 1;
        }
      }else{
        $berita = '0';
        $dateResult = '0';
      }
      // Menampilkan aplikasi pengumuman
      if(Pengumuman::all()->count() > 0){
        $pengumuman = Pengumuman::all()->sortByDesc("updated_at")->take(5);
        $i = 0;
        foreach($pengumuman as $info){
          $dateInfo[$i] = $this->date($info->updated_at);
          $i += 1;
        }
      }else{
        $pengumuman = '0';
        $dateInfo = '0';
      }
      return view('/home', ['pengumuman'=> $pengumuman,
        'berita' => $berita, 'date' => $dateResult, 'dateInfo' => $dateInfo,
        'user' => Auth::user()]);
    }
}
