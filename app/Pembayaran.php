<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [];

    public function tagihan()
    {
    	$this->belongsTo('App\Tagihan','id_tagihan');
    }
}
