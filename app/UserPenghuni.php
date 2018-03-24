<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPenghuni extends Model
{
    protected $table = 'user_penghuni';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_identitas', 'jenis_identitas', 'tempat_lahir', 'tanggal_lahir',
        'gol_darah', 'jenis_kelamin', 'alamat', 'agama',
        'pekerjaan', 'warga_negara', 'telepon', 'instansi',
        'nama_ortu_wali', 'pekerjaan_ortu_wali', 'alamat_ortu_wali', 'telepon_ortu_wali',
        'kontak_darurat',
    ];
}
