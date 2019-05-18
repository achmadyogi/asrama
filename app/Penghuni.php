<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';
    protected $primaryKey = 'id_penghuni';
    protected $fillable = ['daftar_asrama_id', 'daftar_asrama_type', 'surat_perjanjian','ktm','keterangan'];

}
