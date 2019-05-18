<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar_asrama_reguler extends Model
{
    protected $table = 'daftar_asrama_reguler';
    protected $primaryKey = 'id_daftar';

    protected $fillable = [
        'id_user','id_periode','preference','asrama','lokasi_asrama','verification','status_beasiswa','kampus_mahasiswa','has_penyakit','ket_penyakit','is_difable','ket_difable','is_international','tanggal_masuk'];

    protected $nullable = ['ket_penyakit','ket_difable'];

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function user_penghuni(){
        return $this->belongsTo('App\User_penghuni', 'id_user', 'id_user');
    }
    public function kamar_penghuni(){
        return $this->morphMany('App\Kamar_penghuni','daftar_asrama');
    }
    public function rooms() {
        return $this->hasOne('App\Kamar_penghuni','daftar_asrama_id','id_daftar');
    }
    public function bills() {
        return $this->hasOne('App\Tagihan','daftar_asrama_id','id_daftar');
    }
    public function tagihan(){
        return $this->morphMany('App\Tagihan','daftar_asrama');
    }
    public function periode(){
        return $this->belongsTo('App\Periode','id_periode');
    }
}
