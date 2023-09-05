<?php

namespace App\Http\Controllers;

use App\Http\Actions\UserAction;
use App\Http\Requests\ValidateChangePassRequest;
use App\Http\Requests\ValidateUpdateUserRequest;
use App\Models\Application as AppApplication;
use App\Models\DateTimeOfApplication;
use App\Models\Department;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use UploadTrait;

    protected $userAction;
    protected $user;

    public function __construct(UserAction $userAction, User $user)
    {
        $this->user = $user;
        $this->userAction = $userAction;
    }

    public function index()
    {
        $userFind = Auth::user();

        return view('dashboard.profile.index', compact('userFind'));
    }

    public function update(ValidateUpdateUserRequest $request, $id)
    {
        $checkEmail = User::find($id);
        if ($checkEmail->email !== $request->input('email')) {
            $request->validate([
                'email' => 'required|unique:users,email'
            ],
                [
                    'unique' => ':Attribute đã có người sử dụng'
                ]
            );
        }
        return $this->userAction->updateUser($request, $id);
    }

    public function profilePassword()
    {
        $userFind = Auth::user();

        return view('dashboard.profile.profile_password', compact('userFind'));
    }

    public function changePassword(ValidateChangePassRequest $request)
    {
        return $this->userAction->storeChangePass($request->input('pass-old'), $request->input('password'));
    }

    public function list(Request $request)
    {
        $countAll = $this->userAction->countChildData();
        $id = Auth::id();
        $listUsers = $this->userAction->listUser($request);
        $countTrash = $this->userAction->countStatus($request);
        $listDepartment = Department::where('user_id', $id)->get();
        $listDepartmentLevel = data_tree($listDepartment, null);
        $activeUser = $this->userAction->statusActiveUser($request);
        return view('dashboard.profile.list', compact('id', 'listUsers', 'countTrash', 'countAll', 'listDepartmentLevel', 'activeUser'));
    }

    public function delete($id)
    {
        $this->user::where('id', $id)->delete();

        return redirect()->route('web.profile.list')->with('status', 'Bạn đã xoá thành viên thành công');
    }

    public function restore($id)
    {
        $this->user::withTrashed()->where('id', $id)->restore();

        return redirect()->route('web.profile.list')->with('status', 'Bạn đã khôi phục thành viên thành công');
    }

    public function forceDelete($id)
    {
        $userApplication = $this->user->applications;

        if (empty($userApplication)) {
            $successDeleteAll = $this->user::withTrashed()->where('id', $id)->forceDelete();
        } else {
            $application = AppApplication::where('user_id', $id)->forceDelete();

            DateTimeOfApplication::where('application_id', $application->id)->forceDelete();

            AppApplication::where('user_id', $id)->first()->forceDelete();

            $successDeleteAll = $this->user::withTrashed()->where('id', $id)->forceDelete();
        }


        if ($successDeleteAll) {
            return redirect()->route('web.profile.list')->with('status', 'Bạn đã xoá vĩnh viễn thành viên thành công');
        } else {
            return redirect()->route('web.profile.list')->with('status', 'Bạn đã xoá vĩnh viễn thành viên thất bại');
        }
    }

    public function checkboxAllUser(Request $request)
    {
        return $this->userAction->checkboxAllUser($request);
    }
}
