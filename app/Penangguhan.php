<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penangguhan extends Model
{
    protected $table = 'penangguhan';
    protected $primaryKey = 'id_penangguhan';
    protected $fillable = ['id_pembayaran','id_tagihan', 'jumlah_tangguhan','alasan_penangguhan','deadline_pembayaran','is_sktm','formulir_penangguhan','is_bayar'];

    public function pembayaran()
    {
    	$this->belongsTo('App\Tagihan','id_tagihan','id_tagihan');
    }
}
