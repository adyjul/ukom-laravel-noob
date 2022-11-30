<?php

namespace App\Http\Middleware;

use App\Utils\FlashMessageHelper;
use Closure;
use Illuminate\Http\Request;

class MahasiswaHasBeenCompleteBiodata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->guard('web')->user();
        if ($user) {
            $mahasiswa = $user->mahasiswa;

            // mahasiswa sama sekali belum melengkapi data
            if (!$mahasiswa) {
                return $this->error($request);
            }

            $profile = ['nim', 'birth_place', 'birth_date', 'sex', 'religion_id'];
            $address = ['province_id', 'regency_id', 'district_id', 'village_id'];
            $university = ['name', 'address'];

            $mahasiswaProfile = array_keys($mahasiswa->profile);
            foreach ($profile as $p) {
                if (!in_array($p, $mahasiswaProfile)) {
                    return $this->error($request);
                }
            }
            $mahasiswaAddress = array_keys($mahasiswa->address);
            foreach ($address as $p) {
                if (!in_array($p, $mahasiswaAddress)) {
                    return $this->error($request);
                }
            }

            $mahasiswaUniversity = array_keys($mahasiswa->university);
            foreach ($university as $p) {
                if (!in_array($p, $mahasiswaUniversity)) {
                    return $this->error($request);
                }
            }
        }

        return $next($request);
    }

    private function error($request)
    {
        if ($request->header('ajax') == "1" || $request->expectsJson() || $request->ajax() || strpos($request->header('Content-Type'), 'application/json') !== false) {
            return response()->json([
                'code' => '400',
                'message' => 'Silahkan melengkapi biodata terlebih dahulu!',
            ]);
        } else {
            FlashMessageHelper::swal([
                'icon' => 'error',
                'title' => 'Silahkan melengkapi biodata terlebih dahulu!'
            ]);
            return redirect(route('mahasiswa.biodata.index'));
        }
    }
}
