<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{
    protected $table = 'asrama';
    protected $primaryKey = 'id_asrama';
    public $timestamps = false;
	
	public function getNama($string)
	{
		return $this->where('nama', $string)->get();
	}
	
	public function gedung()
    {
        return $this->hasMany('App\Gedung', 'id_asrama','id_gedung');
    }
    public function kamar()
    {
    	return $this->hasManyThrough('App\Kamar','App\Gedung','id_asrama','id_gedung','id_asrama','id_gedung');
    }
    public function pengelola()
    {
        return $this->hasMany('App\Pengelola','id_asrama','id_pengelola');
    }
}
