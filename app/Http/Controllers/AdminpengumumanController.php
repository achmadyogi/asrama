<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Model_Pengumuman;

use DB;

class AdminpengumumanController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('auth');
    }


  public function index(Request $request)
	{
	    return view('adminpengumuman.index', []);
	}

	public function create(Request $request)
	{
      if (Auth::guest()) {
        return redirect('/home');
      } else {
        $user = Auth::user();

        if(!($user->is_admin == '1')) {
          return redirect('/dashboard');
        }
      }
	    return view('adminpengumuman.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
    if (Auth::guest()) {
      return redirect('/home');
    } else {
      $user = Auth::user();

      if(!($user->is_admin == '1')) {
        return redirect('/dashboard');
      }
    }
		$model_pengumuman = Model_Pengumuman::findOrFail($id);
	    return view('adminpengumuman.add', [
	        'model' => $model_pengumuman	    ]);
	}

	public function show(Request $request, $id)
	{
		$model_pengumuman = Model_Pengumuman::findOrFail($id);
	    return view('adminpengumuman.show', [
	        'model' => $model_pengumuman	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT title, isi, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), DATE_FORMAT(updated_at, '%W, %d %M %Y %h:%i %p'), id_pengumuman, id_penulis ";
		$presql = " FROM pengumuman a ";
		if($_GET['search']['value']) {
			$presql .= " WHERE title LIKE '%".$_GET['search']['value']."%' ";
		}

		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_pengumuman) c".$presql);
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
		$model_pengumuman = null;
		if($request->id > 0) {
      $model_pengumuman = Model_Pengumuman::findOrFail($request->id);
      $model_pengumuman->title = $request->title;
      $model_pengumuman->isi = $request->isi;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $model_pengumuman->updated_at = $timestamp;
    }
		else {
			$model_pengumuman = new Model_Pengumuman;
      $model_pengumuman->id_penulis = \Auth::id();
      $model_pengumuman->title = $request->title;
      $model_pengumuman->isi = $request->isi;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $model_pengumuman->updated_at = $timestamp;
      $model_pengumuman->created_at = $timestamp;
		}

	    //$model_pengumuman->user_id = $request->user()->id;
	    $model_pengumuman->save();

	    return redirect('/adminpengumuman');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {

		$model_pengumuman = Model_Pengumuman::findOrFail($id);

		$model_pengumuman->delete();
		return "OK";

	}


}
