<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    public $timestamps = false;
    protected $fillable = ['id_fakultas','nama_prodi','strata'];

    public function fakultas()
    {
        return $this->belongsTo('App\Fakultas', 'nim_fakultas');
    }

    public function user_nim()
    {
        return $this->belongsTo('App\Fakultas', 'id_prodi');
    }
}
