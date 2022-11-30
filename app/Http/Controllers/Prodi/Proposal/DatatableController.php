<?php

namespace App\Http\Controllers\Prodi\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Master\Proposal;
use App\Models\Reference\DosenPraktisi;
use App\Models\Reference\ProposalDosen;
use App\Models\Reference\ProposalDudi;
use App\Models\Reference\ProposalKolaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class DatatableController extends Controller
{
    public function dosen($proposal_id)
    {
        $query = ProposalDosen::with('dosen:nidn,namaDosen,gelarLengkap')->where('proposal_id', $proposal_id)->select(ProposalDosen::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return Blade::render('<x-forms.form-post action="' . route('prodi.proposal.ajaxdelete.dosen') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dosen">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button>
            </x-forms.form-post>');
            })
            ->addColumn('nama_dan_gelar', function ($obj) {
                return $obj->dosen->nama_dan_gelar;
            })
            ->rawColumns(['action'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

    public function dudi($proposal_id)
    {
        $query = ProposalDudi::with('dudi')->where('proposal_id', $proposal_id)->select(ProposalDudi::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return Blade::render('<x-forms.form-post action="' . route('prodi.proposal.ajaxdelete.dudi') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dudi">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button>
            </x-forms.form-post>');
            })
            ->editColumn('dudi.mou', function ($obj) {
                return $obj->dudi->has_mou == 0 ? 'Belum memiliki MOU' : '<a class="btn btn-sm btn-success btn-preview_pdf" href="' . asset($obj->dudi->mou) . '" data-toggle="tooltip" data-placement="top" title="Lihat MOU"><i class="fa fa-eye"></i></a>';
            })
            ->editColumn('dudi.website', function ($obj) {
                return '
                <a class="badge badge-success" target="_blank" href="//' . $obj->dudi->website . '">' . $obj->dudi->website . '</a>

                ';
            })
            ->rawColumns(['action', 'dudi.mou', 'dudi.website'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

    public function dosenPraktisi($proposal_id)
    {
        $query = DosenPraktisi::with('dudi')->where('proposal_id', $proposal_id)->select(DosenPraktisi::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {

                return '<div class="d-flex justify-content-center"><button type="button" class="btn-edit-dosen-praktisi btn btn-success mr-2" data-id="' . $obj->id . '"><i class="fa fa-edit"></i> Edit</button>' . Blade::render('<x-forms.form-post action="' . route('prodi.proposal.ajaxdelete.dosen.praktisi') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dosen-praktisi">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button></div>
            </x-forms.form-post>');
            })
            ->rawColumns(['action'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

    public function kolaborator($proposal_id)
    {
        $query = ProposalKolaborator::with('user:id,username,prodi_id,name')->where('proposal_id', $proposal_id)->select(ProposalKolaborator::getTableName() . '.*');

        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return
                    Blade::render('<x-forms.form-post action="' . route('prodi.proposal.ajaxdelete.kolaborator') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-proposal-kolaborasi">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button>
            </x-forms.form-post>');
            })
            ->rawColumns(['action'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'user.prodi', 'id',)
            ->make(true);
    }

    public function listCollabProposal()
    {
        $user = User::find(auth()->user()->id);
        $query = $user->proposal_kolaborasi();
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return '
                    <a class="btn btn-sm btn-primary " href="' . route('prodi.proposal.kolaborator.view', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
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
}
