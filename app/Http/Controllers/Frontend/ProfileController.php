<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Master\Mahasiswa;
use App\Models\Region\District;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\Village;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
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
        return view('mahasiswa.biodata.profile', compact('data'));
    }

    public function changePassword(Request $request)
    {
        $validate = ValidationHelper::validateWithoutAutoRedirect($request, [
            'old_password' => 'required',
            'password' => [
                'required', 'confirmed', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ]
        ]);
        if ($validate->fails()) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => $validate->messages()->first()
            ]);
            return back();
        }

        $user = User::findOrFail(auth()->user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'Password Lama Tidak Sesuai!'
            ]);
            return back();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        FlashMessageHelper::swal([
            'icon' => 'success',
            'title' => 'Rubah password berhasil!'
        ]);
        return back();
    }

    public function mahasiswa_umm(){
        return view('mahasiswa.biodata.profile_umm');
    }

}
