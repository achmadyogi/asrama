<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $table = 'blacklists';
	protected $primaryKey = 'id_user';
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\User', 'id_user');
	}
}