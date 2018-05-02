<?php

namespace App\Http\Controllers\informasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class pendaftaranController extends Controller
{
	public function index(){
		if(Auth::guest()){
			$user = 0;
		}else{
			$user = Auth::User()->id;
		}
	    $tarif = DB::Select('select * from tarif left join asrama on tarif.id_asrama = asrama.id_asrama');
	    return view('informasi.pendaftaran',['tarif' => $tarif, 'user' => $user]);
	}
}
