<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout';
    protected $primaryKey = 'id_checkout';
    protected $fillable = ['daftar_asrama_id', 'daftar_asrama_type', 'tanggal_masuk', 'tanggal_keluar'];
}
