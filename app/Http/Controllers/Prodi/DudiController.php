<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Master\Dudi;
use App\Utils\FlashMessageHelper;
use App\Utils\UploadFileHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DudiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (request()->has('deleted')) {
                $query = Dudi::onlyTrashed()->where('prodi_id', auth()->user()->prodi_id);
            } else {
                $query = Dudi::where('prodi_id', auth()->user()->prodi_id);
            }
            // $query = $query->where('created_by', auth()->user()->id);
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('prodi.dudi.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('mou', function ($obj) {
                    if ($obj->has_mou == "1") {
                        return '<a class="btn btn-sm btn-success btn-preview_pdf" href="' . asset($obj->mou) . '" data-toggle="tooltip" data-placement="top" title="Lihat MOU"><i class="fa fa-eye"></i></a>';
                    } else {
                        return "-";
                    }
                })
                ->rawColumns(['action', 'mou'])
                ->make(true);
        }

        $data['model'] = get_class(new Dudi());
        return view('prodi.pages.dudi.index', compact('data'));
    }

    public function create()
    {
        return view('prodi.pages.dudi.create');
    }

    public function store(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'name' => 'required',
                'field' => 'required',
                'address' => 'required',
                'director_name' => 'required',
                'cp_name' => 'required',
                'website' => 'required',
                'has_mou' => 'nullable',
                'mou' => [Rule::requiredIf(function () use ($request) {
                    return $request->has('has_mou');
                }), 'mimes:pdf', 'max:2048'],
            ],
            [
                'mimes' => ':attribute harus bertipe : pdf'
            ],
            [
                'name' => 'nama',
                'field' => 'Bidang',
                'address' => 'Alamat',
                'director_name' => 'Direktur',
                'cp_name' => 'CP',
                'mou' => 'MOU',
            ]
        );

        DB::beginTransaction();
        $dudi = Dudi::create([
            'name' => $request->name,
            'field' => $request->field,
            'address' => $request->field,
            'director_name' => $request->director_name,
            'prodi_id' => auth()->user()->prodi_id,
            'cp_name' => $request->cp_name,
            'website' => $request->website,
            'has_mou' => $request->has('has_mou')
        ]);

        if ($request->has('mou')) {
            $upload_proposal = UploadFileHelper::upload($request->file('mou'), 'assets/uploads/' . date("Y") . '/files/mou', $dudi->id . '-mou');
            $dudi->mou = $upload_proposal['path'];
            $dudi->save();
        }

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil menambahkan proposal');
        return redirect(route('prodi.dudi.show', ['id' => $dudi->id]));
    }

    public function show($id)
    {
        $data['obj'] = Dudi::withTrashed()->findOrFail($id);
        return view('prodi.pages.dudi.show', compact('data'));
    }

    public function delete(Request $request)
    {
        $download = Dudi::findOrFail($request->id);
        $download->delete();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menghapus dudi!",
            'Berhasil'
        );
        return back();
    }

    public function restore(Request $request)
    {
        $download = Dudi::withTrashed()->findOrFail($request->id);
        $download->restore();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengembalikan dudi!",
            'Berhasil'
        );
        return back();
    }

    public function edit($id)
    {
        $data['obj'] = Dudi::withTrashed()->findOrFail($id);
        return view('prodi.pages.dudi.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $dudi = Dudi::withTrashed()->findOrFail($id);
        ValidationHelper::validate(
            $request,
            [
                'name' => 'required',
                'field' => 'required',
                'address' => 'required',
                'director_name' => 'required',
                'cp_name' => 'required',
                'website' => 'required',
                'has_mou' => 'nullable',
                'mou' => [Rule::requiredIf(function () use ($request) {
                    return $request->has('has_mou');
                }), 'mimes:pdf', 'max:2048'],
            ],
            [
                'mimes' => ':attribute harus bertipe : pdf'
            ],
            [
                'name' => 'nama',
                'field' => 'Bidang',
                'address' => 'Alamat',
                'director_name' => 'Direktur',
                'cp_name' => 'CP',
                'mou' => 'MOU',
            ]
        );

        DB::beginTransaction();
        $updatedData = [
            'name' => $request->name,
            'field' => $request->field,
            'address' => $request->field,
            'director_name' => $request->director_name,
            'cp_name' => $request->cp_name,
            'website' => $request->website,
            'has_mou' => $request->has('has_mou')
        ];

        if ($request->has('mou')) {
            $upload_proposal = UploadFileHelper::upload($request->file('mou'), 'assets/uploads/' . date("Y") . '/files/mou', $id . '-mou');
            $updatedData['mou'] = $upload_proposal['path'];
        } else {
            $updatedData['mou'] = "";
        }

        Dudi::withTrashed()->find($id)->update($updatedData);

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil merubah proposal');
        return redirect(route('prodi.dudi.show', ['id' => $dudi->id]));
    }
}
