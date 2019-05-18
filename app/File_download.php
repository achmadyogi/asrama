<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File_download extends Model
{
    protected $table = 'file_download';
    protected $primaryKey = 'id_file';
    protected $fillable = ['id_user','nama_file','deskripsi','url_file'];

    public function user(){
    	$this->belongsTo('App\User','id_user');
    }
}
