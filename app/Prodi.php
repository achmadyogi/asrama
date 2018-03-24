<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim_prodi', 'nim_fakultas', 'nama', 'strata',
    ];

    public function fakultas()
    {
        return $this->belongsTo('App\Fakultas', 'nim_fakultas', 'id_fakultas');
    }
}
