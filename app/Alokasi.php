<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alokasi extends Model
{
    protected $table = 'daftar_asrama_reguler';
	protected $primaryKey = 'id_daftar';
    public $timestamps = false;

}