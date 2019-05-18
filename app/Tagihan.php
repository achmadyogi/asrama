<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    protected $fillable = ['daftar_asrama_id','daftar_asrama_type','jumlah_tagihan','keterangan'];

    public function daftar_asrama(){
    	return $this->morphTo();
    }

    public function daftar_asrama_reguler() {
        return $this->belongsTo('App\Daftar_asrama_reguler','daftar_asrama_id','id_daftar');
    }

    public function penangguhan()
    {
        $this->hasOne('App\Penangguhan','id_tagihan', 'id_tagihan');
    }

    public function pembayaran()
    {
        $this->hasOne('App\Pembayaran','id_pembayaran', 'id_pembayaran');
    }

}
