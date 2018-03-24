<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{
	protected $primaryKey = 'id_user';
    protected $table = 'pengelola';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_asrama',
    ];
}
