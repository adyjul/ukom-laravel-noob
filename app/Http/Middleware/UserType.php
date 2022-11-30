<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Utils\FlashMessageHelper;
use Closure;
use Illuminate\Http\Request;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$userType)
    {
        $user = auth()->guard('web')->user();
        if ($user) {
            if (!in_array(User::user_type[$user->user_type], $userType)) {
                FlashMessageHelper::bootstrapDangerAlert('Tipe user anda:' . User::user_type[$user->user_type] . '. Yang dibutuhkan: ' . implode(',', $userType), 'Tipe User Tidak Sesuai.');

                if ($request->header('ajax') == "1" || $request->expectsJson() || $request->ajax() || strpos($request->header('Content-Type'), 'application/json') !== false) {
                    return response()->json([
                        'code' => '400',
                        'message' => 'Tipe user anda:' . User::user_type[$user->user_type] . '. Yang dibutuhkan: ' . implode('/', $userType), 'Tipe User Tidak Sesuai.',
                    ]);
                } else {
                    // Jika role user sekarang admin maka balik ke dashboard admin
                    if ($user->user_type == 1) {
                        return redirect(route('admin.dashboard.index'));
                    } else if ($user->user_type == 2) {
                        return redirect(route('prodi.dashboard.index'));
                    } else if ($user->user_type == 3 || $user->user_type == 4) {
                        return redirect(route('home.index'));
                    }
                    // Seterusnya ....
                }
            }
        }
        return $next($request);
    }
}
