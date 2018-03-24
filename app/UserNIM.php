<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNIM extends Model
{
    protected $table = 'user_nim';
    protected $primaryKey = 'id_nim';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_fakultas', 'id_prodi', 'nim','status_nim',
    ];
}
