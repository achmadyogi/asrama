@extends('layouts.app')

@section('styling')

<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: center;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
  background-color: #4CAF50;
  color: white;
  text-align: center;
}
</style>

@endsection

@section('content')
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h2>Daftar Tarif Asrama</h2>
    </div>
    <div class="panel-body">
      <div class="col-md-12" style="margin-bottom: 25px">
        <h4>Tarif Reguler (sewa per-bulan)</h4>
        <hr>
        <div class="col-md-10 col-md-offset-1">
          <table style="width:100%;">
              <tr>
                  <th>Asrama</th>
                  <th>Mahasiswa TPB Bidik Misi</th>
                  <th>Mahasiswa TPB Non-Bidik Misi</th>
                  <th>Mahasiswa Pasca Sarjana</th>
                  <th>Mahasiswa Internasional ITB</th>
                  <th>Tarif Non Civitas Akademik ITB</th>
              </tr>
              @foreach($tarifReguler as $item)
                  <tr>
                      <td>{{$item->asrama}}</td>
                      <!-- tarif bidik misi TPB -->
                      @if($item->nilai_tarif_TPB_BM == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_TPB_BM) }},-</td>
                      @endif
                      <!-- tarif non bidik misi TPB -->
                      @if($item->nilai_tarif_TPB_NBM == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_TPB_NBM) }},-</td>
                      @endif
                      <!-- tarif pasca sarjana -->
                      @if($item->nilai_tarif_PS == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_PS) }},-</td>
                      @endif
                      <!-- tarif internasional -->
                      @if($item->nilai_tarif_IT == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_IT) }},-</td>
                      @endif
                      <!-- tarif non civitas ITB -->
                      @if($item->nilai_tarif_NON == null)
                        <td>Sesuai kontrak khusus dengan wakil rektor</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_NON) }},-</td>
                      @endif
                  </tr>
              @endforeach
         </table>
        </div>
      </div>

      <div class="col-md-12">
        <h4> Tarif Harian (sewa per-hari) </h4>
        <hr>
        <div class="col-md-10 col-md-offset-1">
          <table style="width:100%">
              <tr>
                  <th>Asrama</th>
                  <th>Mahasiswa TPB Bidik Misi</th>
                  <th>Mahasiswa TPB Non-Bidik Misi</th>
                  <th>Mahasiswa Pasca Sarjana</th>
                  <th>Mahasiswa Internasional ITB</th>
                  <th>Tarif Non Civitas Akademik ITB</th>
              </tr>
              @foreach($tarifHarian as $item)
                  <tr>
                      <td>{{$item->asrama}}</td>
                      <!-- tarif bidik misi TPB -->
                      @if($item->nilai_tarif_TPB_BM == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_TPB_BM) }},-</td>
                      @endif
                      <!-- tarif non bidik misi TPB -->
                      @if($item->nilai_tarif_TPB_NBM == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_TPB_NBM) }},-</td>
                      @endif
                      <!-- tarif pasca sarjana -->
                      @if($item->nilai_tarif_PS == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_PS) }},-</td>
                      @endif
                      <!-- tarif internasional -->
                      @if($item->nilai_tarif_IT == null)
                        <td>Tidak dialokasikan</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_IT) }},-</td>
                      @endif
                      <!-- tarif non civitas ITB -->
                      @if($item->nilai_tarif_NON == null)
                        <td>Sesuai kontrak khusus dengan wakil rektor</td>
                      @else
                        <td>Rp. {{ number_format($item->nilai_tarif_NON) }},-</td>
                      @endif
                  </tr>
              @endforeach
         </table>
        </div>
    </div>
  </div>
</div>
@endsection
