<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Auth;
use App\Model_Berita;

use DB;

class AdminberitaController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


  public function index(Request $request)
	{
	    return view('adminberita.index', []);
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
	    return view('adminberita.add', [
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
		$Model_Berita = Model_Berita::findOrFail($id);
	    return view('adminberita.add', [
	        'model' => $Model_Berita	    ]);
	}

	public function show(Request $request, $id)
	{
		$Model_Berita = Model_Berita::findOrFail($id);
	    return view('adminberita.show', [
	        'model' => $Model_Berita	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT title, isi, DATE_FORMAT(created_at, '%W, %d %M %Y %h:%i %p'), DATE_FORMAT(updated_at, '%W, %d %M %Y %h:%i %p'), id_berita, id_penulis";
		$presql = " FROM berita a ";
		if($_GET['search']['value']) {
			$presql .= " WHERE title LIKE '%".$_GET['search']['value']."%' ";
		}

		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_berita) c".$presql);
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
		$model_Berita = null;
		if($request->id > 0) {
      $model_Berita = Model_Berita::findOrFail($request->id);
      $model_Berita->title = $request->title;
      $model_Berita->isi = $request->isi;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $model_Berita->updated_at = $timestamp;
    } else {
			$model_Berita = new Model_Berita;
      $model_Berita->id_penulis = \Auth::id();
      $model_Berita->title = $request->title;
      $model_Berita->isi = $request->isi;
      $now = new DateTime();
      $timestamp = $now->getTimestamp();
      $model_Berita->updated_at = $timestamp;
      $model_Berita->created_at = $timestamp;
		}

	    $model_Berita->save();

	    return redirect('/adminberita');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {

		$Model_Berita = Model_Berita::findOrFail($id);

		$Model_Berita->delete();
		return "OK";

	}


}
