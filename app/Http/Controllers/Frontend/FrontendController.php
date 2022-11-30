<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Announcement;
use App\Models\Master\Download;
use App\Models\Master\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        // $data['sliders'] = Sliders::all();
        $data['slider'] = Slider::all();
        return view('frontend.home',compact('data'));
    }

    public function pengumuman()
    {
        if (request()->ajax()) {
            $query = Announcement::query();
            $returnData = datatables()->of($query)
                ->editColumn('title', function ($d) {
                    $body = strip_tags($d->body);
                    $body = strlen($body) >= 100 ? substr($body, 100) . '...' : $body;
                    return '
                            <a href="#" data-toggle="modal" class="btn-detail_announcement" data-id="' . $d->id . '" data-target="#staticBackdrop"
                                class="judul-pengumuman">' . $d->title . '</a>
                            <p>' . $body . '</p>
                    ';
                })
                ->rawColumns(['title']);

            return  $returnData->make(true);
        }
        return view('frontend.pengumuman');
    }

    public function getDetailPengumuman($id)
    {
        if (!$id) {
            return response()->json([
                'status' => 'Failed',
                'code' => 400,
                'message' => 'Data tidak ditemukan.'
            ]);
        }
        $annoucnement = Announcement::find($id);
        if (!$annoucnement) {
            return response()->json([
                'status' => 'Failed',
                'code' => 400,
                'message' => 'Data tidak ditemukan.'
            ]);
        }
        $annoucnement['attachments'] = $annoucnement->attachments;
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => $annoucnement
        ]);
    }

    public function download()
    {
        if (request()->ajax()) {
            $query = Download::query();
            $returnData = datatables()->of($query)
                ->editColumn('name', function ($d) {
                    return '
                    <div class="d-flex">
                    <p class="font-weight-bold">' . $d->name . '</p>
                    <a class="ml-auto" href="' . asset($d->path) . '" download><i class="fas fa-file-download mr-1"></i>Download</a>
                    </div>
                    ';
                })
                ->rawColumns(['name']);
            return  $returnData->make(true);
        }
        return view('frontend.download');
    }

    public function kurikulum(){
        return view('frontend.kurikulum');
    }

    public function alur(){
        return view('frontend.alur');
    }
}
