<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';
    protected $fillable = ['title', 'isi'];
}
