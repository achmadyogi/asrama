<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\initialDashboard;
use Illuminate\Support\Facades\Auth;
use App\Jadwal;
use Session;

class jadwalController extends Controller
{
    use initialDashboard;

    public function index(){
	    Session::flash('menu','viewJadwal');
	    return view('dashboard.admin.viewJadwal', $this->getInitialDashboard());
    }

    public function addJadwal(Request $request){
    	$jadwal = new Jadwal();
    	$jadwal->creator = $request->id;
    	$jadwal->judul = $request->judul;
    	$jadwal->deskripsi = $request->deskripsi;
    	$jadwal->tanggal = $request->tanggal;
    	$jadwal->save();
    	Session::flash('status2','Jadwal baru berhasi ditambahkan.');
    	return redirect()->back();
    }
    
}
