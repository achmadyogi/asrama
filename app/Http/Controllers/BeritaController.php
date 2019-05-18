<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Berita;
use Illuminate\Support\Facades\Auth;
use Session;
use \Input as Input;
use DormAuth;

class BeritaController extends Controller
{
    public function showBerita($id_berita) {
        $berita = Berita::where('id_berita', $id_berita)->get()->first();
        $list_berita = DB::table('berita')->orderBy('id_berita','DESC')->simplePaginate(4);
        $list_pengumuman = DB::table('pengumuman')->orderBy('id_pengumuman','DESC')->simplePaginate(4);
        return view('berita.show')
            ->with(['berita' => $berita,
                    'list_berita' => $list_berita,
                    'list_pengumuman' => $list_pengumuman]);
    }

    public function index() {
        $list_berita = Berita::all();
        return view('berita.index')
            ->with(['list_berita' => $list_berita]);
    }

    public function showAddBerita() {
        Session::flash('menu','post_berita');
        return view('berita.create');
    }

    public function addBerita(Request $request) {
        $this->Validate($request,[
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000|required'
        ]);

        $uploadFile = $request->file('image');
        $path = $uploadFile->store('public/berita');

        $berita = new Berita();
        $berita->id_penulis = DormAuth::User()->id;
        $berita->title = $request->title;
        $berita->isi = $request->konten;
        $berita->file = $path;
        $berita->save();

        Session::flash('status2','Berita berhasil ditambahkan.');
        return redirect()->back();
    }
}
