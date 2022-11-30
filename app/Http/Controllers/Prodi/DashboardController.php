<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\Master\Proposal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // $data['proposal_not_validation_yet'] =  $user->proposal->where('validation_status', '1')->count();
        // $data['proposal_reject'] = $user->proposal->where('validation_status', '2')->count();
        // $data['proposal_revision'] =  $user->proposal->where('validation_status', '3')->count();
        // $data['proposal_accept'] =  $user->proposal->where('validation_status', '4')->count();
        $data['first_proposal'] = $user->proposal->sortBy('id')->first();
        $data['latest_proposal'] = $user->proposal->sortByDesc('id')->first();
        if ($data['first_proposal']) {
            if ($data['first_proposal'] ==  $data['latest_proposal']) {
                $data['waktu_daftar_proposal'] = $data['first_proposal']->formatted_created_at;
            } else {
                $data['waktu_daftar_proposal'] = $data['first_proposal']->formatted_created_at . ' - ' . $data['latest_proposal']->formatted_created_at;
            }
        } else {
            $data['waktu_daftar_proposal'] = NULL;
        }
        // waktu mulai validasi proposal oleh admin
        $data['validation_date_start'] = Carbon::createFromFormat("d-m-Y", "10-4-2022");

        // waktu mulai validasi proposal oleh admin
        $data['validation_date_end'] = Carbon::createFromFormat("d-m-Y", "20-5-2022");

        $data['isValidationDateStarted'] = Carbon::now() > $data['validation_date_start'];
        return view('prodi.pages.dashboard', compact('data'));
    }
}
