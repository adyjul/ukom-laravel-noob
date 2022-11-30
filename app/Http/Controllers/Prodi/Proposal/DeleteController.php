<?php

namespace App\Http\Controllers\Prodi\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Master\Proposal;
use App\Models\Reference\DosenPraktisi;
use App\Models\Reference\ProposalDosen;
use App\Models\Reference\ProposalDudi;
use App\Models\Reference\ProposalKolaborator;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    // id adalah id dari tabel ProposalDosen
    public function deleteDosen(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $proposalDosen = ProposalDosen::findOrFail($request->id);
        $proposal = Proposal::findOrFail($proposalDosen->proposal_id);

        if ($proposal->validation_status == "3") {
            $proposal->validation_status = "1";
            $proposal->save();
        }

        $proposalDosen->delete();

        DB::commit();


        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }

    // id adalah id dari tabel ProposalDudi
    public function deleteDudi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $proposalDudi = ProposalDudi::findOrFail($request->id);
        $proposal = Proposal::findOrFail($proposalDudi->proposal_id);

        if ($proposal->validation_status == "3") {
            $proposal->validation_status = "1";
            $proposal->save();
        }

        $proposalDudi->delete();

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }

    public function deleteDosenPraktisi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $dosenPraktisi = DosenPraktisi::findOrFail($request->id);
        $proposal = Proposal::findOrFail($dosenPraktisi->proposal_id);

        if ($proposal->validation_status == "3") {
            $proposal->validation_status = "1";
            $proposal->save();
        }

        $dosenPraktisi->delete();

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }

    public function deleteKolaborator(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        ProposalKolaborator::findOrFail($request->id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }
}
