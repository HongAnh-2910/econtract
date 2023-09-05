<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    public function collection()
    {
        return Customer::all();
    }

    public function map($customer): array
    {
        return [
            $customer->customer_code,
            $customer->name,
            $customer->tax_code,
            $customer->name_company,
            $customer->address,
            $customer->account_number,
            $customer->name_bank,
            $customer->payments,
            $customer->customer_type,
            $customer->phone_number,
            $customer->email,
            date('d/m/Y', strtotime($customer->created_at)),
        ];
    }

    public function headings(): array
    {
        return [
            'Mã khách hàng',
            'Tên khách hàng',
            'Mã số thuế',
            'Tên công ty',
            'Địa chỉ',
            'Số tài khoản',
            'Tên ngân hàng',
            'Hình thức thanh toán',
            'Loại khách hàng',
            'Số điện thoại',
            'Email',
            'Ngày tạo'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}
