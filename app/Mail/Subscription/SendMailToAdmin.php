<?php


namespace App\Mail\Subscription;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendMailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var UserSubscription
     */
    private $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserSubscription $data)
    {
        $this->subject = config('app.name') . " thông báo đăng ký gói cước";
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('mail.subscription.mailer')->with([
            'data' => $this->data
        ]);
    }
}
