<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permohonan_pindah extends Model
{
    //
    protected $table = 'permohonan_pindah';
    protected $primaryKey = 'id_permohonan';

    public function user()
    {
    	$this->belongsTo('App\User','id_user');
    }

    public function kamar_lama()
    {
    	$this->belongsTo('App\Kamar','id_kamar_lama');
    }

    public function kamar_baru()
    {
    	$this->belongsTo('App\Kamar','id_kamar_baru');
    }

}