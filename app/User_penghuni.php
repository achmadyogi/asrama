<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_penghuni extends Model
{
    protected $table = 'user_penghuni';
    protected $primaryKey = 'id_penghuni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user','nomor_identitas', 'jenis_identitas', 'tempat_lahir', 'tanggal_lahir',
        'gol_darah', 'jenis_kelamin', 'alamat', 'kota', 'propinsi', 'kodepos', 'negara', 'agama',
        'pekerjaan', 'warga_negara', 'telepon', 'instansi',
        'nama_ortu_wali', 'pekerjaan_ortu_wali', 'alamat_ortu_wali', 'telepon_ortu_wali',
        'kontak_darurat', 'status_daftar'
    ];
}
