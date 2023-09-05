<?php

namespace App\Http\Controllers;

use App\Exports\HrmExport;
use App\Http\Actions\HumanResourceAction;
use App\Http\Requests\HRMRequest;
use App\Http\Requests\ValidateUpdateUserRequest;
use App\Http\Requests\ValidateUserHRMRequest;
use App\Models\Department;
use App\Models\HumanResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class HumanResourceController extends Controller
{
    protected $user;
    protected $humanResourceAction;

    public function __construct(User $user, HumanResourceAction $humanResourceAction)
    {
        $this->humanResourceAction = $humanResourceAction;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $HRMs = $this->humanResourceAction->listHRMs($request);
        //department
        $department = Department::where('user_id', Auth::id())->get();
        $departments = data_tree($department, null);
        // Count status
        $countFormTypeTTS = HumanResource::where('form', 'TTS')->where('user_hrm',
            Auth::user()->id)->count();
        $countFormTypeIntern = HumanResource::where('form', 'Thử việc')->where('user_hrm',
            Auth::user()->id)->count();
        $countFormTypeContractOneYears = HumanResource::where('form', 'HĐ 1 năm')->where('user_hrm',
            Auth::user()->id)->count();
        $countFormTypeUnlimitedContract = HumanResource::where('form', 'HĐ không thời hạn')->where('user_hrm',
            Auth::user()->id)->count();
        $countHRMs = HumanResource::whereNull('deleted_at')->where('user_hrm',
            Auth::user()->id)->count();
        $countDeleted = HumanResource::onlyTrashed()->where('user_hrm', Auth::user()->id)->count();
        $statusActiveResponsive = $this->humanResourceAction->statusActiveResponsive($request);
        return view('dashboard.humanResource.list',
            compact('HRMs', 'departments', 'countFormTypeTTS', 'countFormTypeIntern', 'countFormTypeContractOneYears',
                'countFormTypeUnlimitedContract', 'countDeleted', 'countHRMs', 'statusActiveResponsive'));
    }

    public function store(ValidateUserHRMRequest $validateUserHRMRequest)
    {
        $user = $this->user->create([
            'name' => $validateUserHRMRequest->input('name'),
            'email' => $validateUserHRMRequest->input('email'),
            'password' => Hash::make($validateUserHRMRequest->input('password')),
            'parent_id' => Auth::id(),
            'user_type_id' => Auth::user()->user_type_id,
            'valid_to' => Auth::user()->valid_to
        ]);

        $user->departments()->sync($validateUserHRMRequest->input('department_id'));

        foreach ($validateUserHRMRequest->input('department_id') as $value) {
            $dataDepartment = $value;
        }

        if ($validateUserHRMRequest->hasFile('file')) {
            $file = $validateUserHRMRequest->file;
            // Lấy tên file
            $file->getClientOriginalName();
            // Lấy đuôi file
            $file->getClientOriginalExtension();
            // Lấy kích thước file
            $file->getSize();
            $path = $file->move('public/uploads', $file->getClientOriginalName());
            $thumbnail = "public/uploads/" . $file->getClientOriginalName();

            HumanResource::create([
                'gender' => $validateUserHRMRequest->input('gender'),
                'phone_number' => $validateUserHRMRequest->input('phone_number'),
                'date_start' => $validateUserHRMRequest->input('date_start_add'),
                'department_id' => $dataDepartment,
                'form' => $validateUserHRMRequest->input('form'),
                'date_of_birth' => $validateUserHRMRequest->input('date_of_birth'),
                'passport' => $validateUserHRMRequest->input('passport'),
                'date_range' => $validateUserHRMRequest->input('date_range'),
                'place_range' => $validateUserHRMRequest->input('place_range'),
                'permanent_address' => $validateUserHRMRequest->input('permanent_address'),
                'current_address' => $validateUserHRMRequest->input('current_address'),
                'account_number' => $validateUserHRMRequest->input('account_number'),
                'name_account' => $validateUserHRMRequest->input('name_account'),
                'name_bank' => $validateUserHRMRequest->input('name_bank'),
                'motorcycle_license_plate' => $validateUserHRMRequest->input('motorcycle_license_plate'),
                'file' => $thumbnail,
                'user_id' => $user->id,
                'user_hrm' => Auth::id()

            ]);
        } else {
            HumanResource::create([
                'gender' => $validateUserHRMRequest->input('gender'),
                'phone_number' => $validateUserHRMRequest->input('phone_number'),
                'date_start' => $validateUserHRMRequest->input('date_start_add'),
                'department_id' => $dataDepartment,
                'form' => $validateUserHRMRequest->input('form'),
                'date_of_birth' => $validateUserHRMRequest->input('date_of_birth'),
                'passport' => $validateUserHRMRequest->input('passport'),
                'date_range' => $validateUserHRMRequest->input('date_range'),
                'place_range' => $validateUserHRMRequest->input('place_range'),
                'permanent_address' => $validateUserHRMRequest->input('permanent_address'),
                'current_address' => $validateUserHRMRequest->input('current_address'),
                'account_number' => $validateUserHRMRequest->input('account_number'),
                'name_account' => $validateUserHRMRequest->input('name_account'),
                'name_bank' => $validateUserHRMRequest->input('name_bank'),
                'motorcycle_license_plate' => $validateUserHRMRequest->input('motorcycle_license_plate'),
                'file' => $validateUserHRMRequest->input('file'),
                'user_id' => $user->id,
                'user_hrm' => Auth::id()
            ]);
        }

        Session::flash('success', 'Nhân sự được tạo thành công');

        return redirect()->route('web.human-resources.list');
    }

    public function update(ValidateUpdateUserRequest $requestUser, HRMRequest $hrmRequest, $id)
    {
        $checkEmail = HumanResource::find($id)->user;
        if ($checkEmail->email !== $requestUser->input('email')) {
            $requestUser->validate([
                'email' => 'unique:users,email'
            ], [
                'unique' => ':Attribute đã có người sử dụng',
            ]);
        }
        $userId = HumanResource::find($id);
        $userFind = $this->user->find($userId->user_id);

        if ($userFind->email == $requestUser->input('email')) {
            $this->user->where('id', $userId->user_id)->update([
                'name' => $requestUser->input('name'),
                'img_user' => $userFind->img_user,
            ]);
        } else {
            $this->user->where('id', $userId->user_id)->update([
                'name' => $requestUser->input('name'),
                'email' => $requestUser->input('email'),
                'img_user' => $userFind->img_user,
            ]);
        }
        $userFind->departments()->sync($requestUser->input('department_id'));

        if ($userFind->email == $requestUser->input('email')) {
            $this->user->where('id', $userId->user_id)->update([
                'name' => $requestUser->input('name'),
                'img_user' => $userFind->img_user,
            ]);
        } else {
            $this->user->where('id', $userId->user_id)->update([
                'name' => $requestUser->input('name'),
                'email' => $requestUser->input('email'),
                'img_user' => $userFind->img_user,
            ]);
        }
        $userFind->departments()->sync($requestUser->input('department_id'));


        foreach ($hrmRequest->input('department_id') as $value) {
            $dataDepartment = $value;
        }

        if ($hrmRequest->hasFile('file')) {
            $file = $hrmRequest->file;
            // Lấy tên file
            $file->getClientOriginalName();
            // Lấy đuôi file
            $file->getClientOriginalExtension();
            // Lấy kích thước file
            $file->getSize();
            $path = $file->move('public/uploads', $file->getClientOriginalName());
            $thumbnail = "public/uploads/" . $file->getClientOriginalName();

            $hrm = HumanResource::where('id', $id)->update([
                'gender' => $hrmRequest->input('gender'),
                'phone_number' => $hrmRequest->input('phone_number'),
                'date_start' => $hrmRequest->input('date_start'),
                'department_id' => $dataDepartment,
                'form' => $hrmRequest->input('form'),
                'date_of_birth' => $hrmRequest->input('date_of_birth'),
                'passport' => $hrmRequest->input('passport'),
                'date_range' => $hrmRequest->input('date_range'),
                'place_range' => $hrmRequest->input('place_range'),
                'permanent_address' => $hrmRequest->input('permanent_address'),
                'current_address' => $hrmRequest->input('current_address'),
                'account_number' => $hrmRequest->input('account_number'),
                'name_account' => $hrmRequest->input('name_account'),
                'name_bank' => $hrmRequest->input('name_bank'),
                'motorcycle_license_plate' => $hrmRequest->input('motorcycle_license_plate'),
                'file' => $thumbnail,
            ]);
        } else {
            $hrm = HumanResource::where('id', $id)->update([
                'gender' => $hrmRequest->input('gender'),
                'phone_number' => $hrmRequest->input('phone_number'),
                'date_start' => $hrmRequest->input('date_start'),
                'department_id' => $dataDepartment,
                'form' => $hrmRequest->input('form'),
                'date_of_birth' => $hrmRequest->input('date_of_birth'),
                'passport' => $hrmRequest->input('passport'),
                'date_range' => $hrmRequest->input('date_range'),
                'place_range' => $hrmRequest->input('place_range'),
                'permanent_address' => $hrmRequest->input('permanent_address'),
                'current_address' => $hrmRequest->input('current_address'),
                'account_number' => $hrmRequest->input('account_number'),
                'name_account' => $hrmRequest->input('name_account'),
                'name_bank' => $hrmRequest->input('name_bank'),
                'motorcycle_license_plate' => $hrmRequest->input('motorcycle_license_plate'),
                'file' => $hrmRequest->input('file'),
            ]);
        }
        Session::flash('success', 'Nhân sự được cập nhật thành công');

        return redirect()->route('web.human-resources.list');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;

        HumanResource::whereIn('id', explode(',', $ids))->delete();
        Session::flash('success', 'Bạn đã xóa nhân sự thành công');
    }

    public function restore(Request $request)
    {
        $ids = $request->ids;

        HumanResource::whereIn('id', explode(',', $ids))->restore();
        Session::flash('success', 'Bạn đã khôi phục nhân sự thành công');
    }

    public function forceDelete(Request $request)
    {
        //Get id form checkbox(view)
        $arrayIdHRM = [];
        $arrayIdUser = [];
        $ids = $request->ids;
        array_push($arrayIdHRM, explode(',', $ids));

        //Delete HRM
        foreach ($arrayIdHRM[0] as $value) {
            $HRM = HumanResource::onlyTrashed()->where('id', $value)->first();
            array_push($arrayIdUser, explode(',', $HRM->user_id));
            HumanResource::whereIn('id', explode(',', $ids))->forceDelete();
        }
        // Delete User
        foreach ($arrayIdUser[0] as $userId) {
            $this->user->where('id', $userId)->forceDelete();
        }

        Session::flash('success', 'Bạn đã xóa vĩnh viễn nhân sự thành công');
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $hrmWithUsers = User::where("name", "LIKE", "%{$keyword}%")
            ->orWhere("email", "LIKE", "%{$keyword}%")
            ->get();

        return view('dashboard.humanResource.searchHrm', compact('hrmWithUsers'));
    }

    public function exportExcel()
    {
        return Excel::download(new HrmExport, 'Danh sách nhân sự.xlsx');
    }

    public function statisticalHome(Request $request)
    {
        $applicationModel = new \App\Models\Application();
        $monthDayYear = Carbon::now()->year;
        $listHrm = HumanResource::where('user_hrm',
            Auth::user()->id)->orderBy('id', 'DESC')->paginate();
        $monthDay = Carbon::now()->month;
        $monthHrm = $this->humanResourceAction->monthHrm($monthDay, $monthDayYear);
        $listHrmMonth = $this->humanResourceAction->listHrmMonthYear($monthDayYear);
        $listHrmMonthArray = [];
        foreach ($listHrmMonth as $month) {
            $listHrmMonthArray[$month->abbMonthName] = $month->data;
        }

        $countStatusHrm = $this->humanResourceAction->countStatusHrm(Auth::id());

        return view('dashboard.humanResource.statistical_home', compact('countStatusHrm',
            'monthHrm', 'listHrmMonth', 'listHrmMonthArray', 'listHrm', 'applicationModel'));
    }

    public function filterYearChart(Request $request)
    {
        $id = $request->value;
        $id2 = $request->value;
        if ($id == $id2) {
            $id = Str::random(2);
        }
        $listHrmMonthArray = [];
        if ($id2 == 'Overall') {
            $listHrmMonth = $this->humanResourceAction->listHrmMonth();
            foreach ($listHrmMonth as $month) {
                $listHrmMonthArray[$month->abbMonthName] = $month->data;
            }
        } elseif ($id2 == 'Last Year') {
            $monthDay = Carbon::now()->subYears(1)->year;
            $listHrmMonth = $this->humanResourceAction->listHrmMonthYear($monthDay);
            foreach ($listHrmMonth as $month) {
                $listHrmMonthArray[$month->abbMonthName] = $month->data;
            }

        } elseif ($id2 == 'This Year') {
            $monthDay = Carbon::now()->year;
            $listHrmMonth = $this->humanResourceAction->listHrmMonthYear($monthDay);
            foreach ($listHrmMonth as $month) {
                $listHrmMonthArray[$month->abbMonthName] = $month->data;
            }
        }
        return view('dashboard.humanResource.chart_ajax_year', compact('id', 'listHrmMonthArray'));
    }
}
