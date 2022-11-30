<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('auth.login.get');
        // }
        $user = auth()->user();

        if ($user) {
            // Jika role user sekarang admin maka balik ke dashboard admin
            if ($user->user_type == 1)
                return redirect(route('admin.dashboard.index'));
            else if ($user->user_type == 2)
                return redirect(route('prodi.dashboard.index'));
            else if ($user->user_type == 3 || $user->user_type == 4)
                return redirect(route('home.index'));
            // Seterusnya ....
        } else {
            $user = auth()->guard('mahasiswa_umm')->user();
            if ($user)
                return redirect(route('home.index'));
        }
    }
}
