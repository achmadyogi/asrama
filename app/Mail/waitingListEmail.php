<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User_penghuni;
use App\User;
use App\User_nim;
use App\Prodi;
use Session;
use App\Periode;
use dateTime;
use App\Daftar_asrama_non_reguler;
use App\Daftar_asrama_reguler;
use Illuminate\Support\Facades\DB;
use App\Kamar;
use App\Kamar_penghuni;
use App\Tarif;
use App\Tagihan;

class waitingListEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $Reg;
    public function __construct(daftar_asrama_reguler $Reg)
    {
        $this->Reg = $Reg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Dapatkan nama
        $user = User::find(Daftar_asrama_reguler::find($this->Reg->id_daftar)->id_user);
        $nama = $user->name;
        $email = $user->email;
        return $this->view('email.waitingListContent')
                    ->with(['email'=>$email,'nama'=>$nama]);
    }
}
