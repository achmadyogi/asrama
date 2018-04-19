<?php

namespace App\Http\Controllers\penghuni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class nimController extends Controller
{
    public function index(){
    	$nim = $_POST['nim'];
    	if($nim == 1){
    		$msg = '<input type="number" name="nim" placeholder="Masukkan NIM" class="input"><br><br>';
    		return response()->json(array('msg'=> $msg));
    	}
    }
}
