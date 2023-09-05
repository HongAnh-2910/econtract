<?php

namespace App\Mail\Contract;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToClientSign extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject = config('app.name') . " thông báo ký hợp đồng";
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('mail.contract.contract_email')->with([
            'token' => $this->data['token'],
            'contract_id' => $this->data['contract_id'],
            'user' => $this->data['user'],
        ]);
    }
}
