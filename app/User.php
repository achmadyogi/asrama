<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
	
	protected $primaryKey = 'id';
	protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'email', 'password', 
        'is_penghuni', 'is_pengelola', 'is_sekretariat', 'is_pimpinan', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_penghuni() {
        return $this->hasOne('App\UserPenghuni', 'id_user');
    }

    public function pengelola() {
        return $this->hasOne('App\Pengelola', 'id_user');
    }
	
	public function blacklist() {
		return $this->hasOne('App\Blacklist', 'id_user');
	}

    public function user_nim() {
        return $this->hasMany('App\UserNIM', 'id_user');
    }

    public function valid_nim() {
        return $this->hasMany('App\UserNIM', 'id_user')->where('status_nim', 1)->orderBy('created_at', 'desc')->take(1);
    }

    public function daftar_reguler() {
        return $this->hasMany('App\DaftarAsramaReguler', 'id_user');
    }

    public function daftar_non_reguler() {
        return $this->hasMany('App\DaftarAsramaNonReguler', 'id_user');
    }
}
