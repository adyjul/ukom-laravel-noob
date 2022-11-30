<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\MAA\ProgramStudi;
use App\Models\Master\CategoryProposal;
use App\Models\Master\Dudi;
use App\Models\Master\Proposal;
use App\Models\Reference\ProposalKolaborator;
use App\Models\Reference\ProposalMahasiswa;
use App\Utils\ImageUploadHelper;
use App\Models\User;
use App\Utils\FlashMessageHelper;
use App\Models\MAA\Mahasiswa as MahasiswaUmm;
use App\Utils\UploadFileHelper;
use App\Utils\UpdateConfigHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ProposalController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (request()->has('deleted')) {
                $query = Proposal::onlyTrashed();
            } else {
                $query = Proposal::query();
            }
            //$query = $query->where('created_by', auth()->user()->id);
            $query = $query->where('prodi_id', auth()->user()->prodi_id);
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    if ($obj->trashed()) {
                        return '
                    <a class="btn btn-sm btn-success btn_restore" href="' . route('prodi.proposal.restore', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Restore"><i class="fas fa-trash-restore"></i></a>
                    ';
                    } else {
                        return '
                    <a class="btn btn-sm btn-success" href="' . route('prodi.proposal.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>
                    <a class="btn btn-sm btn-primary btn_edit" href="' . route('prodi.proposal.edit', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger btn_hapus" href="' . route('prodi.proposal.delete', ['id' => $obj->id]) . '" data-id=' . $obj->id . ' data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></a>
                    ';
                    }
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

        $data['model'] = Proposal::class;
        return view('prodi.pages.proposal.index', compact('data'));
    }

    public function kolaborator($id)
    {
        $data_kolaborator = ProposalKolaborator::findOrFail($id);
        $data['obj'] = Proposal::withTrashed()->findOrFail($data_kolaborator['proposal_id']);
        $dudi_id = $data['obj']->ProposalDudi()->pluck('dudi_id');
        $data['pengajar_dudi'] = $data['obj']->DosenPraktisi;
        $data['pengajar_pt'] = $data['obj']->Dosen;

        $data['dudi'] = null;

        if ($dudi_id->count() > 0) {
            $data['dudi'] = Dudi::whereIn('id', $dudi_id)->get()->toArray();
        }

        return view('prodi.pages.proposal.show_kolaborator', compact('data'));
    }

    public function storeName(Request $request)
    {

        $proposal = Proposal::create([
            'name'  => $request->nama_proposal,
            'validation_status' => 1,
            'prodi_id' => auth()->user()->prodi_id,
        ]);

        if ($proposal) {
            return response()->json(array('status' => 200, 'mesage' => 'berhasil'));
        } else {
            return response()->json(array('status' => 204, 'mesage' => 'gagal'));
        }
    }

    public function show($id)
    {
        $data['obj'] = Proposal::withTrashed()->findOrFail($id);
        $dudi_id = $data['obj']->ProposalDudi()->pluck('dudi_id');
        $data['pengajar_dudi'] = $data['obj']->DosenPraktisi;
        $data['pengajar_pt'] = $data['obj']->Dosen;

        $data['dudi'] = null;

        if ($dudi_id->count() > 0) {
            $data['dudi'] = Dudi::whereIn('id', $dudi_id)->get()->toArray();
        }

        $user = auth()->user();
        $data['categories'] = CategoryProposal::pluck('name', 'id');
        if ($data['obj']->validation_status == '4') {
            $data['registered_user'] = ProposalMahasiswa::where('proposal_id', $id)->get();
            $data['registered_user_count'] = [
                'pending' =>  ProposalMahasiswa::where('proposal_id', $id)->where('validation_status', "0")->count(),
                'reject' =>  ProposalMahasiswa::where('proposal_id', $id)->where('validation_status', "1")->count(),
                'accept' =>  ProposalMahasiswa::where('proposal_id', $id)->where('validation_status', "2")->count(),
            ];
        }

        return view('prodi.pages.proposal.show', compact('data'));
    }

    public function delete($id)
    {
        $download = Proposal::findOrFail($id);
        $download->delete();

        if ($download) {
            return response()->json(array('status' => 200, 'mesage' => 'terhapus'));
        } else {
            return response()->json(array('status' => 204, 'mesage' => 'gagal'));
        }
    }

    public function restore($id)
    {
        $download = Proposal::withTrashed()->findOrFail($id);
        $download->restore();

        if ($download) {
            return response()->json(array('status' => 200, 'mesage' => 'berhasil'));
        } else {
            return response()->json(array('status' => 204, 'mesage' => 'gagal'));
        }
    }

    public function edit($id)
    {
        $data['obj'] = Proposal::withTrashed()->findOrFail($id);
        if ($data) {
            return response()->json(array('status' => 200, 'mesage' => 'berhasil', 'data' => $data['obj']));
        } else {
            return response()->json(array('status' => 204, 'mesage' => 'gagal'));
        }
    }
    public function updateName($id, Request $request)
    {
        $updateData = [
            'name'  => $request->nama_proposal,
        ];
        $input = Proposal::findOrFail($id)->update($updateData);

        if ($input) {
            return response()->json(array('status' => 200, 'mesage' => 'berhasil'));
        } else {
            return response()->json(array('status' => 204, 'mesage' => 'gagal'));
        }
    }

    public function userRegistrationAccept($id)
    {
        $registrationUser = ProposalMahasiswa::findOrFail($id);
        if ($registrationUser->nim != null) {
            $mahasiswaId = $registrationUser->mahasiswa_id;
            $userRegisteredInCourse = ProposalMahasiswa::where('mahasiswa_id', $mahasiswaId)->where('validation_status', 2)->first();
        } else {
            $nim = $registrationUser->nim;
            $userRegisteredInCourse = ProposalMahasiswa::where('nim', $nim)->where('validation_status', 2)->first();
        }

        if ($userRegisteredInCourse != null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal Menerima Pendaftaran!",
                "text" => "User Telah Diterima Pada Proposal Lain!"
            ]);
            return redirect()->to(url()->previous() . '#card_registered_user');
        }

        $acceptedUserInProposal = ProposalMahasiswa::where('proposal_id', $registrationUser->proposal_id)->where('validation_status', 2)->count();

        if ($acceptedUserInProposal > config('proposal_registration.quota')) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal Menerima Pendaftaran!",
                "text" => "Quota telah terpenuhi!"
            ]);
            return redirect()->to(url()->previous() . '#card_registered_user');
        }

        DB::beginTransaction();
        $registrationUser->validation_status = "2";
        $registrationUser->save();
        DB::commit();

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Berhasil menerima pendaftaran!"
        ]);
        return redirect()->to(url()->previous() . '#card_registered_user');
    }

    public function userRegistrationReject($id)
    {
        $registrationUser = ProposalMahasiswa::findOrFail($id);
        DB::beginTransaction();
        $registrationUser->validation_status = "1";
        $registrationUser->save();
        DB::commit();

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Berhasil menolak pendaftaran!"
        ]);
        return redirect()->to(url()->previous() . '#card_registered_user');
    }

    public function userBatchRegistrationAccept($id, Request $request)
    {
        $registeredIds = $request->registered_id;
        $mahasiswaIds = ProposalMahasiswa::whereIn('id', $registeredIds)->pluck('id', 'mahasiswa_id')->toArray();
        // get user_id that its has been accepted in this or other course
        $invalid_registered_id = ProposalMahasiswa::whereIn('mahasiswa_id', array_keys($mahasiswaIds))->where('validation_status', "2")->pluck('mahasiswa_id')->toArray();
        $mahasiswaIds = array_diff_key($mahasiswaIds, array_flip($invalid_registered_id));
        if (count($mahasiswaIds) == 0) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Maaf!",
                "text" => "Pendaftar yang dipilih telah diterima di proposal lain atau sudah diterima di proposal ini!"
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil'
            ]);
        }
        $proposal = Proposal::find($id);
        if (config('proposal_registration.quota') < $proposal->acceptRegisteredUser->count() + count($mahasiswaIds)) {
            // FlashMessageHelper::swal([
            //     "icon" => "error",
            //     "title" => "Gagal menerima pendaftaran!",
            //     "text" => "Pendaftar yang dipilih melebihi kuota yang tersedia!"
            // ]);
            return response()->json([
                'status' => false,
                'message' => 'Pendaftar yang dipilih melebihi kuota yang tersedia!'
            ]);
        }
        ProposalMahasiswa::whereIn('id', array_values($mahasiswaIds))->update([
            'validation_status' => "2"
        ]);
        if (count($mahasiswaIds) == count($registeredIds)) {
            FlashMessageHelper::swal([
                "icon" => "success",
                "title" => "Berhasil!",
                "text" => "Berhasil menerima pendaftar yang dipilih!"
            ]);
        } else {
            FlashMessageHelper::swal([
                "icon" => "success",
                "title" => "Berhasil!",
                "text" => "Berhasil menerima beberapa pendaftar yang dipilih. Ada beberapa pendaftar yang tidak dapat diterima!"
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil'
        ]);
    }

    public function userBatchRegistrationReject($id, Request $request)
    {
        ProposalMahasiswa::whereIn('id', array_values($request->registered_id))->update([
            'validation_status' => "1"
        ]);

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Berhasil menolak pendaftar yang dipilih!"
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil'
        ]);
    }

    public function createPDF($id)
    {
        $data['proposal'] = Proposal::findOrFail($id);
        $registeredUser = $data['proposal']->acceptRegisteredUser;
        foreach ($registeredUser as $k => $v) {
            if ($v->mahasiswa_id != null) {
                $mahasiswa = $v->mahasiswa;
                $user = User::find($mahasiswa->user_id);
                $data['registered_users'][$k]['name'] = $user->name;
                $data['registered_users'][$k]['phone'] = $user->phone;
                $data['registered_users'][$k]['email'] = $user->email;
                $data['registered_users'][$k]['university'] = $mahasiswa->university;
                $data['registered_users'][$k]['profile'] = $mahasiswa->profile;
                $umur = Carbon::createFromFormat('d/m/Y', $mahasiswa->profile['birth_date'])->startOfDay()->age;
                $data['registered_users'][$k]['umur'] = $umur;
            } else {
                $mahasiswa_umm = MahasiswaUmm::where('kode_siswa', $v->nim)->first();

                $data['registered_users'][$k]['name'] = $mahasiswa_umm->nama_siswa;
                $data['registered_users'][$k]['phone'] = $mahasiswa_umm->hp_siswa;
                $data['registered_users'][$k]['email'] = $mahasiswa_umm->email;
                $data['registered_users'][$k]['profile'] = [
                    "nim" => "$mahasiswa_umm->kode_siswa",
                    "sex" => $mahasiswa_umm->ref_jenis_kelamin  == 1 ? "l" : "p",
                    "religion_id" => $mahasiswa_umm->agama->agama,
                    "birth_date" => Carbon::createFromFormat('Y-m-d', $mahasiswa_umm->tanggalLahir)->format('d/m/Y'),
                ];
                $data['registered_users'][$k]['university'] = [
                    "name" => "Universitas Muhammadiyah Malang",
                    "address" => "Jl. Raya Tlogomas No.246, Babatan, Tegalgondo, Kec. Lowokwaru, Kota Malang, Jawa Timur"
                ];
                $umur = Carbon::createFromFormat('Y-m-d', $mahasiswa_umm->tanggalLahir)->startOfDay()->age;
                $data['registered_users'][$k]['umur'] = $umur;
            }
        }
        // dd($data);
        // return view('prodi.export.proposal_accepted_user', compact('data'));
        $pdf = PDF::loadView('prodi.export.proposal_accepted_user', compact('data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($data['proposal']->name . '.pdf');
    }


    public function updateDeskripsikelas(Request $request)
    {
        ValidationHelper::validate($request, [
            'proposal_id' => 'required',
            'quota' => 'required',
            'mahasiswa_registration_date_start' => ['required', 'date', 'date_format:d-m-Y'],
            'mahasiswa_registration_date_end' => ['required', 'date', 'date_format:d-m-Y', 'after_or_equal:mahasiswa_registration_date_start'],
            'mahasiswa_activity_date_start' => ['required', 'date', 'date_format:d-m-Y'],
            'mahasiswa_activity_date_end' => ['required', 'date', 'date_format:d-m-Y', 'after_or_equal:mahasiswa_activity_date_start'],
            'biaya' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [], [
            'mahasiswa_registration_date_start' => 'Tanggal mulai pendaftaran',
            'mahasiswa_registration_date_end' => 'Tanggal akhir pendaftaran',
            'mahasiswa_activity_date_start' => 'Tanggal mulai kegiatan',
            'mahasiswa_activity_date_end' => 'Tanggal akhir kegiatan',
            'image' => 'Gambar Penunjang'
        ]);

        // UpdateConfigHelper::update('proposal_registration', 'quota', $request->quota);
        // UpdateConfigHelper::update(
        //     'proposal_registration',
        //     'registration_date',
        //     [
        //         'start' => $request->mahasiswa_registration_date_start,
        //         'end' => $request->mahasiswa_registration_date_end
        //     ]
        // );
        $biaya = str_replace('.', '', $request->biaya);

        $proposal = Proposal::find($request->proposal_id);

        $imageUploadResult = ImageUploadHelper::upload($request->file('image'), 'assets/uploads/' . date("Y") . '/images/banner/', $proposal->id . '-banner');

        $deskripsi_kelas = [
            'kuota' => $request->quota,
            'pendaftaran' => [
                'tgl_awal' => $request->mahasiswa_registration_date_start,
                'tgl_akhir' => $request->mahasiswa_registration_date_end,
            ],
            'kegiatan' => [
                'tgl_awal' => $request->mahasiswa_activity_date_start,
                'tgl_akhir' => $request->mahasiswa_activity_date_end,
            ],
            'biaya' => $biaya,
            'image_path' => '/' . $imageUploadResult['image_relative_path']
        ];


        if ($proposal) {
            $proposal->class_description = $deskripsi_kelas;
            $proposal->save();
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan!'
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil merubah data!'
        ]);
    }
}
