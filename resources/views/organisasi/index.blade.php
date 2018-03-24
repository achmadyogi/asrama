@extends('layouts.app')

@section('styling')
<style>
#head {
    font-family: "Raleway",Helvetica,Arial,sans-serif;
    font-weight: 500;
    color: #333;
}

#cont {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 1.42857143;
    color: #333;
}
</style>
@endsection

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2 id="head">Struktur Organisasi UPT Asrama ITB</h2>
		</div>
		<div class="panel-body">
			<p id="cont">
            	Struktur organisasi adalah susunan komponen-komponen (unit-unit kerja) dalam organisasi. Struktur organisasi menunjukkan adanya pembagian kerja dan menunjukkan bagaimana fungsi-fungsi atau kegiatan-kegiatan yang berbeda-beda tersebut diintegrasikan (koordinasi). Selain daripada itu struktur organisasi juga menunjukkan spesialisasi-spesialisasi pekerjaan, saluran perintah dan penyampaian laporan. 
            </p>
            <p id="cont">
                Struktur Organisasi dapat didefinisikan sebagai mekanisme-mekanisme formal organisasi diolah. Struktur organisasi terdiri atas unsur spesialisasi kerja, standarisasi, koordinasi, sentralisasi atau desentralisasi dalam pembuatan keputusan dan ukuran satuan kerja. 
            </p>
            
            <div class="row">
	            <div class="col-md-6">
	            	<div class="row">
		            	<div class="col-md-3"><img src="img/agung.jpg" style="width: 80%; margin : 4px;" /></div>
		            	<div class="col-md-9">  		
							<h4 id="head">Kepala UPT Asrama</h4>
							<div id="cont">
							<p>Nama  : Dr. Ir. Agung Wiyono Hadi Soeharno, MS, M.Eng.</p>
							<p>Email : ag.wiyono@yahoo.com</p>
							</div>
		            	</div>
		            </div>
		            <div class="row">
		            	<div class="col-md-3"><img src="img/dadan.jpg" style="width: 80%; margin : 4px;" /></div>
		            	<div class="col-md-9">
							<h4 id="head">Kepala UPT Asrama Bidang Pembinaan</h4>
							<div id="cont">
							<p>Nama  : Dr. Eng. Raden Dadan Ramdan, ST.</p>
							<p>Email :	dadan@material.itb.ac.id</p>
							</div>
		            	</div>
		            </div>
	            </div>
	            <div class="col-md-6">
	            	<img src="img/strukturorganisasi1.jpg" style="width: 100%;" />
	            </div>
	        </div>
		</div>
	</div>
</div>
@endsection