<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::select('id', 'status', 'created_at', 'total_price')->get();
    }

    public function headings(): array
    {
        return ['Id', 'Status', 'Order Date', 'Total Price'];
    }
}
