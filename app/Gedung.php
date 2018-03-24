<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';
    protected $primaryKey = 'id_gedung';
    public $timestamps = false;
	
	public function kamar()
    {
        return $this->hasMany('App\Kamar', 'id_gedung');
    }
}
