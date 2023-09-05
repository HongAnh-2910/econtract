<?php

namespace App\Mail\Contract;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToFollow extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $applications;

    public function __construct($data)
    {
        $this->subject = config('app.name') . " thông báo";
        $this->applications = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('dashboard.contract.sendMailFollow');
    }
}
