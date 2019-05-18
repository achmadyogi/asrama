<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_DownloadFile extends Model
{
    protected $table = 'file_download';
    protected $fillable = ['id_user','nama_file','deskripsi','url_file'];
}
