<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prodi\StoreCourseValidationRequest;
use App\Http\Requests\Prodi\StoreDetailCourseRequest;
use App\Http\Requests\Prodi\StoreNameRequest;
use App\Repositories\Course\CourseRepository;
use App\Models\Master\Course;
use App\Models\Reference\CourseDosenDudi;
use App\Models\Reference\CourseMahasiswa;
use App\Utils\FlashMessageHelper;
use App\Utils\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Utils\UploadFileHelper;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    private $courseRepo;

    public function __construct()
    {
        $this->courseRepo = new CourseRepository();

    }

    public function index()
    {
        if (request()->ajax()) {
            if (request()->has('deleted')) {
                $query = Course::onlyTrashed();
            } else {
                $query = Course::query();
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
                    <a class="btn btn-sm btn-primary btn_edit" href="' . route('prodi.course.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger btn_hapus" href="' . route('prodi.course.delete', ['id' => $obj->id]) . '" data-id=' . $obj->id . ' data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></a>
                    ';
                    }
                })
                ->editColumn('validation_status', function ($obj) {
                    $status = Course::VALIDATION_STATUS[$obj->validation_status];
                    $cek = $status == 'Diterima' ? 'bg-success' : ($status == 'Ditolak' ? 'bg-danger' : ($status == 'Revisi' ? 'bg-warning' : 'bg-primary'));
                    return "
                        <p class='badge shadow text-white mt-1 mb-0 $cek'>$status</p>
                    ";
                })
                ->rawColumns(['action', 'validation_status'])
                ->make(true);
        }

        $data['model'] = Proposal::class;
        return view('prodi.pages.course.index',compact('data'));
    }


    public function storeCourseValidation(StoreCourseValidationRequest $request){
        $validate = $request->validated();
        $course = Course::withTrashed()->findOrFail($request->id);
        $validate['path_proposal'] = null;
        if ($request->file('proposal') != null) {
            $upload_proposal = UploadFileHelper::uploadWithOriginalFileName($request->file('proposal'), 'assets/uploads/' . date("Y") . '/files/course', $course->id . '-proposal-' . $course->id);
            $validate['path_proposal'] = $upload_proposal['path'];
        }
        $this->courseRepo->storeCourseValidation($request->id,$validate);
        return response()->json([
            'message' => 'Data Berhasil Diupdate',
            'code' => 201
        ]);
    }

    public function storeNameCourse(StoreNameRequest $request){

        $validate = $request->validated();
        $validate['prodi_id'] = auth()->user()->prodi_id;
        $this->courseRepo->storeNameCourseByRequest($validate);

        return response()->json([
            'message' => 'Data Berhasil Masuk',
            'code' => 201
        ]);
    }

    public function storeDetailCourse(StoreDetailCourseRequest $request){

        $validate = $request->validated();
        $course = Course::findOrFail($validate['id']);
        $uploadImage = ImageUploadHelper::upload($request->file('image'), 'assets/uploads/' . date("Y") . '/images/banner/', $course->id . '-banner');
        $validate['image_file'] = $uploadImage['image_relative_path'];

        $validate['registration_date'] = [
            'registration_start' => $validate['registration_date_start'],
            'registration_end' => $validate['registration_date_end']
        ];
        $validate['activity_date'] = [
            'activity_start' => $validate['activity_date_start'],
            'activity_end' => $validate['activity_date_end']
        ];
        $this->courseRepo->storeDetailCourse($validate);

        return response()->json([
            'message' => 'Data Berhasil Masuk',
            'code' => 201
        ]);
    }

    public function showById($id){
        $data['course'] = $this->courseRepo->getCourseById($id);
        if ($data['course']->validation_status == '4') {
            $data['registered_user'] = CourseMahasiswa::where('course_id', $id)->get();
            $data['registered_user_count'] = [
                'pending' =>  CourseMahasiswa::where('course_id', $id)->where('validation_status', "0")->count(),
                'reject' =>  CourseMahasiswa::where('course_id', $id)->where('validation_status', "1")->count(),
                'accept' =>  CourseMahasiswa::where('course_id', $id)->where('validation_status', "2")->count(),
            ];
        }
        return view('prodi.pages.course.show',compact('data'));
    }

    public function userRegistrationAccept($id)
    {
        $registrationUser = CourseMahasiswa::findOrFail($id);
        $course = Course::findOrFail($registrationUser->course_id);
        if ($registrationUser->nim != null) {
            $mahasiswaId = $registrationUser->mahasiswa_id;
            $userRegisteredInCourse = CourseMahasiswa::where('mahasiswa_id', $mahasiswaId)->where('validation_status', 2)->first();
        } else {
            $nim = $registrationUser->nim;
            $userRegisteredInCourse = CourseMahasiswa::where('nim', $nim)->where('validation_status', 2)->first();
        }

        if ($userRegisteredInCourse != null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal Menerima Pendaftaran!",
                "text" => "User Telah Diterima Pada Proposal Lain!"
            ]);
            return redirect()->to(url()->previous() . '#card_registered_user');
        }

        $acceptedUserInCoure = CourseMahasiswa::where('course_id', $registrationUser->course_id)->where('validation_status', 2)->count();

        if ($acceptedUserInCoure > $course->quota) {
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
        $registrationUser = CourseMahasiswa::findOrFail($id);
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
        $mahasiswaIds = CourseMahasiswa::whereIn('id', $registeredIds)->pluck('id', 'mahasiswa_id')->toArray();
        // get user_id that its has been accepted in this or other course
        $invalid_registered_id = CourseMahasiswa::whereIn('mahasiswa_id', array_keys($mahasiswaIds))->where('validation_status', "2")->pluck('mahasiswa_id')->toArray();
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
        $course = Course::find($id);
        if ($course->quota < $course->acceptRegisteredUser->count() + count($mahasiswaIds)) {
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
        CourseMahasiswa::whereIn('id', array_values($mahasiswaIds))->update([
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
        CourseMahasiswa::whereIn('id', array_values($request->registered_id))->update([
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


    public function deleteById($id){
        $this->courseRepo->deleteById($id);
        return response()->json([
            'message' => 'Data Berhasil Dihapus',
            'code'=> 200
        ]);
    }

    public function detailDosenDudi($id)
    {
        $dosenPraktisi = CourseDosenDudi::with('dudi:id,name')->findOrFail($id);

        return response()->json([
            'data' => $dosenPraktisi
        ]);
    }
}
