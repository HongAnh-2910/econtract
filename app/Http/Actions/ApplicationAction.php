<?php

namespace App\Http\Actions;

use App\Mail\Application\SendNotificationMailToClient;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationAction
{
    /**
     * @var Application
     */

    protected $application;

    /**
     * @var User
     */

    protected $user;

    public function __construct(Application $application , User $user)
    {
        $this->application = $application;
        $this->user = $user;
    }

    public function statusApplicationResponsive($status)
    {
        $statusApplicationResponsive = [
            config('statuses.wait')      => 1,
            config('statuses.approved')  => 2,
            config('statuses.not')       => 3,
            config('statuses.delete')    => 4,
            config('statuses.rest')      => 5,
            config('statuses.recommend') => 6
        ];
        return Arr::get($statusApplicationResponsive ,is_null($status) ? config('statuses.wait') : $status);
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

    public function userApplications($id)
    {
        return $this->user::where([
            ['parent_id', $id],
            ['id', '<>', Auth::id()]
        ])->get();
    }

    public function userApplicationsAjax($id, $valueId)
    {
        return $this->user::with('parent')->where('id', '<>' ,$valueId)
            ->where('id', '<>', Auth::id())
            ->WhereByParentUser($id)
            ->get();
    }
}
