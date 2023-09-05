<?php

namespace App\Http\Actions;

use App\Models\HumanResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HumanResourceAction
{
    protected $humanResource;

    public function __construct(HumanResource $humanResource)
    {
        $this->humanResource = $humanResource;
    }

    public function listHRMs($request)
    {
        $status = $request->input('status');
        if ($status == 'all') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm',
                    Auth::user()->id)->with('user')->get();
            }
        } elseif ($status == 'TTS') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->where('form', 'TTS')->where('user_hrm', Auth::user()->id)->orderBy('id',
                    'desc')->paginate();
            }
        } elseif ($status == 'Thử việc') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->where('form', 'Thử việc')->where('user_hrm',
                    Auth::user()->id)->orderBy('id', 'desc')->paginate();
            }
        } elseif ($status == 'HĐ 1 năm') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->where('form', 'HĐ 1 năm')->orderBy('id', 'desc')->paginate();
            }
        } elseif ($status == 'HĐ không thời hạn') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->where('form', 'HĐ không thời hạn')->where('user_hrm',
                    Auth::user()->id)->orderBy('id', 'desc')->paginate();
            }
        } elseif ($status == 'deleted_at') {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->onlyTrashed()->where('user_hrm', Auth::user()->id)->paginate();
            }
        } else {
            if ($request->input('search')) {
                $search = $request->input('search');

                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm', Auth::user()->id)->where('name',
                    'like', '%' . $search . '%')->paginate();
            } else {
                $humanResource = $this->humanResource->orderBy('id', 'desc')->where('user_hrm',
                    Auth::user()->id)->with('user')->paginate();
            }
        }
        return $humanResource;
    }

    public function countStatusHrm($id)
    {
        $arrayCountStatus = [];
        $arrayCountStatus['TTS'] = $this->humanResource->where('form', 'TTS')->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['inter'] = $this->humanResource->where('form', 'Thử việc')->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['yearOne'] = $this->humanResource->where('form', 'HĐ 1 năm')->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['unlimitedContract'] = $this->humanResource->where('form', 'HĐ không thời hạn')->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['countHRM'] = $this->humanResource->whereNull('deleted_at')->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['countDeletes'] = $this->humanResource->onlyTrashed()->where('user_hrm',
            Auth::user()->id)->count();
        $arrayCountStatus['male'] = $this->humanResource->where([
            ['gender', 'Nam'],
            ['user_hrm', Auth::id()]
        ])->count();
        $arrayCountStatus['female'] = $this->humanResource->where([
            ['gender', 'Nữ'],
            ['user_hrm', Auth::id()]
        ])->count();
        $arrayCountStatus['different'] = $this->humanResource->where([
            ['gender', 'Khác'],
            ['user_hrm', Auth::id()]
        ])->count();
        return $arrayCountStatus;
    }

    public function listHrmMonth()
    {
        return $this->humanResource->selectRaw(' DATE_FORMAT(created_at, "%b") as abbMonthName, count(*) data')
            ->where('user_hrm', Auth::id())
            ->groupBy('abbMonthName')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function monthHrm($monthDay, $year)
    {
        return $this->humanResource->selectRaw('year(created_at) year, DATE_FORMAT(created_at, "%c") as month, count(*) data')
            ->where('user_hrm', Auth::id())
            ->where(DB::raw('DATE_FORMAT(created_at, "%c")'), "=", $monthDay)
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), "=", $year)
            ->groupBy('year', 'month')
            ->orderBy('created_at', 'asc')
            ->first();
    }

    public function listHrmMonthYear($monthDay)
    {
        return $this->humanResource->selectRaw('year(created_at) year, DATE_FORMAT(created_at, "%b") as abbMonthName, count(*) data')
            ->where('user_hrm', Auth::id())
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), "=", $monthDay)
            ->groupBy('year', 'abbMonthName')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function statusActiveResponsive($request)
    {
        switch ($request->status) {
            case 'all':
                $statusActiveResponsive = 0;
                break;
            case "TTS":
                $statusActiveResponsive = 1;
                break;
            case "Thử việc":
                $statusActiveResponsive = 2;
                break;
            case "HĐ 1 năm":
                $statusActiveResponsive = 3;
                break;
            case "HĐ không thời hạn":
                $statusActiveResponsive = 4;
                break;
            default:
                $statusActiveResponsive = 0;
        }
        return $statusActiveResponsive;
    }
}