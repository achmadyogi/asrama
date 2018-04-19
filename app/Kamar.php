<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
	protected $primaryKey = 'id_kamar';
    public $timestamps = false;

    public function gedung(){
    	$this->belongsTo('App\Gedung','id_gedung');
    }
}