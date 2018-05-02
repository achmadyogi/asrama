<?php
namespace App\Http\Controllers\Traits;
use Carbon\Carbon;

trait tanggalWaktu{
  public function date($tanggal){
        $dateSpace1 = explode(' ',$tanggal);
        $dateArray1 = explode('-',$dateSpace1[0]);
        $time1 = explode(':',$dateSpace1[1]);
        $utc = Carbon::create($dateArray1[0],$dateArray1[1],$dateArray1[2],$time1[0],$time1[1],$time1[2]);
        $wib = $utc->addHours(7);
        $dateSpace = explode(' ',$wib);
        $dateArray = explode('-',$dateSpace1[0]);
        $time = explode(':',$dateSpace[1]);
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
        $dateResult = $dateArray[2]." ".$bulan." ".$dateArray[0].", at ".$time[0].":".$time[1]." WIB";
        return $dateResult;
    }
}

?>