<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlokasiNonReguler extends Model
{
    protected $table = 'daftar_asrama_non_reguler';
	protected $primaryKey = 'id_daftar';
    public $timestamps = false;

}