<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;

class tarifController extends Controller
{
    public function  index() {
      $tarifReguler = Tarif::where('jenis_penyewaan', 'Reguler')->orderBy('asrama', 'desc')->get();
      $tarifHarian = Tarif::where('jenis_penyewaan', 'Harian')->orderBy('asrama', 'desc')->get();
      return view('tarif.tarif', [ 'tarifReguler'=>$tarifReguler, 'tarifHarian'=>$tarifHarian ]);
    }
}
