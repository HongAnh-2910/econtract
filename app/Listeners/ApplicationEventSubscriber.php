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
        $userId      = $event->getUserId();
        $application = $event->getApplicationModel();
        $contentMail = [
            'title' => 'Đơn từ của OneSign',
            'body'  => 'Đang có phần đơn từ cần bạn xét duyệt!',
            'type'  => 'decision'
        ];
        SendMailApplication::dispatch($userId, $application , $contentMail)->onQueue('mail');
    }

    /**
     * @param $event
     * @return void
     */

    public function handleSendMailFollow($event)
    {
        $userId      = $event->getUserId();
        $application = $event->getApplicationModel();
        $contentMail = [
            'title' => 'Đơn từ của OneSign',
            'body'  => 'Đang có phần đơn từ cần bạn xem xét!',
            'type'  => 'follow'
        ];
        SendMailApplication::dispatch($userId, $application , $contentMail)->onQueue('mail');
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
