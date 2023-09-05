<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionAliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionArray = [
            'permission_documents'   => 'permission.documents',
            'permission_contracts'   => 'permission.contracts',
            'permission_customers'   => 'permission.customers',
            'permission_departments' => 'permission.departments',
            'permission_members'     => 'permission.members',
            'permission_letters'     => 'permission.letters'
        ];

        foreach ($permissionArray as $key => $value) {
            DB::table('permission')->where('permission_alias', $key)->update(['permission_alias' => $value]);
        }
    }
}
