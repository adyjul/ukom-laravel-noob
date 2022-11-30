<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region\District;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\Village;

class RegionController extends Controller
{
    public function province()
    {
        $data = Province::orderBy('name')->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function regency($id)
    {
        $data = Regency::orderBy('name')->where('province_id', $id)->get(['id', 'name']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function district($id)
    {
        $data = District::orderBy('name')->where('regency_id', $id)->get(['id', 'name']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function villages($id)
    {
        $data = Village::orderBy('name')->where('district_id', $id)->get(['id', 'name']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function select2Regency($keyword = "")
    {
        $data = Regency::orderBy('name')->where('name', 'like', '%' . $keyword . '%')->limit(15)->get(['id', 'name as text']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
