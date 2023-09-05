<?php

namespace App\Exports;

use App\Models\HumanResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HrmExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    public function collection()
    {
        return HumanResource::with('user', 'department')->get();
    }

    public function map($hrm): array
    {
        return [
            $hrm->user->name,
            $hrm->gender,
            $hrm->phone_number,
            $hrm->user->email,
            date('d/m/Y', strtotime($hrm->date_start)),
            $hrm->department->name,
            $hrm->form,
            date('d/m/Y', strtotime($hrm->date_of_birth)),
            $hrm->passport,
            date('d/m/Y', strtotime($hrm->date_range)),
            $hrm->place_range,
            $hrm->permanent_address,
            $hrm->current_address,
            $hrm->account_number,
            $hrm->account_name,
            $hrm->name_bank,
            $hrm->motorcycle_license_plate
        ];
    }

    public function headings(): array
    {
        return [
            'Họ và tên',
            'Giới tính',
            'Số điện thoại',
            'Email',
            'Ngày bắt đầu',
            'Phòng ban',
            'Hình thức',
            'Sinh ngày',
            'Số CMND/Hộ chiếu',
            'Ngày cấp',
            'Nơi cấp',
            'Địa chỉ thường trú',
            'Địa chỉ hiện tại',
            'Số tài khoản',
            'Tên tài khoản',
            'Tên ngân hàng',
            'Biển số xe'
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
