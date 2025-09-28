<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StockLogsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        $collection = collect();

        // Add stock logs
        foreach ($this->logs as $log) {
            $supplierCustomer = $log->type === 'in'
                ? ($log->supplier->name ?? 'N/A')
                : ($log->sale->customer_name ?? 'N/A');

            $price = $log->type === 'in' ? $log->buying_price : $log->total_price;

            $collection->push([
                'Product' => $log->product->name ?? 'N/A',
                'Type' => strtoupper($log->type),
                'Quantity' => $log->quantity,
                'Price' => $price,
                'Supplier/Customer' => $supplierCustomer,
                'Created At' => $log->created_at->format('Y-m-d H:i'),
                'Created By' => $log->user->name ?? 'N/A',
            ]);
        }

        // Compute totals dynamically
        $totalPurchase = $this->logs->where('type', 'in')->sum('buying_price');
        $totalSale = $this->logs->where('type', 'out')->sum('total_price');

        if ($totalPurchase > 0) {
            $collection->push([
                'Product' => 'Total Purchase (IN)',
                'Type' => '',
                'Quantity' => '',
                'Price' => $totalPurchase,
                'Supplier/Customer' => '',
                'Created At' => '',
                'Created By' => '',
            ]);
        }

        if ($totalSale > 0) {
            $collection->push([
                'Product' => 'Total Sale (OUT)',
                'Type' => '',
                'Quantity' => '',
                'Price' => $totalSale,
                'Supplier/Customer' => '',
                'Created At' => '',
                'Created By' => '',
            ]);
        }

        // Profit only if both IN and OUT exist
        if ($totalPurchase > 0 && $totalSale > 0) {
            $profit = $totalSale - $totalPurchase;
            $collection->push([
                'Product' => 'Profit',
                'Type' => '',
                'Quantity' => '',
                'Price' => $profit,
                'Supplier/Customer' => '',
                'Created At' => '',
                'Created By' => '',
            ]);
        }

        return $collection;
    }

    public function headings(): array
    {
        return ['Product', 'Type', 'Quantity', 'Price (₱)', 'Supplier/Customer', 'Created At', 'Created By'];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => '"₱"#,##0.00',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Header styling
                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                ]);

                // Borders and alignment for all cells
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
            },
        ];
    }
}
