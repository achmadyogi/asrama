<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_nim extends Model
{
    protected $table = 'user_nim';
    protected $primaryKey = 'id_nim';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_fakultas', 'id_prodi', 'nim','status_nim',
    ];
    public function prodi(){
        return $this->hasOne('App\Prodi','id_prodi');
    }
    public function fakultas(){
        return $this->hasManyThrough('App\Fakultas','App\Prodi','nim_fakultas','id_prodi');
    }
    public function user(){
        return $this->belongsTo('App\User','id_user');
    }
}
