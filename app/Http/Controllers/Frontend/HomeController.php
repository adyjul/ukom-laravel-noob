<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MAA\ProgramStudi;
use App\Models\Master\Announcement;
use App\Models\Master\Download;
use App\Models\Master\Proposal;
use App\Models\Master\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['slider'] = Slider::all();
        $data['proposal_uploaded'] = Proposal::count();
        $data['proposal_accepted'] = Proposal::where('validation_status', 4)->count();
        $data['program_studi'] = ProgramStudi::where('hapus', 0)->count();
        return view('frontend.home', compact('data'));
    }
}
