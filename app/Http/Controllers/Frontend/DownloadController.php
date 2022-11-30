<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Download;

class DownloadController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Download::query();
            $returnData = datatables()->of($query)
                ->editColumn('name', function ($d) {
                    return '
                    <div class="d-flex">
                    <p class="font-weight-bold">' . $d->name . '</p>
                    <a class="ml-auto" href="' . asset($d->path) . '" download=""><i class="fas fa-file-download mr-1"></i> Download</a>
                    </div>

                    ';
                })
                ->rawColumns(['name']);
            return  $returnData->make(true);
        }
        return view('frontend.download');
    }

}
