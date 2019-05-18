<?php

namespace App\Engines;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Asrama;
use App\Gedung;
use App\Kamar;

class ITBdormClass
{
	// -- TOOLS AND ENGINES -- //

	// Retrieve date time
	public function DateTime($date){
		$dateSpace1 = explode(' ',$date);
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

	// Retrieve date only
	public function Date($date){
		$dateArray = explode('-',$date);
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

	// Compare date [1: older, 2: younger, 3: same]
	public function CompareDate($date1, $date2){
		$newDate1 = explode(' ', $date1);
		$newDate2 = explode(' ', $date2);
		$newDate1_date = explode('-',$newDate1[0]);
		$newDate2_date = explode('-',$newDate2[0]);
		$printDate1 = Carbon::createFromDate($newDate1_date[0],$newDate1_date[1],$newDate1_date[2]);
		$printDate2 = Carbon::createFromDate($newDate2_date[0],$newDate2_date[1],$newDate2_date[2]);
		if($printDate1<$printDate2){
			$value = 1;
		}elseif($printDate1>$printDate2){
			$value = 2;
		}else{
			$value = 3;
		}
		return $value;
	}

	// Compare date time [1: older, 2: younger, 3: same]
	public function CompareDateTime($date1, $date2){
		$newDate1 = explode(' ', $date1);
		$newDate2 = explode(' ', $date2);
		$newDate1_date = explode('-',$newDate1[0]);
		$newDate2_date = explode('-',$newDate2[0]);
		$newDate1_time = explode(':',$newDate1[1]);
		$newDate2_time = explode(':',$newDate2[1]);
		$printDate1 = Carbon::create($newDate1_date[0],$newDate1_date[1],$newDate1_date[2],$newDate1_time[0],$newDate1_time[1],$newDate1_time[2]);
		$printDate2 = Carbon::create($newDate2_date[0],$newDate1_date[1],$newDate2_date[2],$newDate2_time[0],$newDate2_time[1],$newDate2_time[2]);
		if($printDate1<$printDate2){
			$value = 1;
		}elseif($printDate1>$printDate2){
			$value = 2;
		}else{
			$value = 3;
		}
		return $value;
	}

	// Retrieve currency
	public function Currency($count){
		if($count >= 0){
		    $a = 3;
		    $i = 0;
		    $length = strlen($count);
		    $money = ',00';
		    while($length - $a + 3 >= 0){
		        if($length - $a + 3 >= 3){
		    	    $money = substr($count, $a*(-1), 3).$money;
		        }else{
		            $final = 'Rp '.substr($count, $a*(-1), $length%3).$money;
		        }
		        if($length - $a != 0){
		            $money = '.'.$money;  
		        }
		        $i += 1;
		        $a = $a + 3;
		    }
		}else{
		    $count = $count*(-1);
		    $a = 3;
		    $i = 0;
		    $length = strlen($count);
		    $money = ',00';
		    while($length - $a + 3 >= 0){
		        if($length - $a + 3 >= 3){
		            $money = substr($count, $a*(-1), 3).$money;
		        }else{
		            $final = 'Rp -'.substr($count, $a*(-1), $length%3).$money;
		        }
		        if($length - $a != 0){
		            $money = '.'.$money;  
		        }
		        $i += 1;
		        $a = $a + 3;
		    }
		}
		  
		return $final;
	}

	// Break date into day, month, and year
	public function BreakDate($date){
		$newDate = explode('-',$date);
		$day = $newDate[2];
        $year = $newDate[0];
        if($newDate[1] == '01'){
            $month = 'Januari';
        }elseif($newDate[1] == '02'){
            $month = 'Februari';
        }elseif($newDate[1] == '03'){
            $month = 'Maret';
        }elseif($newDate[1] == '04'){
            $month = 'April';
        }elseif($newDate[1] == '05'){
            $month = 'Mei';
        }elseif($newDate[1] == '06'){
            $month = 'Juni';
        }elseif($newDate[1] == '07'){
            $month = 'Juli';
        }elseif($newDate[1] == '08'){
            $month = 'Agustus';
        }elseif($newDate[1] == '09'){
            $month = 'September';
        }elseif($newDate[1] == '10'){
            $month = 'Oktober';
        }elseif($newDate[1] == '11'){
            $month = 'November';
        }elseif($newDate[1] == '12'){
            $month = 'Desember';
        }

        $arrDate = array(
        	"day" => $day,
        	"month" => $month,
        	"year" => $year
        );

        $fixDate = json_decode(json_encode($arrDate),false);

        return $fixDate;
	}

	// Dormitory data for rooms --> CLAUSE: [kamar,dorm]
	public function DataRoom($idKamar){
		$asrama = DB::select("
			SELECT kamar.id_kamar, kamar.nama AS kamar, kapasitas, status, keterangan, gender, which_user, is_difable, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar 
			LEFT JOIN (
				SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama AS gedung FROM gedung 
				LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama
			) AS dorm ON dorm.id_gedung = kamar.id_gedung WHERE kamar.id_kamar = ?",[$idKamar]);
		foreach ($asrama as $u) {
			$getData = $u;
		}
		return $getData;
	}

	// User data basic: users, data_penghuni, nim_penghuni
	public function DataUser($userID){
		$user = DB::select("
			SELECT id, id_penghuni, id_nim, name, email, stud.nim, stud.registrasi, stud.id_prodi, stud.nama_prodi, stud.id_fakultas, stud.fakultas, stud.strata, nomor_identitas, jenis_identitas, tempat_lahir, tanggal_lahir, gol_darah, jenis_kelamin, alamat, kota, propinsi, kodepos, negara, agama, pekerjaan, warga_negara, telepon, instansi, nama_ortu_wali, telepon_ortu_wali, alamat_ortu_wali, pekerjaan_ortu_wali, kontak_darurat, status_daftar FROM users 
			LEFT JOIN user_penghuni ON user_penghuni.id_user = users.id 
			LEFT JOIN (
				SELECT id_user, nim, id_nim, registrasi, prod.id_prodi, prod.nama_prodi, prod.id_fakultas, prod.fakultas, strata FROM user_nim 
				LEFT JOIN (
					SELECT prodi.id_prodi, fakultas.id_fakultas, nama_prodi, strata, fakultas.nama as fakultas FROM prodi 
					LEFT JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas
				) AS prod ON prod.id_prodi = user_nim.id_prodi
			) AS stud ON stud.id_user = users.id WHERE id = ?",[$userID]);
		foreach ($user as $u) {
			$getData = $u;
		}
		return $getData;
	}

	// Tagihan total penghuni: overall tagihan, overall bayar
	public function UserBill($userID){
		$bill = DB::select("
			SELECT id_user, SUM(jumlah_tagihan) AS jumlah_tagihan, SUM(total) AS total FROM (
				SELECT id_daftar, id_user, checki.daftar_asrama_type, checki.id_tagihan, checki.jumlah_tagihan, checki.total FROM daftar_asrama_reguler 
                LEFT JOIN (
                    SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, bill.total FROM tagihan 
                    LEFT JOIN (
                        SELECT id_tagihan, SUM(jumlah_bayar) AS total FROM pembayaran WHERE is_accepted = 1 GROUP BY id_tagihan
                    ) AS bill ON bill.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'daftar_asrama_reguler'
                ) AS checki ON checki.daftar_asrama_id = daftar_asrama_reguler.id_daftar
    			UNION
    			SELECT id_daftar, id_user, checki.daftar_asrama_type, checki.id_tagihan, checki.jumlah_tagihan, checki.total FROM daftar_asrama_non_reguler 
                LEFT JOIN (
                    SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, bill.total FROM tagihan 
                    LEFT JOIN (
                        SELECT id_tagihan, SUM(jumlah_bayar) AS total FROM pembayaran WHERE is_accepted = 1 GROUP BY id_tagihan
                    ) AS bill ON bill.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'daftar_asrama_non_reguler'
                ) AS checki ON checki.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar
            ) AS payment GROUP BY id_user");
		return $bill;
	}

	// User data reguler: daftar_asrama_reguler, periode, tagihan, total bayar, checkout
	public function DataReguler($userID){
		$reg = DB::select("
			SELECT id_daftar, id_kamar, id_user, periodes.id_periode, periodes.nama_periode, preference, asrama, lokasi_asrama, verification, status_beasiswa, kampus_mahasiswa, has_penyakit, ket_penyakit, is_difable, ket_difable, is_international, daftar_asrama_reguler.tanggal_masuk, daftar_asrama_reguler.created_at, daftar_asrama_reguler.updated_at, checki.id_tagihan, checki.jumlah_tagihan, checki.total, id_checkout, jenis_checkout, alasan_checkout,catatan_checkout, checkout.tanggal_masuk AS date_in, checkout.tanggal_keluar AS date_out FROM daftar_asrama_reguler 
            LEFT JOIN (
                SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, bill.total FROM tagihan 
                LEFT JOIN (
                    SELECT id_tagihan, SUM(jumlah_bayar) AS total FROM pembayaran WHERE is_accepted = 1 GROUP BY id_tagihan
                ) AS bill ON bill.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'daftar_asrama_reguler'
            ) AS checki ON checki.daftar_asrama_id = daftar_asrama_reguler.id_daftar
            LEFT JOIN periodes ON periodes.id_periode = daftar_asrama_reguler.id_periode
            LEFT JOIN checkout ON checkout.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND checkout.daftar_asrama_type = 'daftar_asrama_reguler'
            LEFT JOIN kamar_penghuni ON kamar_penghuni.daftar_asrama_id = daftar_asrama_reguler.id_daftar AND kamar_penghuni.daftar_asrama_type = 'daftar_asrama_reguler' WHERE daftar_asrama_reguler.id_user = ?", [$userID]);
		return $reg;
	}

	// User data non reguler: daftar_asrama_non_reguler, tagihan, total bayar, checkout
	public function DataNonReguler($userID){
		$nonReg = DB::select("
			SELECT id_daftar, id_kamar, id_user, tujuan_tinggal, preference, lokasi_asrama, verification, is_difable, ket_difable, daftar_asrama_non_reguler.tanggal_masuk, tempo, lama_tinggal, jenis_penghuni, daftar_asrama_non_reguler.created_at, daftar_asrama_non_reguler.updated_at, checki.id_tagihan, checki.jumlah_tagihan, checki.total, id_checkout, jenis_checkout, alasan_checkout,catatan_checkout, checkout.tanggal_masuk AS date_in, checkout.tanggal_keluar AS date_out FROM daftar_asrama_non_reguler 
            LEFT JOIN (
                SELECT tagihan.id_tagihan, daftar_asrama_id, daftar_asrama_type, jumlah_tagihan, bill.total FROM tagihan 
                LEFT JOIN (
                    SELECT id_tagihan, SUM(jumlah_bayar) AS total FROM pembayaran WHERE is_accepted = 1 GROUP BY id_tagihan
                ) AS bill ON bill.id_tagihan = tagihan.id_tagihan WHERE daftar_asrama_type = 'daftar_asrama_non_reguler'
            ) AS checki ON checki.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar
            LEFT JOIN checkout ON checkout.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND checkout.daftar_asrama_type = 'daftar_asrama_non_reguler' 
            LEFT JOIN kamar_penghuni ON kamar_penghuni.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar AND kamar_penghuni.daftar_asrama_type = 'daftar_asrama_non_reguler' WHERE daftar_asrama_non_reguler.id_user = ?",[$userID]);
		return $nonReg;
	}

	// User data pembayaran reguler
	public function RegPay($id_daftar){
		$RegPay = DB::select("
			SELECT bill.id_daftar, bill.id_tagihan, bill.jumlah_tagihan, pembayaran.id_pembayaran,  tanggal_bayar, nomor_transaksi, jumlah_bayar, jenis_pembayaran, keterangan, catatan, nama_pengirim, bank_asal, is_accepted, file FROM pembayaran 
			LEFT JOIN (
				SELECT id_daftar, id_tagihan, jumlah_tagihan FROM daftar_asrama_reguler 
				LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'daftar_asrama_reguler'
			) AS bill ON bill.id_tagihan = pembayaran.id_tagihan WHERE bill.id_daftar = ?",[$id_daftar]);
		return $RegPay;
	}

	// User data pembayaran non reguler
	public function NonRegPay($id_daftar){
		$NonRegPay = DB::select("
			SELECT bill.id_daftar, bill.id_tagihan, bill.jumlah_tagihan, pembayaran.id_pembayaran,  tanggal_bayar, nomor_transaksi, jumlah_bayar, jenis_pembayaran, keterangan, catatan, nama_pengirim, bank_asal, is_accepted, file FROM pembayaran
			LEFT JOIN (
				SELECT id_daftar, id_tagihan, jumlah_tagihan FROM daftar_asrama_non_reguler 
				LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_non_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'daftar_asrama_non_reguler'
			) AS bill ON bill.id_tagihan = pembayaran.id_tagihan WHERE bill.id_daftar = ?",[$id_daftar]);
		return $NonRegPay;
	}

	// User data penangguhan
	public function Penangguhan($id_daftar){
		$penangguhan = DB::select("
			SELECT bill.id_daftar, bill.id_tagihan, bill.jumlah_tagihan, penangguhan.id_penangguhan,  deadline_pembayaran, jumlah_tangguhan, alasan_penangguhan FROM penangguhan
			LEFT JOIN (
				SELECT id_daftar, id_tagihan, jumlah_tagihan FROM daftar_asrama_reguler 
				LEFT JOIN tagihan ON tagihan.daftar_asrama_id = daftar_asrama_reguler.id_daftar WHERE tagihan.daftar_asrama_type = 'daftar_asrama_reguler'
			) AS bill ON bill.id_tagihan = penangguhan.id_tagihan WHERE bill.id_daftar = ?",[$id_daftar]);
		return $penangguhan;
	}
}
?>