<?php

namespace App\Http\Controllers\keuangan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Illuminate\Support\Facades\DB;
use Session;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use App\Pembayaran;
use App\Tagihan;
use ITBdorm;

class statistikKeuanganController extends Controller
{
    public function index(){
    	// Menghitung total pemasukan
    	$pemasukan = Pembayaran::where(['is_accepted' => 1])->get();
    	$totalH2H = 0;
    	$totalPenampungan = 0;
        $totalPenangguhan = 0;
        // Mengitung pemasukan total
    	foreach ($pemasukan as $total) {
    		if($total->jenis_pembayaran == 0){
    			$totalH2H = $totalH2H + $total->jumlah_bayar;
    		}elseif($total->jenis_pembayaran == 1){
    			$totalPenampungan = $totalPenampungan + $total->jumlah_bayar;
    		}
    	}

        // Menghitung total pemasukan seharusnya
        $totalSeharusnyaReg = DB::select("SELECT sum(jumlah_tagihan) AS total FROM (SELECT id_tagihan, jumlah_tagihan, daftar_asrama_reguler.id_daftar, daftar_asrama_reguler.verification FROM `tagihan` LEFT JOIN daftar_asrama_reguler ON daftar_asrama_reguler.id_daftar = tagihan.daftar_asrama_id AND tagihan.daftar_asrama_type = 'daftar_asrama_reguler' WHERE verification in (5,6)) AS reg");
        foreach ($totalSeharusnyaReg as $r) {
            $totalReg = $r->total;
        }
        $totalSeharusnyaNon = DB::select("SELECT sum(jumlah_tagihan) AS total FROM (SELECT id_tagihan, jumlah_tagihan, daftar_asrama_non_reguler.id_daftar, daftar_asrama_non_reguler.verification FROM `tagihan` LEFT JOIN daftar_asrama_non_reguler ON daftar_asrama_non_reguler.id_daftar = tagihan.daftar_asrama_id AND tagihan.daftar_asrama_type = 'daftar_asrama_non_reguler' WHERE verification in (5,6)) AS non");
        foreach ($totalSeharusnyaNon as $n) {
            $totalNon = $n->total;
        }
        $totalPenangguhan = ITBdorm::Currency($totalReg + $totalNon - $totalPenampungan - $totalH2H);
        $totalSeharusnya = ITBdorm::Currency($totalReg + $totalNon);
        $all = ITBdorm::Currency($totalPenampungan + $totalH2H);
        $totalH2H = ITBdorm::Currency($totalH2H);
        $totalPenampungan = ITBdorm::Currency($totalPenampungan);

        // Mengitung pemasukan tiap bulan untuk chart
        $bulanan = DB::select("SELECT * FROM pembayaran WHERE is_accepted = 1 and tanggal_bayar like '%2018-%'");
        $bulanH2HJan = 0;
        $bulanPenampunganJan = 0;
        $bulanH2HFeb = 0;
        $bulanPenampunganFeb = 0;
        $bulanH2HMar = 0;
        $bulanPenampunganMar = 0;
        $bulanH2HApr = 0;
        $bulanPenampunganApr = 0;
        $bulanH2HMei = 0;
        $bulanPenampunganMei = 0;
        $bulanH2HJun = 0;
        $bulanPenampunganJun = 0;
        $bulanH2HJul = 0;
        $bulanPenampunganJul = 0;
        $bulanH2HAug = 0;
        $bulanPenampunganAug = 0;
        $bulanH2HSep = 0;
        $bulanPenampunganSep = 0;
        $bulanH2HOkt = 0;
        $bulanPenampunganOkt = 0;
        $bulanH2HNov = 0;
        $bulanPenampunganNov = 0;
        $bulanH2HDes = 0;
        $bulanPenampunganDes = 0;
        foreach ($bulanan as $bulanan) {
            if($bulanan->jenis_pembayaran == 0){
                if(strpos($bulanan->tanggal_bayar, '-01-') !== false){
                    $bulanH2HJan = $bulanH2HJan + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-02-') !== false){
                    $bulanH2HFeb = $bulanH2HFeb + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-03-') !== false){
                    $bulanH2HMar = $bulanH2HMar + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-04-') !== false){
                    $bulanH2HApr = $bulanH2HApr + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-05-') !== false){
                    $bulanH2HMei = $bulanH2HMei + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-06-') !== false){
                    $bulanH2HJun = $bulanH2HJun + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-07-') !== false){
                    $bulanH2HJul = $bulanH2HJul + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-08-') !== false){
                    $bulanH2HAug = $bulanH2HAug + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-09-') !== false){
                    $bulanH2HSep = $bulanH2HSep + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-10-') !== false){
                    $bulanH2HOkt = $bulanH2HOkt + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-11-') !== false){
                    $bulanH2HNov = $bulanH2HNov + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-12-') !== false){
                    $bulanH2HDes = $bulanH2HDes + $bulanan->jumlah_bayar;
                }
            }elseif($bulanan->jenis_pembayaran == 1){
                if(strpos($bulanan->tanggal_bayar, '-01-') !== false){
                    $bulanPenampunganJan = $bulanPenampunganJan + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-02-') !== false){
                    $bulanPenampunganFeb = $bulanPenampunganFeb + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-03-') !== false){
                    $bulanPenampunganMar = $bulanPenampunganMar + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar,'-04-' ) !== false){
                    $bulanPenampunganApr = $bulanPenampunganApr + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-05-') !== false){
                    $bulanPenampunganMei = $bulanPenampunganMei + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-06-') !== false){
                    $bulanPenampunganJun = $bulanPenampunganJun + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-07-') !== false){
                    $bulanPenampunganJul = $bulanPenampunganJul + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-08-') !== false){
                    $bulanPenampunganAug = $bulanPenampunganAug + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-09-') !== false){
                    $bulanPenampunganSep = $bulanPenampunganSep + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-10-') !== false){
                    $bulanPenampunganOkt = $bulanPenampunganOkt + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-11-') !== false){
                    $bulanPenampunganNov = $bulanPenampunganNov + $bulanan->jumlah_bayar;
                }elseif(strpos($bulanan->tanggal_bayar, '-12-') !== false){
                    $bulanPenampunganDes = $bulanPenampunganDes + $bulanan->jumlah_bayar;
                }
            }
        }

        // Menghitung pemasukan tiap asrama
        $KP = 0;
        $KN = 0;
        $SA = 0;
        $JTN = 0;
        $INT = 0;

        // Menghitung pemasukan asrama tiap bulan tiap asrama
        $KP_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $KN_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $SA_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $JTN_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $INT_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $total_month = [0,0,0,0,0,0,0,0,0,0,0,0];
        $nama_bulan = ['Januari','Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $dormval = DB::select("SELECT pembayaran.tanggal_bayar, pembayaran.nomor_transaksi, pembayaran.jumlah_bayar, pembayaran.jenis_pembayaran, pembayaran.is_accepted, pembayaran.file, pembayaran.id_tagihan, bill.daftar_asrama_id, bill.daftar_asrama_type, bill.id_kamar, bill.kamar, bill.id_gedung, bill.gedung, bill.id_asrama, bill.asrama from pembayaran left join (SELECT tagihan.id_tagihan, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, occup.id_kamar, occup.kamar, occup.id_gedung, occup.gedung, occup.id_asrama, occup.asrama from tagihan left join (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, kamar_penghuni.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar LEFT JOIN (SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama as gedung FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama) as dorm ON kamar.id_gedung = dorm.id_gedung) AS room ON room.id_kamar = kamar_penghuni.id_kamar) occup ON occup.daftar_asrama_id = tagihan.daftar_asrama_id AND occup.daftar_asrama_type = tagihan.daftar_asrama_type) AS bill on bill.id_tagihan = pembayaran.id_tagihan where pembayaran.is_accepted = 1 and pembayaran.tanggal_bayar like '2018-%'");
        foreach ($dormval as $val) {
            // Untuk pie chart
            if($val->id_asrama == 1){
                $INT = $INT + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<9){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $INT_month[$c] = $INT_month[$c] + $val->jumlah_bayar;
                        }
                    }else{
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-'.$ce.'-') !== false){
                            $INT_month[$c] = $INT_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 2){
                $JTN = $JTN + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<9){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $JTN_month[$c] = $JTN_month[$c] + $val->jumlah_bayar;
                        }
                    }else{
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-'.$ce.'-') !== false){
                            $JTN_month[$c] = $JTN_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 3){
                $KN = $KN + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<9){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $KN_month[$c] = $KN_month[$c] + $val->jumlah_bayar;
                        }
                    }else{
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-'.$ce.'-') !== false){
                            $KN_month[$c] = $KN_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 4){
                $KP = $KP + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<9){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $KP_month[$c] = $KP_month[$c] + $val->jumlah_bayar;
                        }
                    }else{
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-'.$ce.'-') !== false){
                            $KP_month[$c] = $KP_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 5 || $val->id_asrama == 6){
                $SA = $SA + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<9){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $SA_month[$c] = $SA_month[$c] + $val->jumlah_bayar;
                        }
                    }else{
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-'.$ce.'-') !== false){
                            $SA_month[$c] = $SA_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }
        }
        // Conversi ke bentuk rupiah dan penjumlahan
        for($i=0;$i<12;$i++){
            $total_month[$i] = $KP_month[$i] + $KN_month[$i] + $SA_month[$i] + $JTN_month[$i] + $INT_month[$i];
            $KP_month[$i] = ITBdorm::Currency($KP_month[$i]);
            $KN_month[$i] = ITBdorm::Currency($KN_month[$i]); 
            $SA_month[$i] = ITBdorm::Currency($JTN_month[$i]); 
            $INT_month[$i] = ITBdorm::Currency($INT_month[$i]);
            $total_month[$i] = ITBdorm::Currency($total_month[$i]);
        }
        $TOTAL = ITBdorm::Currency($INT + $KP + $KN + $SA + $JTN);
        $TOTAL_ASRAMA = [ITBdorm::Currency($INT),ITBdorm::Currency($KN),ITBdorm::Currency($KP),ITBdorm::Currency($SA),ITBdorm::Currency($JTN)];

    	Session::flash('menu','stat_keuangan');
    	return view('dashboard.keuangan.statKeuangan', ['totalH2H' => $totalH2H, 
                            'totalPenampungan' => $totalPenampungan,
                            'totalPenangguhan' => $totalPenangguhan,
                            'totalSeharusnya' => $totalSeharusnya, 
                            'all' => $all,
                            'bulanH2HJan' => $bulanH2HJan,
                            'bulanPenampunganJan' => $bulanPenampunganJan,
                            'bulanH2HFeb' => $bulanH2HFeb,
                            'bulanPenampunganFeb' => $bulanPenampunganFeb,
                            'bulanH2HMar' => $bulanH2HMar,
                            'bulanPenampunganMar' => $bulanPenampunganMar,
                            'bulanH2HApr' => $bulanH2HApr,
                            'bulanPenampunganApr' => $bulanPenampunganApr,
                            'bulanH2HMei' => $bulanH2HMei,
                            'bulanPenampunganMei' => $bulanPenampunganMei,
                            'bulanH2HJun' => $bulanH2HJun,
                            'bulanPenampunganJun' => $bulanPenampunganJun,
                            'bulanH2HJul' => $bulanH2HJul,
                            'bulanPenampunganJul' => $bulanPenampunganJul,
                            'bulanH2HAug' => $bulanH2HAug,
                            'bulanPenampunganAug' => $bulanPenampunganAug,
                            'bulanH2HSep' => $bulanH2HSep,
                            'bulanPenampunganSep' => $bulanPenampunganSep,
                            'bulanH2HOkt' => $bulanH2HOkt,
                            'bulanPenampunganOkt' => $bulanPenampunganOkt,
                            'bulanH2HNov' => $bulanH2HNov,
                            'bulanPenampunganNov' => $bulanPenampunganNov,
                            'bulanH2HDes' => $bulanH2HDes,
                            'bulanPenampunganDes' => $bulanPenampunganDes,
                            'KP' => $KP,
                            'SA' => $SA,
                            'KN' => $KN,
                            'JTN' => $JTN,
                            'INT' => $INT,
                            'KP_month' => $KP_month,
                            'SA_month' => $SA_month,
                            'KN_month' => $KN_month,
                            'JTN_month' => $JTN_month,
                            'INT_month' => $INT_month,
                            'nama_bulan' => $nama_bulan,
                            'total_month' => $total_month,
                            'TOTAL' => $TOTAL,
                            'TOTAL_ASRAMA' => $TOTAL_ASRAMA
                        ]);
    }
}
