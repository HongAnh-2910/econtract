<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionAction
{
    const WEB = 'web';
    const AUTH = 'auth';

    public function getMiddleWare(Request $request)
    {
        $middleWares = $request->route()->action['middleware'] ?? [];

        $this->removeBaseMiddleWare($middleWares, self::WEB);
        $this->removeBaseMiddleWare($middleWares, self::AUTH);

        return $middleWares;
    }

    private function removeBaseMiddleWare($arrayMiddleWares, $value)
    {
        if (($key = array_search($value, $arrayMiddleWares)) !== false) {
            unset($arrayMiddleWares[$key]);
        }
    }

    public function findPermissionsViaUser($middleWares)
    {
        $user = Auth::user();
        return $user->departments()
            ->join('permission_department', 'permission_department.department_id', 'departments.id')
            ->join('permission', 'permission_department.permission_id', 'permission.id')
            ->whereIn('permission.permission_alias', $middleWares)
            ->count('permission.id');
    }

    public static function getAllPermissionsViaUser()
    {
        $user = Auth::user();
        return $user->departments()
            ->join('permission_department', 'permission_department.department_id', 'departments.id')
            ->join('permission', 'permission_department.permission_id', 'permission.id')
            ->pluck('permission.permission_alias')->toArray();
    }
}
