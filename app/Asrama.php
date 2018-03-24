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
        return $this->hasMany('App\Gedung', 'id_asrama');
    }
}
