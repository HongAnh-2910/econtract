<?php

use Illuminate\Database\Seeder;

class PermissionUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \App\Models\Permission::whereIn('permission_alias', ['permission_departments', 'permission_members'])->get();

        /** @var \App\Models\Permission $permission */
        foreach($permissions as $permission) {
            $permission->delete();
        }
    }
}
