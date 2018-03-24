<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_Pindah_Asrama_Reguler extends Model
{
   protected $table = 'pindah_asrama_reguler';
   protected $primaryKey = 'id_pendaftaran_reguler';

   public static function getSentRequest() {
    	$out = DB::table('daftar_asrama_reguler')
    	->where('id_user', Auth::user()->id)
    	->join('pindah_asrama_reguler', 'daftar_asrama_reguler.id_daftar', '=', 'pindah_asrama_reguler.id_pendaftaran_reguler')
    	->select(
            'id_daftar', 
            'daftar_asrama_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_reguler.tanggal_keluar as tanggal_akhir', 
            'alasan_pindah', 
            'status_pindah')
    	->get();
    	return $out;
    }

    public static function getProposedRequest() {
    	$out = DB::table('pindah_asrama_reguler')
    	->where('status_pindah', 'Diajukan')
        ->join('daftar_asrama_reguler', 'id_pendaftaran_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select(
            'id_daftar', 
            'nama', 
            'daftar_asrama_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_reguler.tanggal_keluar as tanggal_akhir',  
            'alasan_pindah')
    	->get();
    	return $out;
    }

    public static function getApprovedRequest() {
    	$out = DB::table('pindah_asrama_reguler')
    	->where('status_pindah', 'Disetujui')
        ->join('daftar_asrama_reguler', 'id_pendaftaran_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select(
            'id_daftar', 
            'nama', 
            'daftar_asrama_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_reguler.tanggal_keluar as tanggal_akhir', 
            'alasan_pindah')
    	->get();
    	return $out;
    }

     public static function getRejectedRequest() {
    	$out = DB::table('pindah_asrama_reguler')
    	->where('status_pindah', 'Ditolak')
        ->join('daftar_asrama_reguler', 'id_pendaftaran_reguler', '=', 'id_daftar')
        ->join('users', 'id_user', '=', 'id')
        ->select('id_daftar', 
            'nama', 
            'daftar_asrama_reguler.tanggal_masuk as tanggal_awal', 
            'daftar_asrama_reguler.tanggal_keluar as tanggal_akhir',  
            'alasan_pindah')
    	->get();
    	return $out;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pendaftaran_reguler', 'alasan_pindah', 'status_pindah',
    ];

}
