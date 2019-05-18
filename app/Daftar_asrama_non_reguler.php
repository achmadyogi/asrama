<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar_asrama_non_reguler extends Model
{
    protected $table = 'daftar_asrama_non_reguler';
    protected $primaryKey = 'id_daftar';
    protected $fillable = ['id_user','tujuan_tinggal','preference','lokasi_asrama','verification','is_difable','ket_difable', 'tanggal_masuk','tempo','lama_tinggal','jenis_penghuni'];
    protected $nullable = ['ket_difable'];

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function user_penghuni(){
    	return $this->belongsTo('App\User_penghuni', 'id_user', 'id_user');
    }
    public function kamar_penghuni(){
    	return $this->morphMany('App\Kamar_penghuni','daftar_asrama');
    }
    public function tagihan(){
        return $this->morphMany('App\Tagihan','daftar_asrama');
    }
}
