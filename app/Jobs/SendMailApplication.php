<?php

namespace App\Jobs;

use App\Mail\Application\SendNotificationMailToClient;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $userId;

    /**
     * @var
     */

    private $application;

    private $contentMail;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId , Application $application , array $contentMail)
    {
        $this->userId      = $userId;
        $this->application = $application;
        $this->contentMail = $contentMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type        = data_get($this->contentMail, 'type');
        $application = $this->application->GetByIdApplication($this->application->id)
                                         ->with('user', 'users')
                                         ->first();
        if ($type === 'decision') {
            Mail::to($application->user->email)->send(new SendNotificationMailToClient($this->contentMail));
        }
        $application->users->each(function ($user) {
            Mail::to($user->email)->send(new SendNotificationMailToClient($this->contentMail));
        });
    }
}
