<?php

namespace App\Http\Controllers;

use App\Http\Actions\DepartmentAction;
use App\Http\Requests\ValidateDepartmentRequest;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    protected $departmentAction;

    public function __construct(DepartmentAction $departmentAction)
    {
        $this->departmentAction = $departmentAction;
    }

    public function store(ValidateDepartmentRequest $request)
    {
        $createDepartment = Department::create([
            'name' => $request->input('name_department'),
            'user_id' => Auth::id(),
            'parent_id' => $request->input('value_name_department')
        ]);
        if ($createDepartment) {
            return redirect()->route('web.departments.list')->with('message', 'Bạn đã thêm phòng ban thành công');
        } else {
            return redirect()->route('web.departments.list')->with('error', 'Bạn đã thêm phòng ban thất bại');
        }
    }

    public function show(Request $request)
    {
        $listPermissions = Permission::all();

        $currentUser = Auth::user();

        if ($currentUser->parent_id) {
            $userId = $currentUser->parent()->first('id')->id;
        } else {
            $userId = $currentUser->id;
        }

        if ($request->search) {
            $query = Department::with('user')->where('name', 'LIKE', "%{$request->search}%")
                ->whereRaw('(user_id = ' . $userId . ' OR user_id = ' . $currentUser->id . ')');
        } else {
            $query = Department::with('user')->whereRaw('(user_id = ' . $userId . ' OR user_id = ' . $currentUser->id . ')');
        }

        if ($request->status == config('statuses.trash')) {
            $listDepartmentLevel = $query->onlyTrashed()->get();
        } else {
            $listDepartment = $query->get();
            $listDepartmentLevel = data_tree($listDepartment, null);
        }
        $activeDepartment = $this->departmentAction->activeDepartmentResponsive($request);
        return view('dashboard.department.list', compact('listDepartmentLevel', 'listPermissions', 'activeDepartment'));
    }

    public function edit(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->parent_id) {
            $userId = $currentUser->parent()->first('id')->id;
        } else {
            $userId = $currentUser->id;
        }

        $id = $request->input('id');
        $departmentEdit = Department::find($id);
        $listDepartment = Department::whereRaw('(user_id = ' . $userId . ' OR user_id = ' . $currentUser->id . ')')
            ->where('id', '!=', $id)->get();
        $listDepartmentLevel = data_tree($listDepartment, null);

        return view('dashboard.department.edit_ajax', compact('listDepartmentLevel', 'departmentEdit'));
    }

    public function update(ValidateDepartmentRequest $request, $id)
    {
        $isSuccess = Department::find($id)->update([
            'name' => $request->input('name_department'),
            'parent_id' => $request->input('value_name_department'),
        ]);
        if ($isSuccess) {
            return redirect()->route('web.departments.list')->with('message', 'Bạn đã cập nhật phòng ban thành công');
        } else {
            return redirect()->route('web.departments.list')->with('error', 'Bạn cập nhật thêm phòng ban thất bại');
        }
    }

    public function delete($id)
    {
        $isDeleteDepartment = Department::find($id)->delete();
        if ($isDeleteDepartment) {
            return redirect()->route('web.departments.list')->with('message', 'Bạn đã xoá phòng ban thành công');
        } else {
            return redirect()->route('web.departments.list')->with('error', 'Bạn đã xoá  phòng ban thất bại');
        }
    }

    public function restore(Request $request, $id)
    {
        $isRestoreDepartment = Department::withTrashed()->where('id', $id)->restore();
        if ($isRestoreDepartment) {
            return redirect()->route('web.departments.list')->with('message', 'Bạn đã khôi phục phòng ban thành công');
        } else {
            return redirect()->route('web.departments.list')->with('error', 'Bạn đã khôi phục phòng ban thất bại');
        }
    }

    public function faceDelete(Request $request, $id)
    {
        $isFaceDeleteDepartment = Department::withTrashed()->where('id', $id)->forceDelete();
        if ($isFaceDeleteDepartment) {
            return redirect()->route('web.departments.list')->with('message', 'Bạn đã xoá vĩnh viễn phòng ban thành công');
        } else {
            return redirect()->route('web.departments.list')->with('error', 'Bạn đã xoá vĩnh viễn phòng ban thất bại');
        }
    }

    public function showTree()
    {
        $listDepartment = Department::where('parent_id', null)->get();

        return view('dashboard.department.tree', compact('listDepartment'));
    }

    public function treeChild(Request $request)
    {
        $id = $request->input('id');
        $departmentParent = Department::find($id);
        $listDepartment = Department::where('parent_id', null)->get();

        return view('dashboard.department.tree_ajax', compact('departmentParent', 'listDepartment', 'id'));
    }

    public function updatePermissionDepartment(Request $request, $id)
    {
        $department = $this->departmentAction->findById($id);
        if (!$department) {
            Session::flash('error_message', 'Phòng ban không tồn tại vui lòng thử lại');
            return redirect()->route('web.departments.list');
        }

        if ($request->checkedPermissions && count($request->checkedPermissions)) {
            $department->permissions()->sync($request->checkedPermissions);
        }

        Session::flash('message', 'Phân quyền thành công');
        return redirect()->route('web.departments.list');
    }
}
