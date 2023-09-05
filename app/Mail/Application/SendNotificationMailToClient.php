<?php

namespace App\Mail\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotificationMailToClient extends Mailable
{
    use Queueable, SerializesModels;

    public $applications;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->subject($this->subject)->view('dashboard.application.sendMail');
    }
}
