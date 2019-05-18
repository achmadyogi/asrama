<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
	protected $primaryKey = 'id_kamar';
    public $timestamps = false;
    protected $fillable = ['id_gedung','nama','kapasitas','status','keterangan','gender','which_user','is_difable'];

    public function gedung(){
    	$this->belongsTo('App\Gedung','id_gedung');
    }
    
}