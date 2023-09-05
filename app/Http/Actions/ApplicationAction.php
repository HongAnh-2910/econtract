<?php

namespace App\Http\Actions;

use App\Mail\Application\SendNotificationMailToClient;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationAction
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function listenSendMailDecision($userId ,$application)
    {
        if ($userId) {
            $application = $this->application::GetByIdApplication($application->id)
                ->with('user')
                ->first();
            $emailUser = $application->user->email;

            $applications = [
                'title' => 'Đơn từ của OneSign',
                'body' => 'Đang có phần đơn từ cần bạn xét duyệt!'
            ];

            Mail::to($emailUser)->send(new SendNotificationMailToClient($applications));
        }
    }

    public function sendMailDecision($userId, $applicationId)
    {
        if ($userId) {
            $application = $this->application::GetByIdApplication($applicationId)
                ->with('user')
                ->first();
            $emailUser = $application->user->email;

            $applications = [
                'title' => 'Đơn từ của OneSign',
                'body' => 'Đang có phần đơn từ cần bạn xét duyệt!'
            ];

            Mail::to($emailUser)->send(new SendNotificationMailToClient($applications));
        }
    }

    public function sendMailFollow($userConsider, $applicationId)
    {
        if ($userConsider) {
            $applications = $this->application::find($applicationId)->users;
            foreach ($applications as $value) {
                $contentMail = [
                    'title' => 'Đơn từ của OneSign',
                    'body' => 'Đang có phần đơn từ cần xem xét'
                ];

                Mail::to($value->email)->send(new SendNotificationMailToClient($contentMail));
            }
        }
    }

    public function statusApplicationResponsive($request)
    {
        switch ($request->status) {
            case config('statuses.wait'):
                $statusApplication = 1;
                break;
            case config('statuses.approved'):
                $statusApplication = 2;
                break;
            case config('statuses.not'):
                $statusApplication = 3;
                break;
            case config('statuses.delete'):
                $statusApplication = 4;
                break;
            case config('statuses.rest'):
                $statusApplication = 5;
                break;
            case config('statuses.recommend'):
                $statusApplication = 6;
                break;
            default:
                $statusApplication = 0;
        }
        return $statusApplication;
    }

    public function listApplications($request)
    {
        $status = $request->status;
        $search = $request->input('search', $request->input('keyword'));
        $query = $this->application::orderBy('id', 'desc');
        switch ($status) {
            case config('statuses.wait'):
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search)->StatusApplication(config('statuses.wait'));
                break;
            case config('statuses.approved'):
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search)->StatusApplication(config('statuses.approved'));
                break;
            case config('statuses.not'):
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search)->StatusApplication(config('statuses.not'));
                break;
            case config('statuses.delete'):
                $applications = $query->onlyTrashed()->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search);
                break;
            case config('statuses.rest'):
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search)->TypeApplication(config('statuses.rest'));
                break;
            case config('statuses.recommend'):
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search)->TypeApplication(config('statuses.recommend'));
                break;
            default:
                $applications = $query->GetUserApplicationOrUser(Auth::id())
                    ->IsSearchName($search);
        }

        return $applications->paginate();
    }

    public function customerStatusIsWaitingCount()
    {
        return $this->application::where(
            [
                ['status', config('statuses.wait')],
                ['user_application', Auth::user()->id],
            ]
        )->orwhere(
                'user_id', Auth::user()->id
            )->where(
                'status',
                config('statuses.wait')
            )->count();
    }

    public function customerStatusIsApprovedCount()
    {
        return $this->application::where(
            [
                ['status', config('statuses.approved')],
                ['user_application', Auth::user()->id],
            ]
        )->orwhere(
                'user_id', Auth::user()->id
            )->where(
                'status',
                config('statuses.approved')
            )->count();
    }

    public function customerStatusIsCancelCount()
    {
        return $this->application::where(
            [
                ['status', config('statuses.not')],
                ['user_application', Auth::user()->id],
            ]
        )->orwhere(
                'user_id', Auth::user()->id
            )->where(
                'status',
                config('statuses.not')
            )->count();
    }

    public function customerApplicationTypeCount()
    {
        return $this->application::where(
            [
                ['application_type', config('statuses.rest')],
                ['user_application', Auth::user()->id],
            ]
        )->orwhere(
                'user_id', Auth::user()->id
            )->where(
                'application_type',
                config('statuses.rest')
            )->count() + User::find(Auth::id())->applicationss->where(
                'application_type',
                config('statuses.rest')
            )->count();
    }

    public function customerApplicationTypeProposal()
    {
        return $this->application::where(
            [
                ['application_type', config('statuses.recommend')],
                ['user_application', Auth::user()->id],
            ]
        )->orwhere(
                'user_id', Auth::user()->id
            )->where(
                'application_type',
                config('statuses.recommend')
            )->count() + User::find(Auth::id())->applicationss->where('application_type', config('statuses.recommend'))->count();
    }

    public function countApplications()
    {
        return $this->application::where(
            'user_application', Auth::user()->id
        )->orwhere(
                'user_id', Auth::user()->id

            )->count() + User::find(Auth::id())->applicationss->count();
    }

    public function countSoftDelete()
    {
        return $this->application::onlyTrashed()->where('user_application', Auth::id())
            ->count();
    }

    public function userApplications($id)
    {
        return User::where([
            ['parent_id', $id],
            ['id', '<>', Auth::id()]
        ])->get();
    }

    public function userApplicationsAjax($id, $request)
    {
        return User::with('parent')->whereNotIn('id', $request->value_id)
            ->where([
                ['parent_id', $id],
                ['id', '<>', Auth::id()]
            ])->get();
    }
}
