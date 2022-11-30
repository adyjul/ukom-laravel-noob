<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Master\Course;
use App\Models\Master\Proposal;
use App\Models\Reference\CourseMahasiswa;
use App\Models\Reference\ProposalMahasiswa;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function register(Request $request)
    {
        $course = Course::findOrFail($request->id);

        $register_date = [
            'start' => Carbon::createFromFormat('d-m-Y', $course->registration_date['registration_start'], 'Asia/Jakarta')->startOfDay(),
            'end' => Carbon::createFromFormat('d-m-Y', $course->registration_date['registration_end'], 'Asia/Jakarta')->endOfDay()
        ];

        $now_date = Carbon::now('Asia/Jakarta');
        if ($now_date < $register_date['start'] || $now_date > $register_date['end']) {
            return response()->json([
                'code' => '401',
                'status' => 'false',
                'message' => 'Tanggal pendaftaran belum dimulai atau sudah terlewat.',
            ]);
        }


        $acceptedCourseRegisteredUser = CourseMahasiswa::where('course_id', $request->id)->where('validation_status', 2)->count();
        if ($acceptedCourseRegisteredUser >= $course->quota) {
            return response()->json([
                'code' => '401',
                'status' => 'false',
                'message' => 'Maaf, kuota telah terpenuhi!',
            ]);
        }

        // validasi id harus ada
        // id adalah id course

        // ValidationHelper::validate($request, [
        //     'id' => 'required|integer'
        // ]);

        $mahasiswa = auth()->user()->mahasiswa;
        // $mahasiswa = auth()->user();
        // $mahasiswa = auth()->guard('mahasiswa_umm');
        if ($mahasiswa != null) {
            // Sudah mendaftar di course ini?
            $hasBeenRegistered = CourseMahasiswa::where('course_id', $request->id)
                ->where('mahasiswa_id', $mahasiswa->id)
                ->count();

            if ($hasBeenRegistered > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda telah mendaftar pada course ini.',
                ]);
            }

            // apakah sudah mendaftar di course lain dan masih tahap validasi atau sudah diterima?
            $courseMahasiswa = CourseMahasiswa::where('course_id', '!=', $request->id)
                ->where('mahasiswa_id', $mahasiswa->id)
                ->whereIn('validation_status', ['0', '2'])
                ->count();

            if ($courseMahasiswa > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda hanya dapat mendaftar pada satu course.',
                ]);
            }

            CourseMahasiswa::create([
                'course_id' => $request->id,
                'nim' => $mahasiswa->kode_siswa,
                'mahasiswa_id' => $mahasiswa->id,
                'validation_status' => '0',
            ]);
        } else {
            $mahasiswa = auth()->user();

            // Sudah mendaftar di course ini?
            $hasBeenRegistered = CourseMahasiswa::where('course_id', $request->id)
                ->where('nim', $mahasiswa->kode_siswa)
                ->count();

            if ($hasBeenRegistered > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda telah mendaftar pada course ini.',
                ]);
            }

            // apakah sudah mendaftar di course lain dan masih tahap validasi atau sudah diterima?
            $courseMahasiswa = courseMahasiswa::where('course_id', '!=', $request->id)
                ->where('nim', $mahasiswa->kode_siswa)
                ->whereIn('validation_status', ['0', '2'])
                ->count();

            if ($courseMahasiswa > 0) {
                return response()->json([
                    'code' => '401',
                    'status' => 'false',
                    'message' => 'Anda hanya dapat mendaftar pada satu course.',
                ]);
            }

            courseMahasiswa::create([
                'course_id' => $request->id,
                'nim' => $mahasiswa->kode_siswa,
                'mahasiswa_id' => $mahasiswa->id,
                'validation_status' => '0',
            ]);
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Pendaftaran berhasil, silahkan menunggu validasi pendaftaran oleh admin prodi!',
        ]);
    }
}
