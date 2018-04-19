<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Next_periode extends Model
{
    protected $table = 'next_periode';
    protected $primaryKey = 'id_next_periode';

    public function periode_asal()
    {
    	$this->belongsTo('App\Periode','periode_asal');
    }

    public function periode_akhir()
    {
    	$this->belongsTo('App\Periode','periode_akhir');
    }
}
