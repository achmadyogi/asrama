<?php
namespace App\Http\Controllers\Traits;

trait tanggal{
	public function date($tanggal){
		$dateArray = explode('-',$dateSpace[0]);
		// Nama Bulan
        if($dateArray[1] == '01'){
          $bulan = 'Januari';
        }
        if($dateArray[1] == '02'){
          $bulan = 'Februari';
        }
        if($dateArray[1] == '03'){
          $bulan = 'Maret';
        }
        if($dateArray[1] == '04'){
          $bulan = 'April';
        }
        if($dateArray[1] == '05'){
          $bulan = 'Mei';
        }
        if($dateArray[1] == '06'){
          $bulan = 'Juni';
        }
        if($dateArray[1] == '07'){
          $bulan = 'Juli';
        }
        if($dateArray[1] == '08'){
          $bulan = 'Agustus';
        }
        if($dateArray[1] == '09'){
          $bulan = 'September';
        }
        if($dateArray[1] == '10'){
          $bulan = 'Oktober';
        }
        if($dateArray[1] == '11'){
          $bulan = 'November';
        }
        if($dateArray[1] == '12'){
          $bulan = 'Desember';
        }
        $dateResult = $dateArray[2]." ".$bulan." ".$dateArray[0];
        return $dateResult;
	}
}

?>