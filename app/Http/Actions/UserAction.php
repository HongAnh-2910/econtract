<?php

namespace App\Http\Actions;


use App\Models\User;
use App\Models\UserType;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAction
{
    use UploadTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function storeChangePass($pass0ld, $password)
    {
        if (Hash::check($pass0ld, Auth::user()->password)) {
            $this->user->where('id', Auth::user()->id)->update([
                'password' => Hash::make($password),
            ]);

            return redirect()->back()->with('message', 'Bạn đã đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('error_message', 'Mật khẩu cũ không trùng khớp');
        }
    }

    public function updateUser($request, $id)
    {
        $userFind = $this->user->find($id);
        if ($request->hasFile('file')) {
            $file = $request->file;
            $this->uploadOneFile($file, 'images/avatar', 'public', $file->getClientOriginalName());
            $this->user->where('id', $id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'img_user' => $file->getClientOriginalName()
            ]);
            if ($request->department) {
                $userFind->departments()->sync($request->department);
            }
        } else {
            $this->user->where('id', $id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'img_user' => $userFind->img_user,
            ]);
            if ($request->department) {
                $userFind->departments()->sync($request->department);
            }
        }
        return redirect()->back()->with('status', 'Bạn đã cập nhật thành viên thành công');
    }

    public function listUser($request)
    {
        if ($request->status == config('statuses.trash')) {
            $listUser = $this->user::onlyTrashed()->where('parent_id', '=', Auth::id())->paginate();
            $listUser->appends(['status' => config('statuses.trash')]);

            return $listUser;
        } else {
            $search = $request->search;
            $listUser = $this->user::where('parent_id', '=', Auth::id());

            if ($search) {
                $listUser = $listUser->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            $listUser = $listUser->orderBy('id', 'DESC')
                ->paginate();

            $listUser->appends(['search' => $search]);

            return $listUser;
        }
    }

    public function checkboxAllUser($request)
    {
        $idUser = $request->input('check_value');
        if ($request->input('status') == 1) {
            $userDelete = $this->user::whereIn('id', $idUser)->delete();
            if ($userDelete) {
                return redirect()->route('web.profile.list')->with('status', 'Bạn đã xoá thành viên thành công');
            } else {
                return redirect()->route('web.profile.list')->with('error', 'Bạn đã xoá thành viên thất bại');
            }
        } elseif ($request->input('status') == 3) {
            $userForce = $this->user::withTrashed()->whereIn('id', $idUser)->forceDelete();
            if ($userForce) {
                return redirect()->route('profile.list')->with('status', 'Bạn xoá vĩnh viễn thành viên thành công');
            } else {
                return redirect()->route('web.profile.list')->with('error', 'Bạn đã xoá vĩnh viễn thành viên thất bại');
            }
        } elseif ($request->input('status') == 2) {
            $userRestore = $this->user::withTrashed()->whereIn('id', $idUser)->restore();
            if ($userRestore) {
                return redirect()->route('web.profile.list')->with('status', 'Bạn đã khôi phục thành viên thành công');
            } else {
                return redirect()->route('web.profile.list')->with('error', 'Bạn đã khôi phục thành viên thất bại');
            }
        }
    }

    public function statusActiveUser($request)
    {
        if ($request->status == 'all') return 0;
        if ($request->status == 'trash') return 1;
    }

    public function createUser($request)
    {
        $user = $this->user->create([
            'name' => $request->input('name_add'),
            'email' => $request->input('email_add'),
            'password' => Hash::make($request->input('password')),
            'parent_id' => Auth::id(),
            'valid_to' => Auth::user()->valid_to,
            'user_type_id' => Auth::user()->user_type_id
        ]);

        $user->departments()->sync($request->input('department_add'));
    }

    public function countStatus($request)
    {
        return $this->user->onlyTrashed()->where('parent_id', Auth::id())->count();
    }

    public function countAll()
    {
        return $this->user->where([
            ['parent_id', null],
            ['id', Auth::id()],
        ])->first()->children->count();
    }

    public function countChildData()
    {
        return $this->user->where('id', '=', Auth::id())->first()->children->count();
    }

    public function search($keyword)
    {
        return $this->user->select("id", "name")->where('name', 'LIKE', "%$keyword%")
            ->get();
    }

    public function searchWithoutUserId($keyword, User $user)
    {
        if ($user->parent()->count()) {
            return $this->user->select("id", "name", "email")
                ->where('name', 'LIKE', "%$keyword%")
                ->where(function ($qb) use ($user) {
                    $qb->where('parent_id', '=', $user->parent_id)
                        ->orWhere('id', '=', $user->parent_id);
                })->withoutId($user->id)->get();
        } else {
            return $this->user->select("id", "name", "email")
                ->where('name', 'LIKE', "%$keyword%")
                ->where('parent_id', '=', $user->id)
                ->withoutId($user->id)
                ->get();
        }
    }

    function extendUserSubscription(User $user, UserType $type)
    {
        $user->user_type_id = $type->id;
        $user->valid_to = date('Y-m-d H:i:s', strtotime('+1 months'));
        $user->save();
    }
}
