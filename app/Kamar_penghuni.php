<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamar_penghuni extends Model
{
    protected $table = 'kamar_penghuni';
	protected $primaryKey = 'id_kamar_penghuni';
	protected $fillable = ['daftar_asrama_id','daftar_asrama_type','id_kamar'];

    public function daftar_asrama(){
    	$this->morphTo();
    }

    public function daftar_asrama_reguler() {
        $this->belongsTo('App\Daftar_asrama_reguler','daftar_asrama_id','id_daftar');
    }
}