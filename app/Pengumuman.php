<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';
    protected $fillable = ['id_penulis','title','isi'];

    public function user()
    {
    	$this->belongsTo('App\User','id_penulis');
    }
}
