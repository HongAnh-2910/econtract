<?php

namespace App\Http\Actions;

use App\Models\Department;

class DepartmentAction
{
    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function createDepartment($request)
    {
        $this->department->create($request);;
    }

    public function updateDepartment($request, $id)
    {
        $this->department->where('id', $id)->update($request);
    }

    public function findById($id)
    {
        return $this->department::find($id);
    }

    public function activeDepartmentResponsive($request)
    {
        if ($request->status == "trash")
            return $activeDepartment = 1;
    }
}