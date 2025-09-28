<?php

namespace App\Exports;

use App\Models\StockLog;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class StockLogsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    public function collection()
    {
        return StockLog::with(['product', 'user', 'supplier'])
            ->get()
            ->map(function($log) {
                $customer = 'N/A';

                if ($log->type === 'out') {
                    $sale = Sale::where('product_id', $log->product_id)
                        ->where('quantity', $log->quantity)
                        ->whereDate('created_at', $log->created_at->toDateString())
                        ->first();

                    $customer = $sale->customer_name ?? 'N/A';
                }

                return [
                    'Product'     => $log->product->name ?? 'N/A',
                    'Type'        => strtoupper($log->type),
                    'Quantity'    => $log->quantity,
                    'Price'       => $log->type === 'in' ? $log->buying_price : $log->total_price,
                    'Supplier'    => $log->supplier->name ?? 'N/A',
                    'Customer'    => $customer,
                    'Created At'  => $log->created_at->format('Y-m-d H:i'),
                    'Created By'  => $log->user->name ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return ['Product', 'Type', 'Quantity', 'Price', 'Supplier', 'Customer', 'Created At', 'Created By'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Header row
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'] // Blue header background
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Find the last row of data
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Apply borders & alignment to all cells
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
