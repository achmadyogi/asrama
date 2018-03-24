<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Pengelola;
use App\User;
use App\Blacklist;
use App\Asrama;

use DB;

class UsersController extends Controller
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

    		if(!($user->is_admin == '1')) {
    			return redirect('/dashboard');
    		}
    	}
		$blacklist = Blacklist::all();
	    return view('users.index', ['blacklist' => $blacklist]);
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
		$asrama_list = Asrama::all();
	    return view('users.add', [
	    	'asrama_list' => $asrama_list]);
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
		$user = User::findOrFail($id);
		$asrama_list = Asrama::all();
	    return view('users.add', [
	        'model' => $user,
	        'asrama_list' => $asrama_list,
	        ]);
	}

	public function show(Request $request, $id)
	{
		$user = User::findOrFail($id);
		
	    return view('users.show', [
	        'model' => $user,
	        ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT id,nama,email,created_at,updated_at,username ";
		$presql = " FROM users a";
		if($_GET['search']['value']) {	
			$presql .= " WHERE nama LIKE '%".$_GET['search']['value']."%' OR email LIKE '%".$_GET['search']['value']."%' OR username LIKE '%".$_GET['search']['value']."%' ";
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
		$user = null;
		if($request->id > 0) { $user = User::findOrFail($request->id); }
		else { 
			$user = new User;
		}

	    $user->nama = $request->nama;
	    $user->email = $request->email;

	    if ($request->reset_password) {
	    	$user->password = bcrypt('asramaitb');
	    }
	    
	    $user->username = $request->username;

	    $user->is_penghuni = ($request->penghuni_check) ? 1 : 0;
	    $user->is_pengelola = ($request->pengelola_check) ? 1 : 0;
	    $user->is_sekretariat = ($request->sekretariat_check) ? 1 : 0;
	    $user->is_pimpinan = ($request->pimpinan_check) ? 1 : 0;
	    $user->is_admin = ($request->admin_check) ? 1 : 0;

	    $user->save();

	    if ($request->pengelola_check) {
	    	$pengelola = $user->pengelola;
	    	if ($pengelola == null) {
	    		$pengelola = new Pengelola();
	    	}
	    	$pengelola->id_user = $user->id;
	    	$pengelola->id_asrama = $request->asrama;
	    	$pengelola->save();
	    }

	    return redirect('/users');
	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$user = User::findOrFail($id);

		$user->delete();
		return "OK";
	    
	}

	
}