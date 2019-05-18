<!DOCTYPE html>
<html>
    <head>
        <title>ITB Dormitory Lease Contract</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/suratperjanjian.css')}}"/>
    </head>
    <body>
      <style>
          table{
              width: 100%;
              border: none;
          }
          table tr{
              border:none;
          }
          table tr th{
              border: none;
              font-weight:normal;
          }
      </style>
      <div class="picture_div" style="margin:0px; text-align:center;">
          <img src="{{ asset('img/kop_surat_asrama.PNG') }}" style="text-align:center;"/>
      </div>

      <div class="content-penangguhan" >
        <h2 style="font-size:14px;"><u> ITB DORMITORY LEASE CONTRACT </u></h2>
        <p style="font-size:11px;">Number : .....................</p>
        <p>I, the undersigned below:<br><br>
        <span style="display: inline-block; width: 180px;">Full Name</span>: {{$user->name or ''}}<br>
        <span style="display: inline-block; width: 180px;">Email</span>: {{$user->email or ''}}<br>
        @foreach($penghuni as $p)
        <span style="display: inline-block; width: 180px;">Birth</span>: {{$p->tempat_lahir or ''}}, {{$tanggal_lahir or ''}}<br>
        <span style="display: inline-block; width: 180px;">Blood Type</span>: {{$p->gol_darah or ''}}<br>
        <span style="display: inline-block; width: 180px;">Sex</span>: @if($p->jenis_kelamin == 'P') Female @else Male @endif<br>
        <span style="display: inline-block; width: 180px;">Nationality</span>: {{$p->warga_negara or ''}}<br>
        <span style="display: inline-block; width: 180px;">Home Address</span>: {{$p->alamat or ''}}<br>
        <span style="display: inline-block; width: 180px;"></span><span style="display: inline-block; width: 120px;">City</span>: {{$p->kota or ''}}<span style="display: inline-block; width: 120px;">Province/State</span>: {{$p->propinsi or ''}}<br>
        <span style="display: inline-block; width: 180px;"></span><span style="display: inline-block; width: 120px;">Country</span>: {{$p->negara or ''}}<span style="display: inline-block; width: 120px;">Zip/Postal Code</span>: {{$p->kodepos or ''}}<br>
        <span style="display: inline-block; width: 180px;">Mobile Phone No.</span>: {{$p->telepon or ''}}<br>
        @endforeach

        
      </div>
      
      <div class="content-penangguhan">
        <p>I have read this agreement page completely and I understand it thoroughly and I agree to abide by all terms and conditions set forth on this page in full awareness without coercion from any party.</p>
      </div>
      <div class="content-penangguhan">
          <table>
              <tr>
                  <th>
                      <br>
                      <p>
                          Head of UPT Asrama ITB,<br>
                          <br><br><br><br>
                          Dr. Ir. Agung Wiyono, M. Eng.<br>
                          NIP. 19590602 198601 1 001
                      </p>
                  </th>
                  <th>
                      <p>
                          Bandung, {{$now}}<br>
                          Occupant,<br>
                          <br><br><br><br>
                          {{$user->name}}<br>
                      </p>
                  </th>
              </tr>
          </table>
      </div>
    </body>
</html>
