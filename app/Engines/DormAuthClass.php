<?php

namespace App\Engines;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SSO\SSO;
use App\User;
use Session;

class DormAuthClass
{
	public function User(){
		if(session()->has('SSOEntry') && session('SSOEntry') == 'true'){
			// User is authenticated using INA login
			$data = User::where(['ITBmail' => SSO::getUser()->ITBmail])->get();
			foreach ($data as $d) {
				$user = array(
						'id' => $d->id,
						'name' => $d->name,
						'email' => $d->email,
						'ITBmail' => $d->ITBmail,
						'username' => $d->username,
						'password' => $d->password,
						'verification' => $d->verification,
						'token_verification' => $d->token_verification,
						'remember_token' => $d->remember_token,
						'is_penghuni' => $d->is_penghuni,
						'is_pengelola' => $d->is_pengelola,
						'is_sekretariat' => $d->is_sekretariat,
						'is_pimpinan' => $d->is_pimpinan,
						'is_admin' => $d->is_admin,
						'is_keuangan' => $d->is_keuangan,
						'is_eksternal' => $d->is_eksternal,
						'foto_profil' => $d->foto_profil,
						'created_at' => $d->created_at,
						'updated_at' => $d->updated_at,
						'entry' => 'SSOEntry');
				$userArr = json_decode(json_encode($user),false);
			}
		}elseif(session()->has('AuthEntry') && session('AuthEntry') == 'true'){
			// User is authenticated using default login
			$user = array(
						'id' => Auth::user()->id,
						'name' => Auth::user()->name,
						'email' => Auth::user()->email,
						'ITBmail' => Auth::user()->ITBmail,
						'username' => Auth::user()->username,
						'password' => Auth::user()->password,
						'verification' => Auth::user()->verification,
						'token_verification' => Auth::user()->token_verification,
						'remember_token' => Auth::user()->remember_token,
						'is_penghuni' => Auth::user()->is_penghuni,
						'is_pengelola' => Auth::user()->is_pengelola,
						'is_sekretariat' => Auth::user()->is_sekretariat,
						'is_pimpinan' => Auth::user()->is_pimpinan,
						'is_admin' => Auth::user()->is_admin,
						'is_keuangan' => Auth::user()->is_keuangan,
						'is_eksternal' => Auth::user()->is_eksternal,
						'foto_profil' => Auth::user()->foto_profil,
						'created_at' => Auth::user()->created_at,
						'updated_at' => Auth::user()->updated_at,
						'entry' => 'AuthEntry');
			$userArr = json_decode(json_encode($user),false);
		}else{
			// If user is not authenticated
		    $user = array(
		        'empty' => '0');
		    $userArr = json_decode(json_encode($user),false);
		}
		return $userArr;
	}
}

?>