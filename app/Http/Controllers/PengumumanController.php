<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengumuman;

class PengumumanController extends Controller
{
    public function showPengumuman($id_pengumuman) {
        $pengumuman = Pengumuman::where('id_pengumuman', $id_pengumuman)->get()->first();
        $list_pengumuman = Pengumuman::all();
        return view('pengumuman.show')
            ->with(['pengumuman' => $pengumuman,
                    'list_pengumuman' => $list_pengumuman,]);
    }

    public function index() {
        $list_pengumuman = Pengumuman::all();
        return view('pengumuman.index')
            ->with(['list_pengumuman' => $list_pengumuman]);
    }
}
