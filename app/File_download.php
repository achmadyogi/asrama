<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File_download extends Model
{
    protected $table = 'file_download';
    protected $primaryKey = 'id_file';

    public function user(){
    	$this->belongsTo('App\User','id_user');
    }
}
