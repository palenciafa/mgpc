<?php

namespace App\Exports;

use App\Models\StockLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockLogsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return StockLog::with(['product', 'user', 'supplier'])
            ->get()
            ->map(function($log) {
                return [
                    'Product'   => $log->product->name ?? 'N/A',
                    'Type'      => strtoupper($log->type),
                    'Quantity'  => $log->quantity,
                    'Price'     => $log->type === 'in' ? $log->buying_price : $log->total_price,
                    'Supplier'  => $log->supplier->name ?? 'N/A',
                    'Created At'=> $log->created_at->format('Y-m-d H:i'),
                    'Created By'=> $log->user->name ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return ['Product', 'Type', 'Quantity', 'Price', 'Supplier', 'Created At', 'Created By'];
    }
}
