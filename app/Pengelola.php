<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{
	protected $primaryKey = 'id_pengelola';
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

    public function user()
    {
        $this->belongsTo('App\User','id_user');
    }

    public function asrama()
    {
        $this->belongsTo('App\Asrama','id_asrama');
    }
}
