<?php

namespace App\Http\Middleware;

use App\Http\Actions\PermissionAction;
use App\Models\UserType;
use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionContract
{
    private $permissionAction;

    public function __construct(PermissionAction $permissionAction)
    {
        $this->permissionAction = $permissionAction;
    }

    public function handle($request, Closure $next)
    {
        $currentUser = Auth::user();
        $userType = $currentUser->userType;
        if ($currentUser->parent_id) {
            $middleWares = $this->permissionAction->getMiddleWare($request);
            if (!count($middleWares)) {
                if (!$userType || $userType->key_word != UserType::TYPE_PAID || $currentUser->valid_to < now()) {
                    return redirect()->route('web.subscription');
                }
                return $next($request);
            }
            $permissions = $this->permissionAction->findPermissionsViaUser($middleWares);
            if ($permissions) {
                if (!$userType || $userType->key_word != UserType::TYPE_PAID || $currentUser->valid_to < now()) {
                    return redirect()->route('web.subscription');
                }

                return $next($request);
            }
            if (!$userType || $userType->key_word != UserType::TYPE_PAID || $currentUser->valid_to < now()) {
                return redirect()->route('web.subscription');
            }
            return $next($request);
        } else {
            if (!$userType || $userType->key_word != UserType::TYPE_PAID || $currentUser->valid_to < now()) {
                return redirect()->route('web.subscription');
            }
        }
        return $next($request);
    }
}
