<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar_asrama_reguler extends Model
{
    protected $table = 'daftar_asrama_reguler';
    protected $primaryKey = 'id_daftar';

    protected $fillable = [
        'id_user',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function user_penghuni(){
    	return $this->belongsTo('App\User_penghuni', 'id_user', 'id_user');
    }
    public function kamar_penghuni(){
    	return $this->morphMany('App\kamar_penghuni','daftar_asrama');
    }
    public function tagihan(){
        return $this->morphMany('App\Tagihan','daftar_asrama');
    }
    public function periode(){
        return $this->belongsTo('App\Periode','id_periode');
    }
}
