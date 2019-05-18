<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Daftar_asrama_reguler;
use App\Daftar_asrama_non_reguler;
use App\User_nim;
use App\User_penghuni;
use App\Asrama;
use App\Next_periode;
use App\Periode;
use App\Blacklist;
use App\Keluar_asrama;
use App\kerusakan_kamar;
use App\Pengelola;
use App\Fakultas;
use Session;
use ITBdorm;
use DormAuth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $fakultas = Fakultas::all();
        Session::flash('menu','dashboard');
        return view('dashboard.dashboard',['fakultas' => $fakultas]);
    }

    public function dataDiri(){
        Session::flash('menu','dataDiri');
        return view('dashboard.dataDiri');
    }

    public function uploadProfil(Request $request){
        //dapatkan ID user
        $this->Validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ID = DormAuth::User();

        $avatarName = $ID->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
        
        $request->avatar->storeAs('avatars',$avatarName);
        
        $ID->foto_profil = $avatarName;
        $ID->save();
        Session::flash('status2','Foto profil berhasil di unggah.');
        return redirect()->route('dashboard');
    }
}
