<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Download;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('deleted')) {
                $query = Download::onlyTrashed();
            } else {
                $query = Download::query();
            }
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.master.download.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('name', function ($obj) {
                    return '<a href="' . asset($obj->path) . '" download><i class="fa fa-download"></i> ' . $obj->name . '</a>';
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        $data['model'] = get_class(new Download);
        return view('admin.pages.master.download.index', compact('data'));
    }

    public function createGet()
    {
        return view('admin.pages.master.download.create');
    }

    public function createPost(Request $request)
    {

        $validate = ValidationHelper::validate(
            $request,
            [
                'name' => 'required|string',
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc|max:2048'
            ],
            [
                'file.mimes' => ':attribute harus bertipe : jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc'
            ],
            [
                'name' => 'Nama File',
                'file' => 'File'
            ]
        );

        if ($validate->fails()) {
            return ValidationHelper::validationError($validate);
        }

        DB::beginTransaction();
        $download = Download::create([
            'name' => $request->name,
        ]);


        $file = $request->file('file');
        $file->move('assets/uploads/' . date("Y") . '/files/download', $download->id .  '-' . $file->getClientOriginalName());
        $download->path = 'assets/uploads/' . date("Y") . '/files/download' . '/' . $download->id .  '-' . $file->getClientOriginalName();
        $download->save();


        DB::commit();
        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menambahkan pengumuman!",
            'Berhasil'
        );
        return redirect(route('admin.master.download.show', ['id' => $download->id]));
    }

    public function show($id)
    {
        $data['obj'] = Download::withTrashed()->findOrFail($id);
        return view('admin.pages.master.download.show', compact('data'));
    }

    public function delete(Request $request)
    {
        $download = Download::findOrFail($request->id);
        $download->delete();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menghapus $download->name!",
            'Berhasil'
        );
        return back();
    }

    public function restore(Request $request)
    {
        $download = Download::withTrashed()->findOrFail($request->id);
        $download->restore();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengembalikan $download->name!",
            'Berhasil'
        );
        return back();
    }

    public function edit($id)
    {
        $data['obj'] = Download::findOrFail($id);
        return view('admin.pages.master.download.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'name' => 'required|string',
                'file' => 'mimes:jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc|max:2048'
            ],
            [
                'file.mimes' => ':attribute harus bertipe : jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc'
            ],
            [
                'name' => 'Nama File',
                'file' => 'File'
            ]
        );

        if ($validate->fails()) {
            return ValidationHelper::validationError($validate);
        }

        DB::beginTransaction();
        $download = Download::findOrFail($id);
        $download->name = $request->name;

        if ($request->has('file')) {
            $file = $request->file('file');
            $file->move('assets/uploads/' . date("Y") . '/files/download', $download->id .  '-' . $file->getClientOriginalName());
            $download->path = 'assets/uploads/' . date("Y") . '/files/download' . '/' . $download->id .  '-' . $file->getClientOriginalName();
        }
        $download->save();

        DB::commit();
        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengubah pengumuman!",
            "Berhasil"
        );
        return redirect(route('admin.master.download.show', ['id' => $download->id]));
    }
}
