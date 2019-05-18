<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class NotifikasiPenghuni extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $notif;
    public function __construct(Request $request)
    {
        $this->message = $notif;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notification')
                    ->with('message', $this->$message);
    }
}
