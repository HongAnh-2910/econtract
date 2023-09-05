<?php

namespace App\Imports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ApplicationsImport implements ToModel, WithStartRow, SkipsOnError, SkipsOnFailure, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        $randomNumber = rand(0, 99999);
        $styleNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
        $applicationCodeRandom = 'ONESIGN-' . $styleNumber;

        return new Application([
            'code' => $applicationCodeRandom,
            'name' => $row[1],
            'status' => 'Chờ duyệt',
            'reason' => $row[3],
            'application_type' => $row[4],
            // 'department_id'     => $row[5],
            // 'position'          => $row[6],
            'description' => $row[7],
            // 'user_id '          => $row[8],
            'created_at' => now(),
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '*.1' => ['required', 'unique:applications,name'],
            '*.3' => ['required'],
            '*.4' => ['required'],
            '*.7' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.1.required' => 'Cột dữ liện Tên không được để trống',
            '*.1.unique' => 'Cột dữ liện Tên bị trùng',
            '*.4.required' => 'Cột dữ liện Địa chỉ không được để trống',
            '*.9.required' => 'Cột dữ liện Số điên thoại không được để trống',
            '*.10.required' => 'Cột dữ liện Email không được để trống',
        ];
    }
}
