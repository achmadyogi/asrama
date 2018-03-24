<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KamarReguler extends Model
{
    protected $table = 'kamar_reguler';
	  protected $primaryKey = 'id_pendaftaran_reguler';

 //   public $timestamps = false;
	public function kamar() {
		return $this->hasOne('App\Kamar', 'id_kamar');
	}

	public function daftar_asrama_reguler() {
		return $this->hasOne('App\DaftarAsramaReguler', 'id_daftar', 'id_pendaftaran_reguler');
	}
	
	
}
