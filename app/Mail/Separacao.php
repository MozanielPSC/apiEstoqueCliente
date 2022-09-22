<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Separacao extends Mailable
{
    use Queueable, SerializesModels;
    public $log;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $log,string $code)
    {
        $this->log = $log;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.separacao');
    }
}