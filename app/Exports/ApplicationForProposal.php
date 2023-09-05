<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicationForProposal implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Application::with('user', 'dateTimeOfApplications')->get();
    }

    public function map($application): array
    {
        if ($application->application_type == 'Đơn đề nghị') {
            if ($application->user == null) {
                return [
                    $application->code,
                    $application->name,
                    $application->status,
                    $application->reason,
                    $application->application_type,
                    $application->department_id,
                    $application->position,
                    '',
                    $application->proposal_name,
                    $application->proponent,
                    $application->account_information,
                    'Ngày ' . date('d/m/Y', strtotime($application->delivery_date)) . ' Vào ' . $application->delivery_time
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
                    $application->user->name,
                    $application->proposal_name,
                    $application->proponent,
                    $application->account_information,
                    'Ngày ' . $application->delivery_date . ' Vào ' . $application->delivery_time
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
            'Người duyệt',
            'Tên đề nghị',
            'Người đề nghị',
            'Thông tin tài khoản',
            'Ngày cần hàng'
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
