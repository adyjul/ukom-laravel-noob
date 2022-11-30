<?php

namespace App\Http\Controllers\Admin\Proposal;

use App\Http\Controllers\Controller;
use App\Models\MAA\ProgramStudi;
use App\Models\Master\CategoryProposal;
use App\Models\Master\Dudi;
use App\Models\Master\Proposal;
use App\Utils\FlashMessageHelper;
use App\Utils\UpdateConfigHelper;
use App\Utils\UploadFileHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (request()->has('deleted')) {
                $query = Proposal::onlyTrashed();
            } else {
                $query = Proposal::query();
            }
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->editColumn('prodi_id', function ($obj) {
                    return $obj->ProgramStudi->nama_depart;
                })
                ->addColumn('action', function ($obj) {
                    return '
                    <a class="btn btn-sm btn-success" href="' . route('admin.proposal.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>
                    ';
                })
                ->editColumn('validation_status', function ($obj) {
                    $status = Proposal::VALIDATION_STATUS[$obj->validation_status];
                    $cek = $status == 'Diterima' ? 'bg-success' : ($status == 'Ditolak' ? 'bg-danger' : ($status == 'Revisi' ? 'bg-warning' : 'bg-primary'));

                    return "
                        <p class='badge shadow text-white mt-1 mb-0 $cek'>$status</p>
                    ";
                })
                ->rawColumns(['action', 'validation_status'])
                ->make(true);
        }

        $data['model'] = get_class(new Proposal());
        return view('admin.pages.proposal.index', compact('data'));
    }

    public function show($id)
    {
        $data['obj'] = Proposal::withTrashed()->findOrFail($id);
        $dudi_id = $data['obj']->ProposalDudi()->pluck('dudi_id');
        $data['pengajar_dudi'] = $data['obj']->DosenPraktisi;
        $data['pengajar_pt'] = $data['obj']->Dosen;

        $data['dudi'] = null;

        if ($dudi_id->count() > 0) {
            $data['dudi'] = Dudi::whereIn('id', $dudi_id)->get()->toArray();
        }

        $data['validation_status'] = Proposal::VALIDATION_STATUS;
        unset($data['validation_status']["1"]);
        $data['category_proposal'] = CategoryProposal::get();

        return view('admin.pages.proposal.show', compact('data'));
    }

    public function updateStatus($id, Request $request)
    {
        ValidationHelper::validate($request, [
            'category_proposal_id' => 'required',
            'validation_status' => ['required', Rule::in([2, 3, 4])],
            'validation_message' => Rule::requiredIf(function () use ($request) {
                return in_array($request->validation_status, [2, 3]);
            }),
            'accepted_budget' => Rule::requiredIf(function () use ($request) {
                return in_array($request->validation_status, [4]);
            }),
            'checklist' => ['nullable', 'array']
        ], [], ['validation_message' => 'Alasan', 'accepted_budget' => 'Anggaran yang disetujui']);

        if (in_array($request->validation_status, [4])) {
            $acceptedBudget = str_replace('.', '', $request->accepted_budget);
        } else {
            $acceptedBudget = 0;
        }

        $checklist = $request->checklist;

        Proposal::withTrashed()->findOrFail($id)->update([
            'category_proposal_id' => $request->category_proposal_id,
            'validation_status' => $request->validation_status,
            'validation_message' => $request->validation_message,
            'accepted_budget' => $acceptedBudget,
            'checklist' => $checklist,
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil menyimpan data.'
        ]);
    }

    // public function updateRegistrationConfig(Request $request)
    // {
    //     ValidationHelper::validate($request, [
    //         'quota' => 'required',
    //         'mahasiswa_registration_date_start' => ['required', 'date', 'date_format:d-m-Y'],
    //         'mahasiswa_registration_date_end' => ['required', 'date', 'date_format:d-m-Y', 'after_or_equal:mahasiswa_registration_date_start'],
    //     ], [], [
    //         'mahasiswa_registration_date_start' => 'Tanggal mulai',
    //         'mahasiswa_registration_date_end' => 'Tanggal akhir'
    //     ]);

    //     UpdateConfigHelper::update('proposal_registration', 'quota', $request->quota);
    //     UpdateConfigHelper::update(
    //         'proposal_registration',
    //         'registration_date',
    //         [
    //             'start' => $request->mahasiswa_registration_date_start,
    //             'end' => $request->mahasiswa_registration_date_end
    //         ]
    //     );

    //     return response()->json([
    //         'code' => 200,
    //         'message' => 'Berhasil merubah data!'
    //     ]);
    // }
}
