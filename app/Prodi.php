<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    public $timestamps = false;

    public function fakultas()
    {
        return $this->belongsTo('App\Fakultas', 'nim_fakultas');
    }
}
