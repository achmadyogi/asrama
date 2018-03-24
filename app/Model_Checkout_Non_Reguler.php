<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_Checkout_Non_Reguler extends Model
{
    protected $table = 'checkout_non_reguler';
    protected $primaryKey = 'id_daftar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_daftar', 'tanggal_masuk', 'tanggal_keluar',
    ];
}
