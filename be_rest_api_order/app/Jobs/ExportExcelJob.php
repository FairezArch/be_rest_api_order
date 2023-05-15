<?php

namespace App\Jobs;

use App\Exports\OrdersExport;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ExportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //
        $file = 'excel_order.xlsx';
        $export = new OrdersExport;
        $filePath = Excel::store($export, $file, 'public');
        $fileContents = Storage::disk('public')->get($filePath);

        return response($fileContents)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="users.xlsx"');
        // $orders = Order::all();
        // $excel = Excel::download(new OrdersExport($orders), $file);
        // Storage::put('public/excel/'.$file, $excel);
    }
}
