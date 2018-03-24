<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\KerusakanKamar;
use App\User;
use App\Kamar;

use DB;

class KerusakanKamarController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
		if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();
          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return redirect('/dashboard');
          }
        } 
	    return view('kerusakan_kamar.index', []);
	}

	public function create(Request $request)
	{
	    if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();
          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return redirect('/dashboard');
          }
        } 
	    return view('kerusakan_kamar.add', [
	        []
	    ]);
	}
	
	public function add(Request $request, $id_kamar)
	{
		$id_user = Auth::user()->id;
		$kamar = Kamar::find($id_kamar);
	    return view('kerusakan_kamar.add', [
	        'id_user' => $id_user,
			'kamar' => $kamar	    ]);
	}	

	public function edit(Request $request, $id)
	{
	    if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();
          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return redirect('/dashboard');
          }
        } 	
		$kerusakan_kamar = KerusakanKamar::findOrFail($id);
		$kamar = Kamar::find($kerusakan_kamar->id_kamar);
	    return view('kerusakan_kamar.add', [
	        'model' => $kerusakan_kamar,
			'kamar' => $kamar			]);
	}

	public function show(Request $request, $id)
	{
	    if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();
          if(!($user->is_admin == '1' || $user->is_pengelola == '1')) {
            return redirect('/dashboard');
          }
        } 	
		$kerusakan_kamar = KerusakanKamar::findOrFail($id);
	    return view('kerusakan_kamar.show', [
	        'model' => $kerusakan_kamar	    ]);
	}

	public function grid(Request $request)
	{
		
		$len = $_GET['length'];
		$start = $_GET['start'];

		$user = Auth::user();
		
		if($user->is_admin == '1') {		
			$select = "SELECT id_kerusakan, nama, keterangan, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), status ";
			$presql = " FROM (SELECT id_kerusakan, kamar.nama, keterangan, created_at, kerusakan_kamar.status
										FROM kerusakan_kamar JOIN asrama JOIN gedung JOIN kamar
										WHERE asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung AND kamar.id_kamar = kerusakan_kamar.id_kamar) a 
										ORDER BY created_at DESC";
		} else if ($user->is_pengelola == '1') {
			$asrama = DB::select('SELECT id_kamar FROM pengelola JOIN asrama JOIN gedung JOIN kamar
							WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = '.$user->id.' AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung');
			$select = "SELECT id_kerusakan, nama, keterangan, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), status ";
			$presql = " FROM (SELECT id_kerusakan, kamar.nama, keterangan, created_at, kerusakan_kamar.status
										FROM kerusakan_kamar JOIN pengelola JOIN asrama JOIN gedung JOIN kamar
										WHERE asrama.id_asrama = pengelola.id_asrama AND pengelola.id_user = ".$user->id." AND asrama.id_asrama = gedung.id_asrama AND gedung.id_gedung = kamar.id_gedung AND kamar.id_kamar = kerusakan_kamar.id_kamar) a 
										ORDER BY created_at DESC";
		}
		if($_GET['search']['value']) {	
			$presql .= " WHERE id_kamar LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_kerusakan) c".$presql);
		//print_r($qcount);
		$count = $qcount[0]->c;

		$results = DB::select($sql);
		$ret = [];
		foreach ($results as $row) {
			$r = [];
			foreach ($row as $value) {
				$r[] = $value;
			}
			$ret[] = $r;
		}

		$ret['data'] = $ret;
		$ret['recordsTotal'] = $count;
		$ret['iTotalDisplayRecords'] = $count;

		$ret['recordsFiltered'] = count($ret);
		$ret['draw'] = $_GET['draw'];

		echo json_encode($ret);

	}


	public function update(Request $request) {
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
		
		$isNew = false;
		
		$kerusakan_kamar = null;
		$kerusakan_kamar = KerusakanKamar::find($request->id_kerusakan);
		if($kerusakan_kamar) { $kerusakan_kamar = KerusakanKamar::findOrFail($request->id_kerusakan); }
		else { 
			$kerusakan_kamar = new KerusakanKamar;
			$isNew = true;
		}
	    

	    		
					    $kerusakan_kamar->id_kerusakan = $request->id_kerusakan;
		
	    		
					    $kerusakan_kamar->id_kamar = $request->id_kamar;
		
	    		
					    $kerusakan_kamar->id_pelapor = $request->id_pelapor;
		
	    		
					    $kerusakan_kamar->keterangan = $request->keterangan;
						
						if($kerusakan_kamar->status) {
							$kerusakan_kamar->status = $request->status;
						}
		
	    	    //$kerusakan_kamar->user_id = $request->user()->id;
	    $kerusakan_kamar->save();

		if($isNew) {
			return redirect('/dashboard');
		} else {
			return redirect('/kerusakan_kamar');
		}

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$kerusakan_kamar = KerusakanKamar::findOrFail($id);

		$kerusakan_kamar->delete();
		return "OK";
	    
	}

	
}