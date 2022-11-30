<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reference\CourseMahasiswa;
use App\Models\Reference\ProposalMahasiswa;

class ClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // dd(!auth()->guard('mahasiswa_umm')->check());
        // $mahasiswa = $user->mahasiswa;

        $data['coe'] = ProposalMahasiswa::with(['proposal' => function ($query) {
            $query->select('id', 'prodi_id', 'name')
                ->where('category_proposal_id', 3)
                ->where('validation_status', 4);
        }])
            ->when(!auth()->guard('mahasiswa_umm')->check(), function ($query) use ($user) {
                $query->where('mahasiswa_id', $user->mahasiswa->id);
            })->when(auth()->guard('mahasiswa_umm')->check(), function ($query) use ($user) {
                $query->where('nim', $user->kode_siswa);
            })->get();


        $data['course'] = CourseMahasiswa::with(['course' => function ($query) {
            $query->select('id', 'prodi_id', 'name')
                ->where('category_proposal_id', 3)
                ->where('validation_status', 4);
        }])
            ->when(!auth()->guard('mahasiswa_umm')->check(), function ($query) use ($user) {
                $query->where('mahasiswa_id', $user->mahasiswa->id);
            })->when(auth()->guard('mahasiswa_umm')->check(), function ($query) use ($user) {
                $query->where('nim', $user->kode_siswa);
            })->get();

        // dd($data);
        return view('frontend.class', compact('data'));
    }
}
