<?php

namespace App\Http\Controllers;

use App\Http\Actions\UserAction;
use App\Http\Requests\ValidateUpdateUserRequest;
use App\Http\Requests\ValidateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userAction;

    public function __construct(UserAction $userAction)
    {
        $this->userAction = $userAction;
    }

    public function listUser(Request $request)
    {
        $listUser = $this->userAction->listUser($request);
        $countTrash = $this->userAction->countStatus($request);
        $status = $this->userAction->status($request);

        return view('dashboard.users.list', compact('listUser', 'countTrash', 'status'));
    }

    public function create()
    {
        $listRoles = Role::all();

        return view('dashboard.users.add', compact('listRoles'));
    }

    public function store(ValidateUserRequest $request)
    {
        $this->userAction->createUser($request);

        return redirect()->route('web.profile.list')->with('status', 'Bạn đã thành viên thành công');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('list_user')->with('error', 'Bạn đã xoá thành viên thành công');
    }

    public function edit($id)
    {
        $findUser = User::find($id);
        $listRoles = Role::all();

        return view('dashboard.users.edit', compact('findUser', 'listRoles'));
    }

    public function update(ValidateUpdateUserRequest $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;
            // Lấy tên file
            $file->getClientOriginalName();
            // Lấy đuôi file
            $file->getClientOriginalExtension();
            // Lấy kích thước file
            $file->getSize();
            $path = $file->move('public/uploads', $file->getClientOriginalName());
            $thumbnail = "public/uploads/" . $file->getClientOriginalName();
        }
        $this->userAction->updateUser($request, $id);

        return redirect()->route('list_user')->with('status', 'Bạn đã cập nhật thành viên thành công');
    }

    public function changePass($id)
    {
        return view('dashboard.users.changePass');
    }

    public function searchAjax(Request $request)
    {
        $customers = [];

        if ($request->has('search')) {
            $keyword = $request->search;
            $customers = $this->userAction->searchWithoutUserId($keyword, Auth::user());
        }

        return response()->json($customers);
    }
}
