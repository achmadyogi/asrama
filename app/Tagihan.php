<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['daftar_asrama_id','daftar_asrama_type','jumlah_tagihan'];

    public function daftar_asrama(){
    	return $this->morphTo();
    }

}
