<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarAsramaNonReguler extends Model
{
    protected $table = 'daftar_asrama_non_reguler';
    protected $primaryKey = 'id_daftar';

    public function user() {
        return $this->hasOne('App\User', 'id_user');
    }
}
