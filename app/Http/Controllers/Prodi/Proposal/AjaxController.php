<?php

namespace App\Http\Controllers\Prodi\Proposal;

use App\Http\Controllers\Controller;
use App\Models\MAA\Dosen;
use App\Models\Master\Dudi;
use App\Models\Master\Mahasiswa;
use App\Models\MAA\Mahasiswa as MahasiswaUmm;
use App\Models\Reference\DosenPraktisi;
use App\Models\User;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
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
        $dosenPraktisi = DosenPraktisi::with('dudi:id,name')->findOrFail($id);

        return response()->json([
            'data' => $dosenPraktisi
        ]);
    }

    public function detailPendaftar($id)
    {
        $mahasiswa = Mahasiswa::with('user:id,name,phone')->find($id, ['user_id', 'profile', 'address', 'university']);
        if ($mahasiswa != null) {
            $mahasiswa['birth_place'] = $mahasiswa->birth_place;
            $mahasiswa['full_address'] = $mahasiswa->full_address;
        } else {
            $mahasiswa_umm = MahasiswaUmm::where('kode_siswa', $id)->first();
            $mahasiswa['user'] = [
                "name" => $mahasiswa_umm->nama_siswa,
                "phone" => $mahasiswa_umm->hp_siswa
            ];
            $mahasiswa['profile'] = [
                "nim" => $mahasiswa_umm->kode_siswa,
                "sex" => $mahasiswa_umm->ref_jenis_kelamin == 1 ? "l" : "p",
                "religion_id" => $mahasiswa_umm->agama->agama,
                "birth_date" => Carbon::createFromFormat('Y-m-d', $mahasiswa_umm->tanggalLahir)->format('d/m/Y'),
            ];
            $mahasiswa['university'] = [
                "name" => "Universitas Muhammadiyah Malang",
                "address" => "Jl. Raya Tlogomas No.246, Babatan, Tegalgondo, Kec. Lowokwaru, Kota Malang, Jawa Timur"
            ];
            $mahasiswa['birth_place'] = $mahasiswa_umm->tempat_lahir;
            $mahasiswa['full_address'] = $mahasiswa_umm->alamat_asal;
        }

        return response()->json([
            'data' => $mahasiswa
        ]);
    }

    public function kolaborator(Request $request)
    {
        $keyword = $request->searchString;

        $prodi_id = auth()->user()->prodi_id;

        $usersRaw = User::where('prodi_id', "!=", $prodi_id)
            ->where('username', 'LIKE', '%' . $keyword . '%')
            ->where('user_type', 2)
            ->get();

        $users = [];
        foreach ($usersRaw as $user) {
            array_push($users, [
                'id' => $user->id,
                'text' => $user->username_and_prodi
            ]);
        }

        return response()->json([
            'data' => $users
        ]);
    }
}
