<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class CustomersImport implements ToModel, WithStartRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $randomNumber = rand(0, 99999);
        $styleNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
        $customerCodeRandom = 'ONESIGN-' . $styleNumber;

        return new Customer([
            'customer_code' => $customerCodeRandom,
            'name' => $row[1],
            'tax_code' => $row[2],
            'name_company' => $row[3],
            'address' => $row[4],
            'account_number' => $row[5],
            'name_bank' => $row[6],
            'payments' => $row[7],
            'customer_type' => $row[8],
            'phone_number' => $row[9],
            'email' => $row[10],
            'created_at' => now(),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.1' => ['required', 'unique:customers,name'],
            '*.4' => ['required'],
            '*.9' => ['required', 'unique:customers,phone_number', 'numeric', 'max:10'],
            '*.10' => ['required', 'email', 'unique:customers,email'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.1.required' => 'Cột dữ liện Tên không được để trống',
            '*.1.unique' => 'Cột dữ liện Tên bị trùng',

            '*.4.required' => 'Cột dữ liện Địa chỉ không được để trống',

            '*.9.required' => 'Cột dữ liện Số điên thoại không được để trống',
            '*.9.unique' => 'Cột dữ liện Số điên thoại bị trùng',
            '*.9.numeric' => 'Cột dữ liện Số điên thoại phải là số',
            '*.9.max' => 'Cột dữ liện Số điên thoại giới hạn 10 chữ số',

            '*.10.required' => 'Cột dữ liện Email không được để trống',
            '*.10.unique' => 'Cột dữ liện Email bị trùng',
            '*.10.email' => 'Cột dữ liện Email bị sai định dạng email',
        ];
    }
}
