<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['judul','deskripsi','creator','tanggal'];
}

?>
