<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ASMReportExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($fromDate, $toDate, $serviceCenter)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->serviceCenter = $serviceCenter;
    }

    public function collection()
    {
        $query =  DB::table('tools_services')
        ->leftJoin('factory_service_centers', 'tools_services.service_center', '=', 'factory_service_centers.fsc_slug')
        ->leftJoin('employees', 'tools_services.repairer', '=', 'employees.employee_slug')
        ->leftJoin('warranty_registrations', 'tools_services.tools_sl_no', '=', 'warranty_registrations.machine_serial_number')
        ->select(
            'tools_services.trn',
            'tools_services.sr_date',
            'tools_services.delear_customer_name',
            'tools_services.contact_number',
            'tools_services.model',
            'tools_services.receive_date_time',
            'tools_services.estimation_date_time',
            'tools_services.duration_a_b',
            'tools_services.est_date_confirm_cx',
            'tools_services.repair_complete_date_time',
            'tools_services.duration_c_d',
            'tools_services.handover_date_time',
            'tools_services.status',
            'tools_services.total_hour_for_repair',
            'tools_services.cost_estimation',
            'tools_services.repair_parts_details',
            'tools_services.reason_for_over_48h',
            'tools_services.part_number_reason_for_delay',
            'factory_service_centers.center_name',
            'employees.full_name',
            'warranty_registrations.warranty_expiry_date',
            'warranty_registrations.invoice_number'
        )
        ->whereDate('tools_services.sr_date', '>=', $this->fromDate)
        ->whereDate('tools_services.sr_date', '<=', $this->toDate)
        ->orderBy('tools_services.created_at', 'asc');
        if ($this->serviceCenter !=26) {
            $query->where('tools_services.service_center', '=', $this->serviceCenter);
        }
        return $query->get();
    }
    public function headings(): array
    {
        return [
            'TRN(To Estimation)',
            'Date',
            'Month',
            'Name of The Branch',
            'Repairer',
            'Delar Name/Customer Name',
            'Contact Number',
            'Model',
            'Received Date(A)',
            'Estimation Date(B)',
            'Duration A to B',
            'Estimation Date(Confirmed by customer)',
            'Repair Complete Date(D)',
            'Duration C to D',
            'Handover Date',
            'Status',
            'Total Hour for Repair',
            'Within 48 Hours',
            'Invoice Number',
            'RS.',
            'Waranty (Yes/No)',
            'Repair Parts Details',
            'Reson Over 48 Hours (Details are required)',
            'Part Number if it is the Reason for Delay',
        ];
    }
    public function map($reference): array
    {
        $status = match ($reference->status) {
            0 => 'Under-Diagnosing',
            1 => 'Repairer Assigned',
            2 => 'Estimation Shared',
            3 => 'Estimation Approved By You',
            4 => 'Estimation Rejected By You',
            5 => 'Repair Completed yet to deliverd',
            6 => 'Deliverd',
            7 => 'Closed',
            default => 'Contact Admin',
        };
        $invoiceNumber='';

        return [
            $reference->trn,
            Carbon::parse($reference->sr_date)->format('d-M-Y'),
            Carbon::parse($reference->sr_date)->format('m'),
            $reference->center_name,
            $reference->full_name,
            $reference->delear_customer_name,
            $reference->contact_number,
            $reference->model,
            Carbon::parse($reference->receive_date_time)->format('d M Y'),
            Carbon::parse($reference->estimation_date_time)->format('d M Y'),
            intdiv($reference->duration_a_b, 60).':'. ($reference->duration_a_b % 60),
            Carbon::parse($reference->est_date_confirm_cx)->format('d M Y'),
            Carbon::parse($reference->repair_complete_date_time)->format('d M Y'),
            intdiv($reference->duration_c_d, 60).':'. ($reference->duration_c_d % 60),
            Carbon::parse($reference->handover_date_time)->format('d M Y, h:i:s A'),
            $status,
            intdiv($reference->total_hour_for_repair, 60).':'. ($reference->total_hour_for_repair % 60),
            $reference->total_hour_for_repair > (48 * 60) ? 'NG' : 'OK',
            $invoiceNumber,
            $reference->cost_estimation,
            Carbon::parse($reference->warranty_expiry_date)->isFuture() ? 'No' : 'Yes',
            $reference->repair_parts_details,
            $reference->reason_for_over_48h,
            $reference->part_number_reason_for_delay,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell("R$row")->getValue();

            if ($cellValue === 'NG') {
                $sheet->getStyle("R$row")->applyFromArray([
                    'font' => [
                        'color' => ['argb' => Color::COLOR_RED],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF9999',
                        ],
                    ],
                    'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            }else{
                $sheet->getStyle("R$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
                ]);
            }



            $sheet->getStyle("C$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
            ]);

            $sheet->getStyle("D$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
            ]);


            $sheet->getStyle("K$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
            ]);

            $sheet->getStyle("N$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
            ]);

            $sheet->getStyle("P$row")->applyFromArray([
                'font' => [
                        'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
            ]);


            $cellValue = $sheet->getCell("Q$row")->getValue(); // Adjust column as necessary
            if ($cellValue > 48) {
                $sheet->getStyle("Q$row")->applyFromArray([
                    'font' => [
                        'color' => ['argb' => Color::COLOR_RED],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FF9999', // Red background color
                        ],
                    ],
                    'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'], // Black border color
                        ],
                    ],
                ]);
            }else{
                $sheet->getStyle("Q$row")->applyFromArray([
                'font' => [
                    'color' => ['argb' => '002060'],
                ],
                'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFCCCC', // Red background color
                        ],
                    ],
                'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black border color
                       ],
                ],
                ]);
            }
        }



        // Set font style for the entire sheet
            $sheet->getStyle('A1:X1')->applyFromArray([
                'font' => [
                    'name' => 'Calibri',
                    'size' => 12,
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // White text color
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => '008290', // background color
                    ],
                ],
            ]);

            // Apply Comic Sans MS to specific cells if needed
            $sheet->getStyle('A1:Z1')->applyFromArray([
                'font' => [
                    'name' => 'Arial',
                ],
            ]);


        return [];
    }


    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_TIME4,
        ];
    }
}
