<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Models\Master\Course;
use App\Models\Reference\CourseDosenDudi;
use App\Models\Reference\CourseDosen;
use App\Models\Reference\CourseDudi;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteDataControler extends Controller
{
    // id adalah id dari tabel ProposalDosen
    public function deleteDosen(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $courseDosen = CourseDosen::findOrFail($request->id);
        $course = Course::findOrFail($courseDosen->course_id);

        if ($course->validation_status == "3") {
            $course->validation_status = "1";
            $course->save();
        }

        $courseDosen->delete();

        DB::commit();


        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }


    public function deleteDudi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $courseDudi = CourseDudi::findOrFail($request->id);
        $course = Course::findOrFail($courseDudi->course_id);

        if ($course->validation_status == "3") {
            $course->validation_status = "1";
            $course->save();
        }

        $courseDudi->delete();

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }

    public function deleteDosenDudi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'id' => 'required',
            ],
        );

        DB::beginTransaction();

        $courseDosenDudi = CourseDosenDudi::findOrFail($request->id);
        $course = Course::findOrFail($courseDosenDudi->course_id);

        if ($course->validation_status == "3") {
            $course->validation_status = "1";
            $course->save();
        }

        $courseDosenDudi->delete();

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil hapus data!'
        ]);
    }

}
