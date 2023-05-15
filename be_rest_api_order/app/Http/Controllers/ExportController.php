<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Jobs\ExportExcelJob;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    //
    public function export()
    {
        $file = 'excel_order.xlsx';

        if (Storage::exists('public/'.$file)) {
            Storage::delete('public/'.$file);
        }

        dispatch(new ExportExcelJob);

        $fileUrl = Storage::url('public/'.$file);
        return response()->json(['file_url' => url($fileUrl)]);
    }
}
