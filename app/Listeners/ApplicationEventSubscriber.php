<?php

namespace App\Listeners;

use App\Events\SendMailDecisionEvent;
use App\Events\SendMailFollowEvent;
use App\Jobs\SendMailApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApplicationEventSubscriber
{

    /**
     * @param $event
     * @return void
     */

    public function handleSendMailDecision($event)
    {
        $application = $event->getApplicationModel();
        $application = $application->GetByIdApplication($application->id)->with('user')->first();
        $contentMail = [
            'title' => 'Đơn từ của OneSign',
            'body'  => 'Đang có phần đơn từ cần bạn xét duyệt!',
        ];
        SendMailApplication::dispatch(data_get($application->user , 'email') , $contentMail)->onQueue('mail');
    }

    /**
     * @param $event
     * @return void
     */

    public function handleSendMailFollow($event)
    {
        $application = $event->getApplicationModel();
        $application = $application->GetByIdApplication($application->id)->with('users')->first();
        $contentMail = [
            'title' => 'Đơn từ của OneSign',
            'body'  => 'Đang có phần đơn từ cần bạn xem xét!',
        ];
        $application->users->each(function ($user) use ($contentMail) {
            SendMailApplication::dispatch($user->email , $contentMail)->onQueue('mail');
        });
    }

    /**
     * @param $events
     * @return void
     */

    public function subscribe($events)
    {
        $events->listen('App\Events\SendMailDecisionEvent',
            'App\Listeners\ApplicationEventSubscriber@handleSendMailDecision');
        $events->listen('App\Events\SendMailFollowEvent',
            'App\Listeners\ApplicationEventSubscriber@handleSendMailFollow');
    }
}
