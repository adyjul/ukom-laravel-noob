<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\MAA\ProgramStudi;
use App\Models\Master\CategoryProposal;
use App\Models\Master\Proposal;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class JumlahProposalProdi extends Controller
{
    public function index()
    {
        $data['category_proposal'] = CategoryProposal::get(['id', 'name']);
        return view('admin.pages.laporan.jumlah_proposal_prodi.index', compact('data'));
    }

    public function getCountByYear($year)
    {
        $prodi_id = Proposal::where('created_at', 'LIKE', $year . '%')->pluck('prodi_id')->toArray();
        $duplicate_count = array_count_values($prodi_id);
        $data = ProgramStudi::whereIn('kode', array_unique($prodi_id))->pluck('nama_depart', 'kode');
        return response()->json([
            'prodi' => $data,
            'proposal_counter' => $duplicate_count
        ]);
    }

    public function hasBeenUpload($year)
    {
        $prodi_id = Proposal::where('created_at', 'LIKE', $year . '%')->pluck('prodi_id')->toArray();
        $duplicate_count = array_count_values($prodi_id);
        $data = ProgramStudi::whereIn('kode', array_unique($prodi_id))->pluck('nama_depart', 'kode');
        return response()->json([
            'prodi' => $data,
            'proposal_counter' => $duplicate_count
        ]);
    }

    public function notUploadYet($year)
    {
        $prodi_id = Proposal::where('created_at', 'LIKE', $year . '%')->pluck('prodi_id')->toArray();
        $data = ProgramStudi::whereNotIn('kode', array_unique($prodi_id))->pluck('nama_depart', 'kode');
        $proposal_counter = [];
        foreach ($data as $k => $v) {
            $proposal_counter[$k] = 0;
        }
        return response()->json([
            'prodi' => $data,
            'proposal_counter' => $proposal_counter
        ]);
    }

    public function getDataByValidationStatus($year, $validation_status)
    {
        $prodi_id = Proposal::where('created_at', 'LIKE', $year . '%')->where('validation_status', $validation_status)->pluck('prodi_id')->toArray();
        $duplicate_count = array_count_values($prodi_id);
        $data = ProgramStudi::whereIn('kode', array_unique($prodi_id))->pluck('nama_depart', 'kode');
        return response()->json([
            'prodi' => $data,
            'proposal_counter' => $duplicate_count
        ]);
    }

    public function getDataByCategory($year, $category)
    {
        $prodi_id = Proposal::where('created_at', 'LIKE', $year . '%')->where('category_proposal_id', $category)->pluck('prodi_id')->toArray();
        $duplicate_count = array_count_values($prodi_id);
        $data = ProgramStudi::whereIn('kode', array_unique($prodi_id))->pluck('nama_depart', 'kode');
        return response()->json([
            'prodi' => $data,
            'proposal_counter' => $duplicate_count
        ]);
    }
}
