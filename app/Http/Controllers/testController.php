<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\Penghuni;
use App\Penangguhan;
use ITBdorm;
use App\Pembayaran;
use DormAuth;

class testController extends Controller
{
    public function index(Request $request){
        echo DormAuth::User()->id;
    	$jabar =  "metoo";
        echo ITBdorm::CompareDateTime("2019-04-12 22:11:20","2019-04-12 10:11:45");
    	return view('test', ['jabar' => $jabar]);
    }

    public function testMove(){
    	$penangguhan = DB::select("SELECT id_penangguhan, penangguhan.id_pembayaran, pembayaran.id_tagihan FROM penangguhan LEFT JOIN pembayaran ON pembayaran.id_pembayaran = penangguhan.id_pembayaran");
    	foreach ($penangguhan as $r) {
    		$p = Penangguhan::where(['id_pembayaran' => $r->id_pembayaran])->take(1)->get();
    		foreach ($p as $p) {
    			$tang = Penangguhan::find($r->id_penangguhan);
    			$tang->id_tagihan = $r->id_tagihan;
    			$tang->save();
    		}
    	}
    	return redirect()->back();
    }
}
