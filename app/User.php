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
        'name', 'username', 'email', 'password', 'verification', 'token_verification',
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
        return $this->hasOne('App\User_penghuni', 'id_user');
    }

    public function pengelola() {
        return $this->hasOne('App\Pengelola', 'id_user');
    }
	
	public function blacklist() {
		return $this->hasOne('App\Blacklist', 'id_user');
	}

    public function user_nim() {
        return $this->hasMany('App\User_nim', 'id_user');
    }
    public function daftar_asrama_reguler(){
        return $this->hasMany('App\Daftar_asrama_reguler', 'id_user');
    }
    public function daftar_asrama_non_reguler(){
        return $this->hasMany('App\Daftar_asrama_non_reguler', 'id_user');
    }
}
