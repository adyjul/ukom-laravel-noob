<?php

namespace App\Http\Controllers\Admin\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Master\CategoryProposal;
use App\Models\Master\Proposal;
use App\Models\User;
use App\Utils\FlashMessageHelper;
use App\Utils\UploadFileHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Proposal::query();
            return datatables()->of($query)
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.proposal.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('rps', function ($obj) {
                    return '<a class="btn-preview_pdf btn btn-info btn-rounded" href="' . asset($obj->rps) . '" data-toggle="tooltip" data-placement="top" title="Lihat PDF"><i class="fa fa-eye"></i></a>';
                })
                ->editColumn('proposal', function ($obj) {
                    return '<a class="btn-preview_pdf btn btn-info btn-rounded" href="' . asset($obj->proposal) . '" data-toggle="tooltip" data-placement="top" title="Lihat PDF"><i class="fa fa-eye"></i></a>';
                })
                ->editColumn('validation_status', function ($obj) {
                    return Proposal::VALIDATION_STATUS[$obj->validation_status];
                })
                ->editColumn('category_proposal_id', function ($obj) {
                    return $obj->category->name;
                })
                ->editColumn('prodi_id', function ($obj) {
                    return $obj->ProgramStudi->nama_depart;
                })
                ->rawColumns(['action', 'rps', 'proposal'])
                ->make(true);
        }

        $data['model'] = get_class(new Proposal());
        return view('admin.pages.proposal.index');
    }

    public function show($id)
    {
        $data['obj'] = Proposal::withTrashed()->findOrFail($id);
        return view('admin.pages.proposal.show', compact('data'));
    }

    public function edit($id)
    {
        $data['obj'] = Proposal::withTrashed()->findOrFail($id);
        $user = User::withTrashed()->findOrFail($data['obj']->created_by);
        $data['prodi'] = $user->prodi;
        $data['kaprodi'] = $data['prodi']->kaprodi;
        $data['categories'] = CategoryProposal::pluck('name', 'id');
        return view('admin.pages.proposal.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $proposal = Proposal::withTrashed()->findOrFail($id);

        ValidationHelper::validate(
            $request,
            [
                'category' => 'required',
                'dudi_name' => 'required',
                'dudi_field' => 'required',
                'prodi_lecture_name' => 'required',
                'dudi_lecture' => 'required',
                'prodi_instructure_name' => 'required',
                'dudi_instructure_name' => 'required',
                'rps' => 'nullable|mimes:pdf|max:2048',
                'proposal' => 'nullable|mimes:pdf|max:2048',
            ],
            [
                'mimes' => ':attribute harus bertipe : pdf'
            ],
            [
                'category' => 'Kategori',
                'dudi_name' => 'Nama Dudi',
                'dudi_field' => 'Bidang Dudi',
                'prodi_lecture_name' => 'Dosen Prodi',
                'dudi_lecture' => 'Dosen Dudi',
                'prodi_instructure_name' => 'Instruktur Prodi',
                'dudi_instructure_name' => 'Instruktur Dudi',
            ]
        );

        DB::beginTransaction();
        $dudi = [
            'name' => $request->dudi_name,
            'field' => $request->dudi_field,
            'lecture' => $request->dudi_lecture,
            'instructure' => $request->dudi_instructure_name
        ];
        $prodi = [
            'lecture' => $request->prodi_lecture_name,
            'instructure' => $request->prodi_instructure_name
        ];

        Proposal::findOrFail($id)->update([
            'category_proposal_id' => $request->category,
            'dudi' => $dudi,
            'prodi' => $prodi
        ]);

        $proposal = Proposal::findOrFail($id);

        if ($request->has('proposal')) {
            $upload_proposal = UploadFileHelper::upload($request->file('proposal'), 'assets/uploads/' . date("Y") . '/files/proposal', $proposal->id . '-proposal');
            $proposal->proposal = $upload_proposal['path'];
        }
        if ($request->has('proposal')) {
            $upload_rps = UploadFileHelper::upload($request->file('rps'), 'assets/uploads/' . date("Y") . '/files/rps', $proposal->id . '-RPS');
            $proposal->rps = $upload_rps['path'];
        }
        $proposal->save();

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil merubah proposal');
        return redirect(route('admin.proposal.show', ['id' => $proposal->id]));
    }

    public function validation(Request $request)
    {
        // validasi id ada atau tidak
        ValidationHelper::validate($request, ['id' => 'required',]);

        // validation_status required
        ValidationHelper::validate($request, ['validation_status' => 'required']);

        // validasi message harus ada kalau tolak atau reject
        if ($request->validation_status != 4) {
            ValidationHelper::validate(
                $request,
                ['message' => 'required'],
                [],
                [
                    'message' => 'Alasan Validasi',
                ]
            );
            $data['validation_message'] = $request->message;
        }

        DB::beginTransaction();

        $data['validation_status'] = $request->validation_status;
        Proposal::withTrashed()->findOrFail($request->id)->update($data);

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil validasi proposal');
        return redirect(route('admin.proposal.show', ['id' => $request->id]));
    }
}
