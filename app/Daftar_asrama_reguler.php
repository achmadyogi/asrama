<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar_asrama_reguler extends Model
{
    protected $table = 'daftar_asrama_reguler';
    protected $primaryKey = 'id_daftar';

    protected $fillable = [
        'id_user',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'id_user');
    }
}
