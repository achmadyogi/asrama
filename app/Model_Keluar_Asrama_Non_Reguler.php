<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_Keluar_Asrama_Non_Reguler extends Model
{
    protected $table = 'keluar_asrama_non_reguler';
    protected $primaryKey = 'id_pendaftaran_non_reguler';

    public static function getSentRequest() {
    	$out = DB::table('daftar_asrama_non_reguler')
    	->where('id_user', Auth::user()->id)
    	->join('keluar_asrama_non_reguler', 'daftar_asrama_non_reguler.id_daftar', '=', 'keluar_asrama_non_reguler.id_pendaftaran_non_reguler')
    	->select('id_daftar',
            'daftar_asrama_non_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_non_reguler.tanggal_keluar as tanggal_akhir', 
            'keluar_asrama_non_reguler.tanggal_keluar as tanggal_keluar', 
            'alasan_keluar', 
            'status_keluar')
    	->get();
    	return $out;
    }

    public static function getProposedRequest() {
    	$out = DB::table('keluar_asrama_non_reguler')
    	->where('status_keluar', 'Diajukan')
        ->join('daftar_asrama_non_reguler', 'id_pendaftaran_non_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select('id_daftar', 
            'nama', 
            'daftar_asrama_non_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_non_reguler.tanggal_keluar as tanggal_akhir', 
            'keluar_asrama_non_reguler.tanggal_keluar as tanggal_keluar', 
            'alasan_keluar')
    	->get();
    	return $out;
    }

    public static function getApprovedRequest() {
    	$out = DB::table('keluar_asrama_non_reguler')
    	->where('status_keluar', 'Disetujui')
        ->join('daftar_asrama_non_reguler', 'id_pendaftaran_non_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select('id_daftar', 
            'nama', 
            'daftar_asrama_non_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_non_reguler.tanggal_keluar as tanggal_akhir', 
            'keluar_asrama_non_reguler.tanggal_keluar as tanggal_keluar', 
            'alasan_keluar')
    	->get();
    	return $out;
    }

    public static function getRejectedRequest() {
    	$out = DB::table('keluar_asrama_non_reguler')
    	->where('status_keluar', 'Ditolak')
        ->join('daftar_asrama_non_reguler', 'id_pendaftaran_non_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select('id_daftar', 
            'nama', 
            'daftar_asrama_non_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_non_reguler.tanggal_keluar as tanggal_akhir', 
            'keluar_asrama_non_reguler.tanggal_keluar as tanggal_keluar', 
            'alasan_keluar')
    	->get();
    	return $out;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pendaftaran_non_reguler', 'tanggal_keluar', 'alasan_keluar', 'status_keluar',
    ];
}
