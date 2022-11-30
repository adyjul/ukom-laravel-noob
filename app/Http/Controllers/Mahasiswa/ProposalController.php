<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Master\Proposal;
use App\Models\Reference\ProposalMahasiswa;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function register(Request $request)
    {
        $register_date = config('proposal_registration.registration_date');
        $register_date = [
            'start' => Carbon::createFromFormat('d-m-Y', $register_date['start'], 'Asia/Jakarta')->startOfDay(),
            'end' => Carbon::createFromFormat('d-m-Y', $register_date['end'], 'Asia/Jakarta')->endOfDay()
        ];

        $now_date = Carbon::now('Asia/Jakarta');
        if ($now_date < $register_date['start'] || $now_date > $register_date['end']) {
            return response()->json([
                'code' => '401',
                'status' => 'false',
                'message' => 'Tanggal pendaftaran belum dimulai atau sudah terlewat.',
            ]);
        }

        $quota = config('proposal_registration.quota');
        $acceptedProposalRegisteredUser = ProposalMahasiswa::where('proposal_id', $request->id)->where('validation_status', 2)->count();
        if ($acceptedProposalRegisteredUser >= $quota) {
            return response()->json([
                'code' => '401',
                'status' => 'false',
                'message' => 'Maaf, kuota telah terpenuhi!',
            ]);
        }

        // validasi id harus ada
        // id adalah id proposal

        ValidationHelper::validate($request, [
            'id' => 'required|integer'
        ]);

        $mahasiswa = auth()->user()->mahasiswa;
        // $mahasiswa = auth()->user();
        // $mahasiswa = auth()->guard('mahasiswa_umm');
        if ($mahasiswa != null) {
            // Sudah mendaftar di proposal ini?
            $hasBeenRegistered = ProposalMahasiswa::where('proposal_id', $request->id)
                ->where('mahasiswa_id', $mahasiswa->id)
                ->count();

            if ($hasBeenRegistered > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda telah mendaftar pada proposal ini.',
                ]);
            }

            // apakah sudah mendaftar di proposal lain dan masih tahap validasi atau sudah diterima?
            $proposalMahasiswa = ProposalMahasiswa::where('proposal_id', '!=', $request->id)
                ->where('mahasiswa_id', $mahasiswa->id)
                ->whereIn('validation_status', ['0', '2'])
                ->count();

            if ($proposalMahasiswa > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda hanya dapat mendaftar pada satu proposal.',
                ]);
            }

            ProposalMahasiswa::create([
                'proposal_id' => $request->id,
                'mahasiswa_id' => $mahasiswa->id,
                'validation_status' => '0',
            ]);
        } else {
            $mahasiswa = auth()->user();

            // Sudah mendaftar di proposal ini?
            $hasBeenRegistered = ProposalMahasiswa::where('proposal_id', $request->id)
                ->where('nim', $mahasiswa->kode_siswa)
                ->count();

            if ($hasBeenRegistered > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda telah mendaftar pada proposal ini.',
                ]);
            }

            // apakah sudah mendaftar di proposal lain dan masih tahap validasi atau sudah diterima?
            $proposalMahasiswa = ProposalMahasiswa::where('proposal_id', '!=', $request->id)
                ->where('nim', $mahasiswa->kode_siswa)
                ->whereIn('validation_status', ['0', '2'])
                ->count();

            if ($proposalMahasiswa > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda hanya dapat mendaftar pada satu proposal.',
                ]);
            }

            ProposalMahasiswa::create([
                'proposal_id' => $request->id,
                'nim' => $mahasiswa->kode_siswa,
                'validation_status' => '0',
            ]);
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Pendaftaran berhasil, silahkan menunggu validasi pendaftaran oleh admin prodi!',
        ]);
    }
}
