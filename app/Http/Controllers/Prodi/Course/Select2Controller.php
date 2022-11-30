<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Models\MAA\Dosen;
use App\Models\Master\Dudi;
use App\Models\Master\Mahasiswa;
use App\Models\MAA\Mahasiswa as MahasiswaUmm;
use App\Models\Reference\CourseDosenDudi;
use App\Models\User;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function dosenProdi(Request $request)
    {
        $validate = ValidationHelper::validateWithoutAutoRedirect($request, [
            'searchString' => 'string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'fail',
                'code' => '400',
                'message' => $validate->messages()->first()
            ]);
        }

        $data = Dosen::where('nidn', '!=', NULL)
            ->where('namaDosen', 'like', '%' . $request->searchString . '%')
            ->orderBy('namaDosen', 'ASC')
            ->limit('10')
            ->get([
                DB::raw('CONCAT(namaDosen," ",gelarLengkap) as text'),
                'nidn as id'
            ]);

        if (count($data) > 0) {
            $resp = [
                'code' => 200,
                'data' => $data
            ];
        } else {
            $resp = [
                'code' => 202,
                'message' => 'Data tidak ditemukan.'
            ];
        }

        return response()->json($resp);
    }

    public function dudi(Request $request)
    {
        $validate = ValidationHelper::validateWithoutAutoRedirect($request, [
            'searchString' => 'string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'fail',
                'code' => '400',
                'message' => $validate->messages()->first()
            ]);
        }

        $data = Dudi::where('prodi_id', '=', auth()->user()->prodi_id)
            ->where('name', 'like', '%' . $request->searchString . '%')
            ->orderBy('name', 'ASC')
            ->limit('10')
            ->get([
                'name as text',
                'id',
            ]);

        if (count($data) > 0) {
            $resp = [
                'code' => 200,
                'data' => $data
            ];
        } else {
            $resp = [
                'code' => 202,
                'message' => 'Data tidak ditemukan.'
            ];
        }

        return response()->json($resp);
    }

    public function detailDosenPraktisi($id)
    {
        $dosenPraktisi = CourseDosenDudi::with('dudi:id,name')->findOrFail($id);

        return response()->json([
            'data' => $dosenPraktisi
        ]);
    }


}
