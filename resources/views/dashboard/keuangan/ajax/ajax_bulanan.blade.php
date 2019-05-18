<?php
use Illuminate\Support\Facades\DB;
use App\Pembayaran;

function getCurrency($count){
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

$year = $_POST['year'];
// Mengitung pemasukan tiap bulan untuk chart
$bulanan = DB::select("SELECT * FROM pembayaran WHERE is_accepted = 1 and tanggal_bayar like ?",[$year.'-%']);
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
        $dormval = DB::select("SELECT pembayaran.tanggal_bayar, pembayaran.nomor_transaksi, pembayaran.jumlah_bayar, pembayaran.jenis_pembayaran, pembayaran.is_accepted, pembayaran.file, pembayaran.id_tagihan, bill.daftar_asrama_id, bill.daftar_asrama_type, bill.id_kamar, bill.kamar, bill.id_gedung, bill.gedung, bill.id_asrama, bill.asrama from pembayaran left join (SELECT tagihan.id_tagihan, tagihan.daftar_asrama_id, tagihan.daftar_asrama_type, occup.id_kamar, occup.kamar, occup.id_gedung, occup.gedung, occup.id_asrama, occup.asrama from tagihan left join (SELECT kamar_penghuni.daftar_asrama_id, kamar_penghuni.daftar_asrama_type, kamar_penghuni.id_kamar, room.kamar, room.id_gedung, room.gedung, room.id_asrama, room.asrama from kamar_penghuni left join (SELECT id_kamar, kamar.nama as kamar, dorm.id_gedung, dorm.gedung, dorm.id_asrama, dorm.asrama FROM kamar LEFT JOIN (SELECT asrama.id_asrama, asrama.nama as asrama, id_gedung, gedung.nama as gedung FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama) as dorm ON kamar.id_gedung = dorm.id_gedung) AS room ON room.id_kamar = kamar_penghuni.id_kamar) occup ON occup.daftar_asrama_id = tagihan.daftar_asrama_id AND occup.daftar_asrama_type = tagihan.daftar_asrama_type) AS bill on bill.id_tagihan = pembayaran.id_tagihan where pembayaran.is_accepted = 1 and pembayaran.tanggal_bayar like ?",[$year.'-%']);
        foreach ($dormval as $val) {
            // Untuk pie chart
            if($val->id_asrama == 1){
                $INT = $INT + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<10){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $INT_month[$c] = $INT_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 2){
                $JTN = $JTN + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<10){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $JTN_month[$c] = $JTN_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 3){
                $KN = $KN + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<10){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $KN_month[$c] = $KN_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 4){
                $KP = $KP + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<10){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $KP_month[$c] = $KP_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }elseif($val->id_asrama == 5 || $val->id_asrama == 6){
                $SA = $SA + $val->jumlah_bayar;
                for($c=0; $c<12; $c++){
                    if($c<10){
                        $ce = $c+1;
                        if(strpos($val->tanggal_bayar,'-0'.$ce.'-') !== false){
                            $SA_month[$c] = $SA_month[$c] + $val->jumlah_bayar;
                        }
                    }
                }
            }
        }
        // Conversi ke bentuk rupiah dan penjumlahan
        for($i=0;$i<12;$i++){
            $total_month[$i] = $KP_month[$i] + $KN_month[$i] + $SA_month[$i] + $JTN_month[$i] + $INT_month[$i];
            $KP_month[$i] = getCurrency($KP_month[$i]);
            $KN_month[$i] = getCurrency($KN_month[$i]); 
            $SA_month[$i] = getCurrency($SA_month[$i]); 
            $JTN_month[$i] = getCurrency($JTN_month[$i]); 
            $INT_month[$i] = getCurrency($INT_month[$i]);
            $total_month[$i] = getCurrency($total_month[$i]);  
        }
        $TOTAL = getCurrency($INT + $KP + $KN + $SA + $JTN);
        $TOTAL_ASRAMA = [getCurrency($INT),getCurrency($KN),getCurrency($KP),getCurrency($SA),getCurrency($JTN)];
?>
<h3><b>Pemasukan Asrama tiap Asrama tiap Bulan Tahun {{$year}}</b></h3>
					<div class="table" style="font-size: 14px;">
						<table>
							<tr>
								<th rowspan="2" style="text-align: center;">Bulan</th>
								<th colspan="5" style="text-align: center;">Jumlah Pendapatan</th>
								<th rowspan="2" style="text-align: center;">TOTAL</th>
							</tr>
							<tr>
								<th>International</th>
								<th>Kanayakan</th>
								<th>Kidang Pananjung</th>
								<th>Sangkuriang</th>
								<th>Jatinangor</th>
							</tr>
							@for($i=0;$i < 12;$i++)
								<tr>
									<td>{{$nama_bulan[$i]}}</td>
									<td>{{$INT_month[$i]}}</td>
									<td>{{$KN_month[$i]}}</td>
									<td>{{$KP_month[$i]}}</td>
									<td>{{$SA_month[$i]}}</td>
									<td>{{$JTN_month[$i]}}</td>
									<td><b>{{$total_month[$i]}}</b></td>
								</tr>
							@endfor
							<tr>
								<td><b>TOTAL</b></td>
								<td><b>{{$TOTAL_ASRAMA[0]}}</b></td>
								<td><b>{{$TOTAL_ASRAMA[1]}}</b></td>
								<td><b>{{$TOTAL_ASRAMA[2]}}</b></td>
								<td><b>{{$TOTAL_ASRAMA[3]}}</b></td>
								<td><b>{{$TOTAL_ASRAMA[4]}}</b></td>
								<td><b>{{$TOTAL}}</b></td>
							</tr>
						</table>
					</div><br>	
<div id="myChart" style="width: 100%"></div>
	<script type="text/javascript">
		var trace1 = {
		  x: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 
		  y: [<?php echo $bulanH2HJan; ?>,
				<?php echo $bulanH2HFeb; ?>,
				<?php echo $bulanH2HMar; ?>,
				<?php echo $bulanH2HApr; ?>,
				<?php echo $bulanH2HMei; ?>,
				<?php echo $bulanH2HJun; ?>,
				<?php echo $bulanH2HJul; ?>,
				<?php echo $bulanH2HAug; ?>,
				<?php echo $bulanH2HSep; ?>,
				<?php echo $bulanH2HOkt; ?>,
				<?php echo $bulanH2HNov; ?>,
				<?php echo $bulanH2HDes; ?>,],
		  type: 'bar',
		  name: 'Host to host',
		  marker: {
		    color: 'rgb(49,130,189)',
		    opacity: 0.7
		  }
		};

		var trace2 = {
		  x: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		  y: [<?php echo $bulanPenampunganJan; ?>,
					<?php echo $bulanPenampunganFeb; ?>,
					<?php echo $bulanPenampunganMar; ?>,
					<?php echo $bulanPenampunganApr; ?>,
					<?php echo $bulanPenampunganMei; ?>,
					<?php echo $bulanPenampunganJun; ?>,
					<?php echo $bulanPenampunganJul; ?>,
					<?php echo $bulanPenampunganAug; ?>,
					<?php echo $bulanPenampunganSep; ?>,
					<?php echo $bulanPenampunganOkt; ?>,
					<?php echo $bulanPenampunganNov; ?>,
					<?php echo $bulanPenampunganDes; ?>,],
		  type: 'bar',
		  name: 'Rekening Penampungan',
		  marker: {
		    color: 'rgb(204,204,204)',
		    opacity: 0.5
		  }
		};

		var data = [trace1, trace2];

		var layout = {
		  title: '<b>Pemasukan Tahun <?php echo $year; ?> </b>',
		  xaxis: {
		    tickangle: -45
		  },
		  barmode: 'group'
		};

		Plotly.newPlot('myChart', data, layout);
	</script>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#year').change(function(){
			var year = $(this).val();
			console.log(year);
		  	$.post('{{ route("ajax_chart") }}',{
		  		'year': year,
		  		'_token':$('input[name=_token]').val()
		  	}, function(data, status){
			console.log('year');
				$('#ajax_chart').html(data);
			});
		});
	})
</script>
<div id="myPie" style="width: 100%"></div>
					<script type="text/javascript">
						var data2 = [{
						  values: [<?php echo $KP; ?>, <?php echo $KN; ?>, <?php echo $SA; ?>, <?php echo $JTN; ?>, <?php echo $INT; ?>],
						  labels: ['Asrama Kidang Pananjung', 'Asrama Sangkuriang', 'Asrama Kanayakan', 'Asrama Jatinangor', 'Asrama Internasional'],
						  hole: .4,
						  type: 'pie'
						}];
						var layout2 = {
							title: '<b>Pemasukan Berdasarkan Asrama Tahun <?php echo $year; ?></b>',
						}
						Plotly.newPlot('myPie', data2, layout2);
					</script>

