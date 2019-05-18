<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SSO\SSO;
use App\User;
use Illuminate\Support\Facades\Auth;


class SSOLoginController extends Controller
{
    public function SSOLogin(){

    	// Authenticate the user
		SSO::authenticate();

		//if authenticate
		$user = SSO::getUser();

		// Check SSO availability
		$check = User::where(['ITBmail' => $user->ITBmail])->get();
		$count = 0;
		foreach ($check as $c) {
			$count += 1;
		}
		// If exist then SSO has been verified to a user
		if($count > 0){
			// Authenticated -> go to dashboard
			return view('dashboard.dashboard', ['user'=>$user]);
		}else{
			// Returning to an application for registering SSO to an existing account
			return view('auth.SSOregister', ['user'=>$user]);
		}	
		
    }

    public function SSOlogout(){
    	// Check authentication for default
    	if(Auth::guest()){
    		// Logout from INA
    		$url = 'https://asrama.itb.ac.id';
        	SSO::logout($url);
    	}else{
    		Auth::logout();
    		return redirect('home');
    	}
    }
}
