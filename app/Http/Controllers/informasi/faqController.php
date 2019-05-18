<?php

namespace App\Http\Controllers\informasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class faqController extends Controller
{
	public function index(){
		return view('informasi.faq');
	}
}
