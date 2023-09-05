<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ApplicationsForThoughtExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Application::with('user', 'dateTimeOfApplications')->get();
    }

    public function map($application): array
    {
        if ($application->application_type == 'Đơn xin nghỉ') {
            $informationDays = $application->dateTimeOfApplications;
            $countDay = 0;
            foreach ($informationDays as $informationDay) {
                $to_date = Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_2);
                $from_date = Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_4);
                $countDay += $to_date->diffInDays($from_date);
            }

            if ($application->user == null) {
                return [
                    $application->code,
                    $application->name,
                    $application->status,
                    $application->reason,
                    $application->application_type,
                    $application->department_id,
                    $application->position,
                    strip_tags("$application->description"),
                    '',
                    $application->created_at,
                    $countDay . ' Ngày',
                ];
            } else {
                return [
                    $application->code,
                    $application->name,
                    $application->status,
                    $application->reason,
                    $application->application_type,
                    $application->department_id,
                    $application->position,
                    strip_tags("$application->description"),
                    $application->user->name,
                    $application->created_at,
                    $countDay . ' Ngày',
                ];
            }
        } else {
            return [''];
        }
    }

    public function headings(): array
    {
        return [
            'Mã khách hàng',
            'Tên khách hàng',
            'Trạng thái',
            'Lý do',
            'Loại đơn từ',
            'Phòng ban',
            'Vị trí',
            'Mô tả',
            'Người duyệt',
            'Ngày tạo',
            'Số ngày',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
