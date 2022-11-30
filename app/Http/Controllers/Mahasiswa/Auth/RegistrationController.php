<?php

namespace App\Http\Controllers\Mahasiswa\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $data['user_type'] = $request->type == "mahasiswa" ? "3" : "4";

        return view('mahasiswa.registration', compact('data'));
    }

    public function store(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'name' => 'required',
                'username' => 'required|unique:' . User::getTableName(),
                'email' => 'required|email|unique:' . User::getTableName(),
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:12||unique:' . User::getTableName(),
                'password' => [
                    'required', 'min:8', 'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                ],
            ],
            [
                'min' => 'Kolom :attribute minimal terdiri dari :min karakter.',
                'unique' => ':attribute sudah digunakan.',
                'confirmed' => ':attribute tidak sama.',
                'email' => 'Format email tidak valid.'
            ],
            [
                'name' => 'Nama Lengkap',
                'username' => 'Username',
                'phone' => 'No HP (Whatsapp)',
                'password' => 'Password',
                'password_confirmation' => 'Ulangi Password'
            ]
        );

        DB::beginTransaction();
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type
        ]);
        DB::commit();

        FlashMessageHelper::swal([
            'icon' => 'success',
            'title' => 'Pendaftaran berhasil, silahkan login menggunakan username dan password'
        ]);

        return redirect(route('auth.login.get'));
    }
}
