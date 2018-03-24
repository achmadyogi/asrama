<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Periode;

use DB;

class PeriodesController extends Controller
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

			if(!($user->is_sekretariat == '1')) {
		  		return view('/dashboard');
			}
		}
	    return view('periodes.index', []);
	}

	public function create(Request $request)
	{
		if (Auth::guest()) {
			return redirect('/home');
		} else {
			$user = Auth::user();

			if(!($user->is_sekretariat == '1')) {
		  		return view('/dashboard');
			}
		}
	    return view('periodes.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
		if (Auth::guest()) {
			return redirect('/home');
		} else {
			$user = Auth::user();

			if(!($user->is_sekretariat == '1')) {
		  		return view('/dashboard');
			}
		}
		$periode = Periode::findOrFail($id);
	    return view('periodes.add', [
	        'model' => $periode	    ]);
	}

	public function show(Request $request, $id)
	{
		$periode = Periode::findOrFail($id);
	    return view('periodes.show', [
	        'model' => $periode	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT id_periode, nama, DATE_FORMAT(tanggal_awal, '%W, %d %M %Y'), DATE_FORMAT(tanggal_akhir, '%W, %d %M %Y'), status ";
		$presql = " FROM periodes a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE tanggal_awal LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_periode) c".$presql);
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
		$periode = null;
		$periode = Periode::find($request->id_periode);
		if($periode) { $periode = Periode::findOrFail($request->id_periode); }
		else { 
			$periode = new Periode;
		}
	    

	    		
					    $periode->id_periode = $request->id_periode;
						$periode->nama = $request->nama;
	    		
					    $periode->tanggal_awal = $request->tanggal_awal;
		
	    		
					    $periode->tanggal_akhir = $request->tanggal_akhir;
		
	    		
					    $periode->status = $request->status;
		
	    	    //$periode->user_id = $request->user()->id;
	    $periode->save();

	    return redirect('/periodes');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$periode = Periode::findOrFail($id);

		$periode->delete();
		return "OK";
	    
	}

	
}