<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Berita;
use App\Http\Controllers\Traits\initialDashboard;
use Illuminate\Support\Facades\Auth;
use Session;
use Mail;
use App\Mail\NotifikasiPenghuni;
use \Input as Input;
use DormAuth;

class NotificationController extends Controller
{
    use initialDashboard;

    public function FormEmail() {
        return view('admin.mailing', $this->getInitialDashboard()); 
    }

    public function SendNotification(Request $request) {
        
        if ($request->tujuan == 1) {
            Mail::to($request->email_tujuan)->send(new NotifikasiPenghuni($request->konten));
        } else {
            $list_email = DB::select("SELECT users.name, users.email FROM users, daftar_asrama_reguler WHERE users.id = daftar_asrama_reguler.id_user AND daftar_asrama_reguler.id_periode = 1 AND daftar_asrama_reguler.verification = 5");
            foreach($list_email as $email) {
                Mail::to($email)->send(new VerifikasiNonReguler($request));
            }
        }
        
        
        Session::flash('status2','Berita berhasil ditambahkan.');
        return view('dashboard.dashboard', $this->getInitialDashboard());
    }
}
