<?php

namespace App\Http\Controllers\pengelola;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Session;
use App\Http\Controllers\Traits\initialDashboard;
use App\Http\Controllers\Traits\tanggalWaktu;
use App\Http\Controllers\Traits\tanggal;
use App\Periode;
use dateTime;
use Carbon\Carbon;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Asrama;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;
use Mail;
use App\Mail\VerifikasiReguler;
use App\Mail\VerifikasiNonReguler;

class editKamarController extends Controller
{
    use initialDashboard;
	use tanggalWaktu;
	use tanggal;

    public function index(){
        $dorm = Asrama::all();
        /*
        $kamar = DB::table('kamar')
                        ->leftjoin(
                                DB::select('gedung AS tempat')
                                        ->select('gedung.id_gedung','gedung.nama AS gedung','asrama.id_asrama','asrama.nama AS asrama')
                                        ->leftjoin('asrama','asrama.id_asrama','=','gedung.id_asrama'),'tempat.id_gedung','=','kamar.id_gedung'
                            )
                        ->where('tempat.id_asrama',$pengelola->id_asrama)
                        ->select('kamar.id_kamar','kamar.nama','kapasitas','`status`','keterangan','gender','which_user','is_difable','tempat.id_gedung','tempat.gedung','tempat.id_asrama','tempat.asrama')
                        ->orderBy('kamar.nama','asc')
                        ->paginate(10); */
        Session::flash('menu','pengelola/edit_kamar');
    	return view('dashboard.pengelola.editKamar', $this->getInitialDashboard())->with(['dorm'=>$dorm]);
    }

    public function pencarianKamar(Request $request){
        $dorm = Asrama::all();
        $id_asrama = $request->dorm;
        $pencarian = $id_asrama;
        $asrama = Asrama::find($id_asrama)->nama;
        $kamar = DB::select("SELECT kamar.id_kamar, kamar.nama, kapasitas, sekarang, `status`, keterangan, gender, which_user, is_difable, tempat.id_gedung, tempat.gedung, tempat.id_asrama, tempat.asrama FROM kamar LEFT JOIN (SELECT gedung.id_gedung, gedung.nama AS gedung, asrama.id_asrama, asrama.nama AS asrama FROM gedung LEFT JOIN asrama ON asrama.id_asrama = gedung.id_asrama) AS tempat ON tempat.id_gedung = kamar.id_gedung lEFT JOIN (select count(id_kamar) as sekarang, id_kamar as id_saja from daftar_asrama_reguler left join kamar_penghuni on daftar_asrama_reguler.id_daftar = kamar_penghuni.daftar_asrama_id and kamar_penghuni.daftar_asrama_type = 'Daftar_asrama_reguler' WHERE daftar_asrama_reguler.verification = 5 GROUP BY id_saja) as now on now.id_saja = kamar.id_kamar WHERE tempat.id_asrama = ? ORDER BY kamar.id_kamar",[$id_asrama]);
        Session::flash('menu','pengelola/edit_kamar');
        return view('dashboard.pengelola.editKamar', $this->getInitialDashboard())->with(['kamar'=>$kamar, 'pencarian' => $pencarian, 'dorm'=>$dorm, 'asrama' => $asrama]);
    }

    public function editKamar(Request $request){
        $dorm = Asrama::all();
    	// validasi
    	$this->Validate($request, [
    		'nama' => 'required',
    		'kapasitas' => 'required|numeric',
    	]);

    	// update data
    	$kamar = Kamar::find($request->id_kamar);
    	$kamar->nama = $request->nama;
    	$kamar->kapasitas = $request->kapasitas;
    	$kamar->gender = $request->gender;
    	$kamar->which_user = $request->which_user;
    	$kamar->is_difable = $request->is_difable;
    	$kamar->status = $request->status;
    	if($request->keterangan == NULL){
    		$kamar->keterangan = '-';
    	}else{
    		$kamar->keterangan = $request->keterangan;
    	}
    	$kamar->save();
    	Session::flash('status2','Data berhasil diubah');
        Session::flash('menu','pengelola/edit_kamar');
        return view('dashboard.pengelola.editKamar', $this->getInitialDashboard())->with(['dorm'=>$dorm]);
    }
}
