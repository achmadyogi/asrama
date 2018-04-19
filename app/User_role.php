<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
    protected $table = 'user_role';
    protected $primaryKey = 'id_role';

    public function user()
    {
    	$this->belongsTo('App\User','id_user');
    }
}
