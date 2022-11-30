<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master\Announcement;
use App\Models\Master\Download;
use App\Models\Master\Proposal;
use App\Models\Master\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['user_prodi'] = User::where('user_type', "2")->count();
        $data['slider'] = Slider::count();
        $data['announcement'] = Announcement::count();
        $data['download'] = Download::count();
        $data['proposal_counter'][0] = Proposal::where('validation_status', '1')->count();
        $data['proposal_counter'][1] = Proposal::where('validation_status', '2')->count();
        $data['proposal_counter'][2] = Proposal::where('validation_status', '3')->count();
        $data['proposal_counter'][3] = Proposal::where('validation_status', '4')->count();
        $data['proposal_validation_status'] = array_values(Proposal::VALIDATION_STATUS);
        return view('admin.pages.dashboard', compact('data'));
    }
}
