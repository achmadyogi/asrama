<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';

    public function user()
    {
    	$this->belongsTo('App\User','id_penulis');
    }
}
