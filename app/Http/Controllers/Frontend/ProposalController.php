<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MAA\Dosen;
use App\Models\Master\Course;
use App\Models\Master\Dudi;
use App\Models\Master\Proposal;
use App\Models\Master\Slider;
use App\Models\Reference\CourseDosenDudi;
use App\Models\Reference\CourseMahasiswa;
use App\Models\Reference\DosenPraktisi;
use App\Models\Reference\ProposalMahasiswa;
use Carbon\Carbon;

class ProposalController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // $register_date = config('proposal_registration.registration_date');

            // $register_date = [
            //     'start' => Carbon::createFromFormat('d-m-Y', $register_date['start'], 'Asia/Jakarta')->translatedFormat('d F Y'),
            //     'end' => Carbon::createFromFormat('d-m-Y', $register_date['end'], 'Asia/Jakarta')->translatedFormat('d F Y')
            // ];

            $query = Proposal::where('validation_status', '4')->where('class_description', '!=', null);
            return datatables()->of($query)
                ->editColumn('name', function ($obj) {
                    if ($obj->class_description != null) {
                        $register_date = [
                            'start' => Carbon::createFromFormat('d-m-Y', $obj->class_description['pendaftaran']['tgl_awal'], 'Asia/Jakarta')->translatedFormat('d F Y'),
                            'end' => Carbon::createFromFormat('d-m-Y', $obj->class_description['pendaftaran']['tgl_akhir'], 'Asia/Jakarta')->translatedFormat('d F Y')
                        ];
                    } else {
                        $register_date = [
                            'start' => '-',
                            'end' => '-',
                        ];
                    }
                    return '<a class="font-weight-bold my-1 select-list" data-name="proposal" id="list-proposal" data-scroll="#section" href="' . route('home.proposal.detail', ['id' => $obj->id]) . '">' . $obj->name . '</a>
                <p class=" mb-0 "><i class="fa fa-chalkboard-teacher text-muted mr-2"></i>' . $obj->ProgramStudi->nama_depart . '</p>' .
                        '<p class=" mb-0 "><i class="fa fa-users text-muted mr-2"></i>Kuota: <strong>' . config('proposal_registration.quota') . '</strong> Peserta (<span class="text-primary font-weight-bold">' . $obj->RegisteredUser->count() . '</span> Pendaftar / <span class="text-success font-weight-bold">' . $obj->acceptRegisteredUser->count() . '</span> Diterima / <span class="text-danger font-weight-bold">' . $obj->rejectRegisteredUser->count() . '</span> Ditolak)</p>' .
                        '<p class=" mb-0 "><i class="far fa-calendar-alt text-muted mr-2"></i> Waktu Pendaftaran: ' . $register_date['start'] . ' - ' . $register_date['end'] . '</p>';
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }

        // dd(auth()->user()->user_type, auth()->guard('mahasiswa_umm')->check());
        return view('frontend.proposal');
    }

    public function detail($id)
    {
        $proposal =  Proposal::withTrashed()->with('ProgramStudi:kode,nama_depart')->findOrFail($id);
        $dosen = Dosen::whereIn('nidn', $proposal->Dosen()->pluck('nidn'))->get(['nidn', "namaDosen", 'gelarLengkap']);
        $dosenPraktisi = DosenPraktisi::where('proposal_id', $id)->get(['name', 'position', 'email', 'phone', 'dudi_id']);
        $dudi = Dudi::withTrashed()->whereIn('id', $proposal->ProposalDudi()->pluck('dudi_id'))->get(['name', 'field', 'address', 'director_name', 'cp_name', 'website', 'has_mou', 'mou']);

        $proposal['dosen'] = $dosen;
        $proposal['dosenPraktisi'] = $dosenPraktisi;
        $proposal['dudi'] = $dudi;
        if ($proposal->class_description != null) {
            $proposal['gambar_penunjang'] = asset($proposal->class_description['image_path']);
        } else {
            $proposal['gambar_penunjang'] = null;
        }

        $proposal['hasBeenRegistered'] = null;
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        if ($mahasiswa) {
            $hasBeenRegistered = ProposalMahasiswa::where('proposal_id', $id)->where('mahasiswa_id', $mahasiswa->id)->first();
            if ($hasBeenRegistered) {
                $proposal['hasBeenRegistered'] = [
                    'validation_status_text' => $hasBeenRegistered->validation_status_text,
                    'tanggal_daftar' => $hasBeenRegistered->created_at->translatedFormat("d F Y"),
                ];
            }
        }

        return response()->json([
            'data' => $proposal
        ]);
    }

    public function detail_sementara($id)
    {
        $proposal =  Proposal::withTrashed()->with('ProgramStudi:kode,nama_depart')->findOrFail($id);
        $dosen = Dosen::whereIn('nidn', $proposal->Dosen()->pluck('nidn'))->get(['nidn', "namaDosen", 'gelarLengkap']);
        $dosenPraktisi = DosenPraktisi::where('proposal_id', $id)->get(['name', 'position', 'email', 'phone', 'dudi_id']);
        $dudi = Dudi::withTrashed()->whereIn('id', $proposal->ProposalDudi()->pluck('dudi_id'))->get(['name', 'field', 'address', 'director_name', 'cp_name', 'website', 'has_mou', 'mou']);

        $proposal['dosen'] = $dosen;
        $proposal['dosenPraktisi'] = $dosenPraktisi;
        $proposal['dudi'] = $dudi;
        $proposal['gambar_penunjang'] = asset($proposal->class_description['image_path']);

        $proposal['hasBeenRegistered'] = null;
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        if ($mahasiswa) {
            $hasBeenRegistered = ProposalMahasiswa::where('proposal_id', $id)->where('mahasiswa_id', $mahasiswa->id)->first();
            if ($hasBeenRegistered) {
                $proposal['hasBeenRegistered'] = [
                    'validation_status_text' => $hasBeenRegistered->validation_status_text,
                    'tanggal_daftar' => $hasBeenRegistered->created_at->translatedFormat("d F Y"),
                ];
            }
        }

        return view('frontend.detail_kelas', compact('proposal'));
        // return response()->json([
        //     'data' => $proposal
        // ]);
    }


    public function getCourse()
    {
        if (request()->ajax()) {
            $query = Course::where('validation_status', '4')
                ->where('category_course', 2)
                ->where('registration_date', '!=', null)
                ->where('activity_date', '!=', null)
                ->where('quota', '!=', null);

            return datatables()->of($query)
                ->editColumn('name', function ($obj) {
                    if ($obj->registration_date != null) {
                        $register_date = [
                            'start' => Carbon::createFromFormat('d-m-Y', $obj->registration_date['registration_start'], 'Asia/Jakarta')->translatedFormat('d F Y'),
                            'end' => Carbon::createFromFormat('d-m-Y', $obj->registration_date['registration_end'], 'Asia/Jakarta')->translatedFormat('d F Y')
                        ];
                    } else {
                        $register_date = [
                            'start' => '-',
                            'end' => '-',
                        ];
                    }
                    return '<a class="font-weight-bold my-1 select-list" data-name="course" id="list-course" data-scroll="#section" href="' . route('home.course.detail', ['id' => $obj->id]) . '">' . $obj->name . '</a>
                <p class=" mb-0 "><i class="fa fa-chalkboard-teacher text-muted mr-2"></i>' . $obj->ProgramStudi->nama_depart . '</p>' .
                        '<p class=" mb-0 "><i class="fa fa-users text-muted mr-2"></i>Kuota: <strong>' . $obj->quota . '</strong> Peserta (<span class="text-primary font-weight-bold">' . $obj->RegisteredUser->count() . '</span> Pendaftar / <span class="text-success font-weight-bold">' . $obj->acceptRegisteredUser->count() . '</span> Diterima / <span class="text-danger font-weight-bold">' . $obj->rejectRegisteredUser->count() . '</span> Ditolak)</p>' .
                        '<p class=" mb-0 "><i class="far fa-calendar-alt text-muted mr-2"></i> Waktu Pendaftaran: ' . $register_date['start'] . ' - ' . $register_date['end'] . '</p>';
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }

    public function detailCourse($id)
    {
        $course =  Course::withTrashed()->with('ProgramStudi:kode,nama_depart')->findOrFail($id);
        $dosen = Dosen::whereIn('nidn', $course->Dosen()->pluck('nidn'))->get(['nidn', "namaDosen", 'gelarLengkap']);
        $dosenDudi = CourseDosenDudi::where('course_id', $id)->get(['name', 'position', 'email', 'phone', 'dudi_id']);
        $dudi = Dudi::withTrashed()->whereIn('id', $course->CourseDudi()->pluck('dudi_id'))->get(['name', 'field', 'address', 'director_name', 'cp_name', 'website', 'has_mou', 'mou']);

        $data['dosen'] = $dosen;
        $data['dosenDudi'] = $dosenDudi;
        $data['dudi'] = $dudi;
        $data['course'] = $course;
        // $proposal['gambar_penunjang'] = asset($c->class_description['image_path']);

        $proposal['hasBeenRegistered'] = null;
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        if ($mahasiswa) {
            $hasBeenRegistered = CourseMahasiswa::where('course_id', $id)->where('mahasiswa_id', $mahasiswa->id)->first();
            if ($hasBeenRegistered) {
                $proposal['hasBeenRegistered'] = [
                    'validation_status_text' => $hasBeenRegistered->validation_status_text,
                    'tanggal_daftar' => $hasBeenRegistered->created_at->translatedFormat("d F Y"),
                ];
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
