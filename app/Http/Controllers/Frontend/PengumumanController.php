<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Announcement;

class PengumumanController extends Controller
{
    public function index()
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

}
