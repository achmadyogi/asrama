<?php

namespace App\Http\Controllers\informasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asrama;

class petaController extends Controller
{
	public function index(){
		$asrama = Asrama::all();
    	return view('informasi.peta',['asrama'=>$asrama]);
	}
}
