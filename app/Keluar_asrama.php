<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keluar_asrama extends Model
{
	protected $table = 'keluar_asrama';
	protected $primaryKey = 'id_keluar_asrama';
	protected $fillable = ['daftar_asrama_id','daftar_asrama_type','tanggal_keluar','alasan_keluar', 'is_checkout'];

    public function daftar_Asrama(){
    	return $this->morphTo();
    }
}

class Daftar_asrama_non_reguler extends Model
{
	public function Keluar_asrama(){
		return $this->morphMany('App\Keluar_asrama','daftar_asrama');
	}
}

class Daftar_asrama_reguler extends Model
{
	public function Keluar_asrama(){
		return $this->morphMany('App\Keluar_asrama', 'daftar_asrama');
	}
}
