<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;

class RankUpMail extends Mailable
{
    use Queueable, SerializesModels;

    private $rankMedal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rankMedal)
    {
        $this->rankMedal = $rankMedal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = Auth::user()->name;
        $rankMedal = $this->rankMedal;
        return $this->view('mail.rankUp', compact('name', 'rankMedal'));
    }
}
