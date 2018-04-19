<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $fillable = ['title', 'isi', 'file'];

    public function user(){
    	return $this->belongsTo('App/User','id_penulis');
    }
}
