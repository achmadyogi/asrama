<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pengumuman;
use Illuminate\Support\Facades\Auth;
use Session;
use DormAuth;

class PengumumanController extends Controller
{
    public function showPengumuman($id_pengumuman) {
        $pengumuman = Pengumuman::where('id_pengumuman', $id_pengumuman)->get()->first();
        $list_pengumuman = DB::table('pengumuman')->orderBy('id_pengumuman','DESC')->simplePaginate(4);
        return view('pengumuman.show')
            ->with(['pengumuman' => $pengumuman,
                    'list_pengumuman' => $list_pengumuman]);
    }

    public function index() {
        $list_pengumuman = Pengumuman::all();
        return view('pengumuman.index')
            ->with(['list_pengumuman' => $list_pengumuman]);
    }

    public function showAddPengumuman() {
        Session::flash('menu','post_pengumuman');
        return view('pengumuman.create');
    }

    public function addPengumuman(Request $request) {
        $pengumuman = new Pengumuman();
        $pengumuman->id_penulis = DormAuth::User()->id;
        $pengumuman->title = $request->title;
        $pengumuman->isi = $request->konten;
        $pengumuman->save();

        Session::flash('status2','Pengumuman berhasil ditambahkan.');
        return redirect()->back();
    }
}
