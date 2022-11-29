<?php

namespace App\Exports;

use App\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Carbon;

class AttendanceExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date+86400;
    }

    public function collection()
    {
        $attendance = new Attendance;
        return $attendance->join('users', 'users.id', '=', 'attendances.user_id')
            ->where('attendances.entry_date', '>=', $this->start_date)
            ->where('attendances.entry_date', '<=', $this->end_date)
            ->select('users.name', 'attendances.entry_date', 'attendances.category', 'attendances.note')
            ->latest('attendances.entry_date')->get();
    }

    public function map($row): array
    {
        switch($row->category){
            case 1:
                $category = "Work from Office";
                break;
            case 2:
                $category = "Work from Home";
                break;
            case 3:
                $category = "Rapat/Dinas";
                break;
            case 4:
                $category = "Cuti/Tidak Masuk";
                break;
            default:
                $category = null;
                break;
        }
        $entry_date = date('Y-m-d H:i:s', $row->entry_date);
        return [
            $row->name,
            $category,
            $entry_date,
            $row->note,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kategori',
            'Tanggal',
            'Keterangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:L1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ]
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
