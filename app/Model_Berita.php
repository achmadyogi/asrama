<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey= 'id_berita';
    protected $fillable = ['title', 'isi'];
}
