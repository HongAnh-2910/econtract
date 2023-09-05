<?php

namespace App\Http\Middleware;

use App\Http\Actions\PermissionAction;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionCustomer
{
    private $permissionAction;

    public function __construct(PermissionAction $permissionAction)
    {
        $this->permissionAction = $permissionAction;
    }

    public function handle($request, Closure $next)
    {
        $currentUser = Auth::user();
        if ($currentUser->parent_id) {
            $middleWares = $this->permissionAction->getMiddleWare($request);
            if (!count($middleWares)) {
                return $next($request);
            }
            $permissions = $this->permissionAction->findPermissionsViaUser($middleWares);
            if ($permissions) {
                return $next($request);
            }
            Session::flash('error_message', 'Tài khoản không có quyền truy cập vào quản lý khách hàng');
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
