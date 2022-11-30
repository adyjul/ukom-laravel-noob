<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Models\MAA\Dosen;
use App\Models\Master\Dudi;
use App\Models\Master\Course;
use App\Models\Reference\CourseDosenDudi;
use App\Models\Reference\CourseDosen;
use App\Models\Reference\CourseDudi;
use App\Models\User;
use App\Utils\UploadFileHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsertDataAjaxController extends Controller
{

    public function storeDosen(Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
                'nidn' => 'required'
            ],
        );

        $course = Course::withTrashed()->findOrFail($request->id);

        $dosen = Dosen::where('nidn', $request->nidn)->first();

        if (!$dosen) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dosen tidak ditemukan!']);
        }

        $isDosenAlreadyExist = CourseDosen::where('nidn', $request->nidn)->where('course_id', $request->id)->count();

        if ($isDosenAlreadyExist > 0) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dosen sudah dipilih, silahkan pilih dosen lain!']);
        }

        DB::beginTransaction();

        if ($course->validation_status == "3") {
            $course->validation_status = "1";
            $course->save();
        }

        CourseDosen::create([
            'nidn' =>  $request->nidn,
            'course_id' => $request->id
        ]);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil input data!'
        ]);
    }

    public function storeDudi(Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
                'dudi_id' => 'required'
            ],
        );

        $course = Course::withTrashed()->findOrFail($request->id);

        $dudi = Dudi::findOrFail($request->dudi_id);

        $isDudiAlreadyExist = CourseDudi::where('dudi_id', $request->dudi_id)->where('course_id', $course->id)->count();

        if ($isDudiAlreadyExist > 0) {
            return ValidationHelper::ajaxErrorReturn(['message' => 'Dudi sudah dipilih, silahkan pilih dudi lain!']);
        }

        DB::beginTransaction();

        if ($course->validation_status == "3") {
            $course->validation_status = "1";
            $course->save();
        }
        CourseDudi::create([
            'dudi_id' =>  $request->dudi_id,
            'course_id' => $request->id
        ]);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil input data!'
        ]);
    }

    public function storeDosenDudi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'course_id' => 'required|exists:' . Course::getTableName() . ',id',
                'dudi_id' => 'required|exists:' . Dudi::getTableName() . ',id',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:6', 'max:15'],
            ],
        );

        CourseDosenDudi::create([
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'dudi_id' => $request->dudi_id,
            'course_id' => $request->course_id
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil tambah data!'
        ]);
    }

}
