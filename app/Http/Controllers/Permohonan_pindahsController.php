<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Permohonan_pindah;
use DateTime;
use DB;

class Permohonan_pindahsController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
	    return view('permohonan_pindahs.index', []);
	}

	public function create(Request $request)
	{
	    return view('permohonan_pindahs.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
		$permohonan_pindah = Permohonan_pindah::findOrFail($id);
	    return view('permohonan_pindahs.add', [
	        'model' => $permohonan_pindah	    ]);
	}

	public function show(Request $request, $id)
	{
		$permohonan_pindah = Permohonan_pindah::findOrFail($id);
	    return view('permohonan_pindahs.show', [
	        'model' => $permohonan_pindah	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT id_permohonan, id_user, id_kamar_lama, alasan";
		$presql = " FROM permohonan_pindah a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE id_user LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id) c".$presql);
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

	    		
		$permohonan_pindah = null;
		if($request->id > 0) {
      $permohonan_pindah = Permohonan_pindah::findOrFail($request->id);
      $permohonan_pindah->id_kamar_lama = $request->id_kamar_lama;
      $permohonan_pindah->alasan = $request->alasan;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $permohonan_pindah->updated_at = $timestamp;
    }
		else {
			$permohonan_pindah = new Permohonan_pindah;
      $permohonan_pindah->id_user = \Auth::id();
      $permohonan_pindah->id_kamar_lama = $request->id_kamar_lama;
      $permohonan_pindah->alasan = $request->alasan;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $permohonan_pindah->updated_at = $timestamp;
      $permohonan_pindah->created_at = $timestamp;
		}
		
	    	    //$permohonan_pindah->user_id = $request->user()->id;
	    $permohonan_pindah->save();

	    return redirect('/permohonan_pindahs');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$permohonan_pindah = Permohonan_pindah::findOrFail($id);

		$permohonan_pindah->delete();
		return "OK";
	    
	}

	
}