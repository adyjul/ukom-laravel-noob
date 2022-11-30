<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Models\Master\Dudi;
use App\Models\Reference\CourseDosenDudi;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateDosenDudi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                // id dari tabel dosen praktisi
                'id' => 'required|exists:' . CourseDosenDudi::getTableName() . ',id',
                'dudi_id' => 'required|exists:' . Dudi::getTableName() . ',id',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:6', 'max:15'],
            ],
        );

        CourseDosenDudi::findOrFail($request->id)->update([
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'dudi_id' => $request->dudi_id,
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Berhasil edit data!'
        ]);
    }
}
