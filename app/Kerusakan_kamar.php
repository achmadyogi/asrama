<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kerusakan_kamar extends Model
{
    protected $table = 'kerusakan_kamar';
	protected $primaryKey = 'id_kerusakan';

	public function user()
	{
		$this->belongsTo('App\User','id_pelapor');
	}

	public function kamar()
	{
		$this->belongsTo('App\Kamar','id_kamar');
	}
}
