<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarif';
    protected $primaryKey = 'id_tarif';
    protected $fillable = ['id_asrama','kapasitas_kamar','tempo','tarif_sarjana','tarif_pasca_sarjana','tarif_international','tarif_umum'];
    public $timestamps = false;
}
