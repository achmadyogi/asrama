<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = ['id_tagihan','tanggal_bayar','nomor_transaksi','jumlah_bayar','keterangan','is_accepted','file'];

    public function tagihan()
    {
    	$this->belongsTo('App\Tagihan','id_tagihan');
    }
}
