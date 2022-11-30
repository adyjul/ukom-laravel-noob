<?php

namespace App\Http\Controllers\Prodi\Proposal;

use App\Http\Controllers\Controller;
use App\Models\Master\Dudi;
use App\Models\Master\Proposal;
use App\Models\Reference\DosenPraktisi;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateDosenPraktisi(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                // id dari tabel dosen praktisi
                'id' => 'required|exists:' . DosenPraktisi::getTableName() . ',id',
                'dudi_id' => 'required|exists:' . Dudi::getTableName() . ',id',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:6', 'max:15'],
            ],
        );

        DosenPraktisi::findOrFail($request->id)->update([
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
