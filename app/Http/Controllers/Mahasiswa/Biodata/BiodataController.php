<?php

namespace App\Http\Controllers\Mahasiswa\Biodata;

use App\Http\Controllers\Controller;
use App\Models\Master\Mahasiswa;
use App\Models\Region\District;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\Village;
use App\Models\User;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BiodataController extends Controller
{
    public function index()
    {
        $data = new \stdClass;
        $data->user = User::with('mahasiswa')->find(auth()->user()->id);
        if ($data->user->mahasiswa) {
            if ($data->user->mahasiswa->profile) {
                $data->profile = (object)$data->user->mahasiswa->profile;

                if ($data->user->mahasiswa->profile['birth_place']) {
                    $data->birth_place = (object) [
                        'val' => optional($data->user->mahasiswa->profile)['birth_place'],
                        'text' => Regency::find(optional($data->user->mahasiswa->profile)['birth_place'])['name']
                    ];
                }
            }
            if ($data->user->mahasiswa->address) {
                $data->address = $data->user->mahasiswa->address;
                if ($data->user->mahasiswa->address['province_id']) {
                    $data->province = (object) [
                        'val' => optional($data->user->mahasiswa->address)['province_id'],
                        'text' => Province::find(optional($data->user->mahasiswa->address)['province_id'])['name']
                    ];
                }
                if ($data->user->mahasiswa->address['regency_id']) {
                    $data->regency = (object) [
                        'val' => optional($data->user->mahasiswa->address)['regency_id'],
                        'text' => Regency::find(optional($data->user->mahasiswa->address)['regency_id'])['name']
                    ];
                }
                if ($data->user->mahasiswa->address['district_id']) {
                    $data->district = (object) [
                        'val' => optional($data->user->mahasiswa->address)['district_id'],
                        'text' => District::find(optional($data->user->mahasiswa->address)['district_id'])['name']
                    ];
                }
                if ($data->user->mahasiswa->address['village_id']) {
                    $data->village = (object) [
                        'val' => optional($data->user->mahasiswa->address)['village_id'],
                        'text' => Village::find(optional($data->user->mahasiswa->address)['village_id'])['name']
                    ];
                }
            }
        }
        return view('mahasiswa.biodata.index', compact('data'));
    }

    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $rule = [
            'name' => ['required'],
            'email' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'phone' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'jenis_kelamin' => ['required'],
            'agama' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'alamat_detail' => ['required'],
            'nama_universitas' => ['required'],
            'nama_fakultas' => ['required'],
            'nama_prodi' => ['required'],
            'alamat_universitas' => ['required'],
        ];

        if ($mahasiswa) {
            $rule['nim'] = ['required'];
        } else {
            $rule['nim'] = ['required'];
        }

        ValidationHelper::validate($request, $rule);

        $profile = [
            'nim' => $request->nim,
            'birth_place' => $request->tempat_lahir,
            'birth_date' => $request->tanggal_lahir,
            'sex' => $request->jenis_kelamin,
            'religion_id' => $request->agama
        ];
        $address = [
            'province_id' => $request->provinsi,
            'regency_id' => $request->kabupaten,
            'district_id' => $request->kecamatan,
            'village_id' => $request->kelurahan,
            'detail' => $request->alamat_detail,
        ];
        $university = [
            'name' => ucwords($request->nama_universitas),
            'fakultas' => ucwords($request->nama_fakultas),
            'prodi' => ucwords($request->nama_prodi),
            'address' => $request->alamat_universitas
        ];

        if ($mahasiswa) {
            $mahasiswa->update([
                'profile' => $profile,
                'address' => $address,
                'university' => $university
            ]);
        } else {
            Mahasiswa::create([
                'user_id' => $user->id,
                'profile' => $profile,
                'address' => $address,
                'university' => $university
            ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'message' => 'Berhasil menyimpan data!',
            'code' => 200
        ]);
    }

    public function store_umum(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $rule = [
            'name' => ['required'],
            'nim' => ['required'],
            'email' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'phone' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'jenis_kelamin' => ['required'],
            'agama' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'alamat_detail' => ['required'],
        ];


        ValidationHelper::validate($request, $rule);

        $profile = [
            'nim' => $request->nim,
            'birth_place' => $request->tempat_lahir,
            'birth_date' => $request->tanggal_lahir,
            'sex' => $request->jenis_kelamin,
            'religion_id' => $request->agama
        ];
        $address = [
            'province_id' => $request->provinsi,
            'regency_id' => $request->kabupaten,
            'district_id' => $request->kecamatan,
            'village_id' => $request->kelurahan,
            'detail' => $request->alamat_detail,
        ];
        $university = [
            'name' => '-',
            'fakultas' => '-',
            'prodi' => '-',
            'address' => '-'
        ];

        if ($mahasiswa) {
            $mahasiswa->update([
                'profile' => $profile,
                'address' => $address,
                'university' => $university
            ]);
        } else {
            Mahasiswa::create([
                'user_id' => $user->id,
                'profile' => $profile,
                'address' => $address,
                'university' => $university
            ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'message' => 'Berhasil menyimpan data!',
            'code' => 200
        ]);
    }
}
