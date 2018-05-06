<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';
    protected $primaryKey = 'id_periode';
    public $timestamps = false;
    protected $fillable = ['nama_periode','tanggal_buka_daftar','tanggal_tutup_daftar','tanggal_mulai_tinggal','tanggal_selesai_tinggal','jumlah_bulan','keterangan'];

    public function daftar_asrama_reguler(){
    	$this->hasMany('App\Daftar_asrama_reguler','id_periode');
    }
}