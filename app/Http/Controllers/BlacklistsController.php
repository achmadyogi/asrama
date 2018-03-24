<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Blacklist;
use App\User;
use Auth;
use DB;

class BlacklistsController extends Controller
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
	    return view('blacklists.index', [  ]);
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
	    return view('blacklists.add', [
	        []
	    ]);
	}

	public function add(Request $request, $id)
	{
		$user = User::findOrFail($id);
	    return view('blacklists.add', [
	        'model' => $user	    ]);
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
		$blacklist = Blacklist::findOrFail($id);
	    return view('blacklists.add', [
	        'model' => $user, 'model_blacklist' => $blacklist 	    ]);
	}

	public function show(Request $request, $id)
	{
		$blacklist = Blacklist::findOrFail($id);
	    return view('blacklists.show', [
	        'model' => $blacklist	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT id_user, nama, email, username, alasan ";
		$presql = " FROM (SELECT id_user, nama, email, username, alasan FROM users JOIN blacklists WHERE id = id_user) a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE nama LIKE '%".$_GET['search']['value']."%' OR email LIKE '%".$_GET['search']['value']."%' OR username LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id_user) c".$presql);
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
		$blacklist = null;
		$blacklist = Blacklist::find($request->id_user);
		if($blacklist) { $blacklist = Blacklist::findOrFail($request->id_user); }
		else { 
			$blacklist = new Blacklist;
		}
	    

	    		
					    $blacklist->id_user = $request->id_user;
		
	    		
					    $blacklist->alasan = $request->alasan;
		
	    	    //$blacklist->user_id = $request->user()->id;
	    $blacklist->save();

	    return redirect('/blacklists');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$blacklist = Blacklist::findOrFail($id);

		$blacklist->delete();
		return "OK";
	    
	}

	
}