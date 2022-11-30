<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MAA\Mahasiswa;
use App\Models\User;
use App\Utils\CurlHelper;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function loginGet(Request $request)
    {
        if ($request->type == "mahasiswa_umm") {
            $data['register_url'] = $request->type == "mahasiswa_umm" ? route('mahasiswa.register.index') : route('auth.register.get.index');
            return view('auth.login_mahasiswa_umm', compact('data'));
        } else if ($request->type == 'mahasiswa' || $request->type == 'umum') {
            $data['register_url'] = $request->type == "mahasiswa" || $request->type == "umum" ? route('mahasiswa.register.index', ['type' => $request->type]) : route('auth.register.get.index');
            return view('auth.login', compact('data'));
        } else {
            $data['register_url'] = route('auth.register.get.index');
            return view('auth.login', compact('data'));
        }
    }

    public function loginPost(Request $request)
    {
        $validation = ValidationHelper::validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::whereUsername($request->username)->orWhere('email', $request->username)->first();
        if ($user == null) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'Username atau password salah!'
            ]);
            return back();
        }
        if (!Hash::check($request->password, $user->password)) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'Username atau password salah!'
            ]);
            return back();
        }
        $remember = $request->has('remember') ? true : false;

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

        Auth::loginUsingId($user->id, $remember);

        $route = route('auth.login.get');
        if ($user->user_type == 1)
            $route = (route('admin.dashboard.index'));
        else if ($user->user_type == 2)
            $route = (route('prodi.dashboard.index'));
        else if ($user->user_type == 3 || $user->user_type == 4)
            $route = (route('home.index'));
        return redirect()->intended($route);
    }

    public function logout()
    {
        if (auth()->guard('mahasiswa_umm')->check())
            auth()->guard('mahasiswa_umm')->logout();
        else
            auth()->logout();

        return redirect(route('home.index'));
    }

    public function loginMahasiswaUmm(Request $request)
    {

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

        ValidationHelper::validate($request, [
            'nim' => 'required',
            'pic' => 'required',
        ]);

        $curl = CurlHelper::get("https://infokhs.umm.ac.id/api/mahasiswa/login/484bc5b4d8ca6fb1f43c970be52732c7/" . $request->nim . "/" . $request->pic);


        if ($curl['status'] == "0") {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'NIM atau PIC salah!'
            ]);
            return back();
        }

        $mahasiswa = Mahasiswa::where('kode_siswa', $request->nim)->first();

        if ($mahasiswa == null) {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'NIM atau PIC salah!'
            ]);
            return back();
        }

        $remember = $request->has('remember') ? true : false;
        Auth::guard('mahasiswa_umm')->login($mahasiswa, $remember);

        $route = (route('home.index'));
        return redirect($route);
    }
}
