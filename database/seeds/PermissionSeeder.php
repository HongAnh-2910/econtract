<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * @var Permission
     */
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionArray = [
            'permission_documents'   => 'Kho tài liệu',
            'permission_contracts'   => 'Quản lý hợp đồng',
            'permission_customers'   => 'Quản lý khách hàng',
            'permission_departments' => 'Quản lý phòng ban',
            'permission_members'     => 'Quản lý thành viên',
            'permission_letters'     => 'Đơn từ'
        ];
        foreach ($permissionArray as $key => $value) {
            $checkExist = $this->permission::where('permission_alias' , '=', $key)->count();
            if(! $checkExist)
            {
                $permission                   = new Permission();
                $permission->name             = $value;
                $permission->permission_alias = $key;
                $permission->created_at       = now();
                $permission->updated_at       = now();
                $permission->save();
            }
        }
    }
}
