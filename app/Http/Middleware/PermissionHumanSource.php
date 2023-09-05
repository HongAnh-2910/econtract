<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class PermissionHumanSource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUser = Auth::user();
        if ($currentUser->parent_id) {
            Session::flash('error_message', 'Tài khoản không có quyền truy cập vào quản lý nhân sự');

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
