<?php

namespace App\Http\Controllers\Admin\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateStatusRequest;
use App\Models\Master\Course;
use App\Repositories\Course\CourseRepository;

class CourseController extends Controller
{
    private $courseRepo;
    public function __construct()
    {
        $this->courseRepo = new CourseRepository();
    }
    public function index(){
        if (request()->ajax()) {
            $query = Course::query()->whereNotNull('proposal');

            return datatables()->of($query)
                ->addColumn('action', function ($obj) {
                    return '
                    <a class="btn btn-sm btn-primary btn_edit" href="' . route('admin.course.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    ';
                })
                ->editColumn('prodi_id', function ($obj) {
                    return $obj->ProgramStudi->nama_depart;
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

        $data['model'] = Course::class;
        return view('admin.pages.course.index',compact('data'));
    }

    public function showById($id){
        $data['course'] = $this->courseRepo->getCourseById($id);
        $data['validation_status'] = Course::VALIDATION_STATUS;
        $data['category_course'] = Course::CATEGORY_COURSE;
        unset($data['validation_status']["1"]);
        return view('admin.pages.course.show',compact('data'));
    }

    public function updateStatus(UpdateStatusRequest $request){
        $validate = $request->validated();
        $this->courseRepo->updateStatusCourse($validate);
        return response()->json([
            'message' => 'Validasi Berhasil',
            'code' => 200
        ]);
    }

}
