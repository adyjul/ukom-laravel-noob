<?php

namespace App\Http\Controllers\Prodi\Proposal;

use App\Http\Controllers\Controller;
use App\Models\MAA\Dosen;
use App\Models\Master\Dudi;
use App\Models\Master\Proposal;
use App\Models\Reference\DosenPraktisi;
use App\Models\Reference\ProposalDosen;
use App\Models\Reference\ProposalDudi;
use App\Models\Reference\ProposalKolaborator;
use App\Models\User;
use App\Utils\UploadFileHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsertDetailController extends Controller
{
    public function storeDataProposal(Request $request)
    {

        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        $proposal = Proposal::withTrashed()->findOrFail($request->id);

        $rules = [
            'name' => 'required',
            'rps' => 'mimes:pdf|max:2048',
        ];

        if ($proposal->anggaran != null) {
            $rules['anggaran'] = 'nullable|mimes:csv,xlsx,xls,odt,ods,odp|max:2048';
        } else {
            $rules['anggaran'] = 'required|mimes:csv,xlsx,xls,odt,ods,odp|max:2048';
        }

        if ($proposal->proposal_files != null) {
            $rules['proposal'] = 'nullable|mimes:pdf|max:7048';
        } else {
            $rules['proposal'] = 'required|mimes:pdf|max:7048';
        }

        ValidationHelper::validate(
            $request,
            $rules,
            [
                'mimes' => 'format :attribute salah',
            ],
        );

        try {
            if ($request->file('proposal')) {
                $proposalFileArr = $proposal->proposal_files;

                if (!$proposalFileArr) {
                    $proposalFileArr = [];
                }
                $upload_proposal = UploadFileHelper::upload($request->file('proposal'), 'assets/uploads/' . date("Y") . '/files/proposal', $proposal->id . '-proposal-' . (count($proposalFileArr) + 1));
                array_push($proposalFileArr, [
                    'path' => $upload_proposal['path'],
                    'uploaded_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                ]);
                $proposal->proposal_files = $proposalFileArr;
            }

            if ($request->file('rps')) {
                $upload_rps = UploadFileHelper::upload($request->file('rps'), 'assets/uploads/' . date("Y") . '/files/rps', $proposal->id . '-RPS');
                $proposal->rps = $upload_rps['path'];
            }
            if ($request->file('anggaran')) {
                $upload_anggaran = UploadFileHelper::upload($request->file('anggaran'), 'assets/uploads/' . date("Y") . '/files/anggaran', $proposal->id . '-anggaran');
                $proposal->anggaran = $upload_anggaran['path'];
            }
            DB::beginTransaction();

            if ($proposal->validation_status == "3") {
                $proposal->validation_status = "1";
            }

            $proposal->name = $request->name;
            $proposal->save();

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => "Upload file proposal dan rps berhasil.",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function storeDosen(Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
                'nidn' => 'required'
            ],
        );

        $proposal = Proposal::withTrashed()->findOrFail($request->id);

        $dosen = Dosen::where('nidn', $request->nidn)->first();

        if (!$dosen) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dosen tidak ditemukan!']);
        }

        $isDosenAlreadyExist = ProposalDosen::where('nidn', $request->nidn)->where('proposal_id', $request->id)->count();

        if ($isDosenAlreadyExist > 0) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dosen sudah dipilih, silahkan pilih dosen lain!']);
        }

        DB::beginTransaction();

        if ($proposal->validation_status == "3") {
            $proposal->validation_status = "1";
            $proposal->save();
        }

        ProposalDosen::create([
            'nidn' =>  $request->nidn,
            'proposal_id' => $request->id
        ]);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil input data!'
        ]);
    }

    public function storeDudi(Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
                'dudi_id' => 'required'
            ],
        );

        $proposal = Proposal::withTrashed()->findOrFail($request->id);

        $dudi = Dudi::findOrFail($request->dudi_id);

        $isDudiAlreadyExist = ProposalDudi::where('dudi_id', $request->dudi_id)->where('proposal_id', $request->id)->count();

        if ($isDudiAlreadyExist > 0) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dudi sudah dipilih, silahkan pilih dudi lain!']);
        }

        DB::beginTransaction();

        if ($proposal->validation_status == "3") {
            $proposal->validation_status = "1";
            $proposal->save();
        }
        ProposalDudi::create([
            'dudi_id' =>  $request->dudi_id,
            'proposal_id' => $request->id
        ]);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil input data!'
        ]);
    }

    public function storeDosenPraktisi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'proposal_id' => 'required|exists:' . Proposal::getTableName() . ',id',
                'dudi_id' => 'required|exists:' . Dudi::getTableName() . ',id',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:6', 'max:15'],
            ],
        );

        DosenPraktisi::create([
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'dudi_id' => $request->dudi_id,
            'proposal_id' => $request->proposal_id
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil tambah data!'
        ]);
    }

    public function storeKolaborator(Request $request)
    {      
        ValidationHelper::validate(
            $request,
            [
                'proposal_id' => 'required|exists:' . Proposal::getTableName() . ',id',
                'user_id' => 'required|exists:' . User::getTableName() . ',id',
            ],
        );

        $auth = auth()->user();
        $auth = User::find(2);
        $user = User::findOrFail($request->user_id);
        if ($user->user_type != 2) {
            return response()->json([
                'code' => 400,
                'message' => 'User yang ditambahkan bukan PIC prodi!'
            ]);
        }

        // cek apakah prodi_id user yg ditambah sama dengan prodi_id user yg sekarang login
        if ($auth->prodi_id == $user->prodi_id) {
            return response()->json([
                'code' => 400,
                'message' => 'Tidak dapat menambahkan kolaborator dengan program studi yang sama!'
            ]);
        }

        $hasBeenInput = ProposalKolaborator::where('user_id',$request->user_id)->where('proposal_id',$request->proposal_id)->count();
        if($hasBeenInput > 0){
            return response()->json([
                'code' => 400,
                'message' => 'User telah ditambahkan!'
            ]);
        }

        ProposalKolaborator::create([
            "user_id" => $request->user_id,
            "proposal_id" => $request->proposal_id
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil tambah data!'
        ]);
    }
}
