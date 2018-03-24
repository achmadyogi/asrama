<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarif';
    protected $primaryKey = 'id_tarif';
    protected $fillable = ['deskripsi', 'nilai_tarif','nilai_tarif_TPB_BM', 'nilai_tarif_TPB_NBM', 'nilai_tarif_PS', 'nilai_tarif_IT', 'nilai_tarif_NON'];
    public $timestamps = false;
}
