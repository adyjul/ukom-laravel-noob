<?php

namespace App\Http\Controllers\ForgetPassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index($token)
    {
        $data = DB::table('password_resets')->where('token', $token)->first();

        if ($data == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data reset password tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }
        return view('forget_password.reset_password', compact('data'));
    }

    public function store($token, Request $request)
    {
        $validation = ValidationHelper::validateWithoutAutoRedirect(
            $request,
            [
                'password' => [
                    'required', 'min:8', 'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                ],
            ],
            [
                'confirmed' => 'Konfirmasi :attribute tidak sama.'
            ],
            [
                'password' => 'Password',
                'password_confirmation' => 'Ulangi Password'
            ]
        );
        if ($validation->fails()) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => $validation->messages()->first()
            ]);
            return back();
        }
        $data = DB::table('password_resets')->where('token', $token)->first();
        if ($data == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data reset password tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }

        $user = User::where('email', $data->email)->first();
        if ($user == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data User tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }

        // CHECK RECHAPCH START
        $post = [
            'secret' => '6Lcuw6chAAAAAGDTIHPZQKfoBUME7r0oQo5AKLUm',
            // 'secret' => '6LfrrQkjAAAAAE4yHRmYL5M3v9loiRKz5vpnLVP2',
            'response' => $request['g-recaptcha-response']
        ];

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        $response = json_decode($response, true);
        // do anything you want with your response
        if (!$response['success']) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'Recaptcha tidak valid!'
            ]);
            return back();
        }
        // CHECK RECHAPCH END

        DB::beginTransaction();
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::commit();

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Reset Password Berhasil!"
        ]);
        return redirect(route('auth.login.get'));
    }
}
