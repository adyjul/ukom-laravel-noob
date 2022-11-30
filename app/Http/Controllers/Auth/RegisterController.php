<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MAA\ProgramStudi;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function index()
    {
        $data['prodi'] = ProgramStudi::where('hapus', 0)->get();
        return view('auth.register', compact('data'));
    }

    public function store(Request $request)
    {
        $validate = ValidationHelper::validate($request, [
            'prodi' => ['required'],
            'name' => ['required'],
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:' . User::getTableName(),
            'email' => 'required|email|unique:' . User::getTableName(),
            'username' => 'required|unique:' . User::getTableName(),
            'password' => [
                'required', 'min:8', 'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ]
        ], [], [
            'name' => 'Nama Penganggung Jawab',
            'phone' => 'Nomor Telepon Penganggung Jawab',
        ]);

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
        $user = User::create([
            'prodi_id' => $request->prodi,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_type' => "2"
        ]);
        $role = Role::find(2);
        $user->assignRole($role);
        DB::commit();

        FlashMessageHelper::swal([
            'icon' => 'success',
            'title' => 'Pendaftaran berhasil!'
        ]);;
        return redirect(route('auth.login.get'));
    }
}
