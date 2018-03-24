<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tarif;
use App\Asrama;

use DB;

class AdmintarifController extends Controller
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
            return redirect('/dashboard');
          }
        }
  	    return view('admintarif.index', []);
  	}

	public function create(Request $request)
	{
      	if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();

          if(!($user->is_sekretariat == '1')) {
            return redirect('/dashboard');
          }
        }
      $dataAsrama = Asrama::all();
	    return view('admintarif.add', ['model' => null, 'dataAsrama' => $dataAsrama]);
	}

	public function edit(Request $request, $id)
	{
      	if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();

          if(!($user->is_sekretariat == '1')) {
            return redirect('/dashboard');
          }
        }
		  $tarif = Tarif::findOrFail($id);
      $dataAsrama = Asrama::all();
	    return view('admintarif.add', ['model' => $tarif, 'dataAsrama' => $dataAsrama]);
	}

	public function show(Request $request, $id)
	{
    	if (Auth::guest()) {
          return redirect('/home');
        } else {
          $user = Auth::user();

          if(!($user->is_sekretariat == '1')) {
            return redirect('/dashboard');
          }
        }
		$tarif = Tarif::findOrFail($id);
	    return view('admintarif.show', [
	        'model' => $tarif	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT jenis_penyewaan, asrama, nilai_tarif_TPB_BM, nilai_tarif_TPB_NBM, nilai_tarif_PS, nilai_tarif_IT, nilai_tarif_NON, id_tarif ";
		$presql = " FROM tarif a ";
		if($_GET['search']['value']) {
			$presql .= " WHERE asrama LIKE '%".$_GET['search']['value']."%' ";
		}

		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_tarif) c".$presql);
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
		$tarif = null;
		if($request->id > 0) {
      $tarif = Tarif::findOrFail($request->id);
    } else {
			$tarif = new Tarif;
		}
      $tarif->jenis_penyewaan = $request->jenis_penyewaan;
      $tarif->asrama = $request->asrama;
      $tarif->nilai_tarif_TPB_BM = $request->nilai_tarif_TPB_BM;
      $tarif->nilai_tarif_TPB_NBM = $request->nilai_tarif_TPB_NBM;
      $tarif->nilai_tarif_PS = $request->nilai_tarif_PS;
      $tarif->nilai_tarif_IT = $request->nilai_tarif_IT;
      $tarif->nilai_tarif_NON = $request->nilai_tarif_NON;
	    //$tarif->user_id = $request->user()->id;
	    $tarif->save();

	    return redirect('/admintarif');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {

		$tarif = Tarif::findOrFail($id);

		$tarif->delete();
		return "OK";

	}


}
