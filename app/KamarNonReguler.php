<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KamarNonReguler extends Model
{
    protected $table = 'kamar_non_reguler';
	protected $primaryKey = 'id_pendaftaran_non_reguler';
 //   public $timestamps = false;
	public function kamar() {
		return $this->hasOne('App\Kamar', 'id_kamar');
	}
}