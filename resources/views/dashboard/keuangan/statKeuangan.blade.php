@extends('layouts.default')

@section('title','Statistik Keuangan')
@section('menu_dash','active')

@section('main_menu')
	@parent

@endsection

@section('header_title','Keuangan | Statistik Keuangan')
@section('content')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-9">
			<!-- KONTEN UTAMA-->
			<div id="content">
				<!-- ALERT -->
				@if (session()->has('status1'))
					<div class="alert_fail">
						{{session()->get('status1')}}
					</div> 
				@elseif (session()->has('status2'))
					<div class="alert_success">
						{{session()->get('status2')}}
					</div> 
				@endif
				<h3><b>Pemasukan</b></h3>
				<p>Berikut ini adalah data pemasukan asrama saat ini.</p>
				<div class="row">
					<div class="col-md-6">
						Total Pemasukan Host to Host<br><b>{{$totalH2H}}</b><br>
						Total Pemasukan Rekening Penampungan<br><b>{{$totalPenampungan}}</b><br>
						Total Pemasukan Keseluruhan<br><b>{{$all}}</b><br>
					</div>
					<div class="col-md-6">
						Total Penangguhan Pembayaran<br><b>{{$totalPenangguhan}}</b><br>
						Total Pemasukan Seharusnya<br><b>{{$totalSeharusnya}}</b><br>
					</div>
				</div><hr>
				<h3><b>Rincian Pemasukan Tahunan</b></h3>
				{{ csrf_field() }}
				<select id="year">
					<option value="2017">Tahun 2017</option>
					<option value="2018" selected>Tahun 2018</option>
					<option value="2019">Tahun 2019</option>
				</select><br><br>
				<div id="ajax_chart">
					<h3><b>Pemasukan Asrama tiap Asrama tiap Bulan Tahun 2018</b></h3>
					<div class="table" style="font-size: 14px;">
						<table>
							<tr>
								<th rowspan="2" style="text-align: center; vertical-align: middle;">Bulan</th>
								<th colspan="5" style="text-align: center;">Jumlah Pendapatan</th>
								<th rowspan="2" style="text-align: center; vertical-align: middle;">TOTAL</th>
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
						  title: '<b>Pemasukan Tahun 2018</b>',
						  xaxis: {
						    tickangle: -45
						  },
						  barmode: 'group'
						};

						Plotly.newPlot('myChart', data, layout);
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
							title: '<b>Pemasukan Berdasarkan Asrama Tahun 2018</b>',
						}
						Plotly.newPlot('myPie', data2, layout2);
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
			</div>
		</div>
		<div class="col-md-3">
			<!-- MENU DASHBOARD -->
			@include('dashboard.menuDashboard')
		</div>
	</div>
	<br><br><br>
</div>
@endsection
