<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeployController;
use App\Models\MAA\Agama;
use App\Models\MAA\Dosen;
use App\Utils\CurlHelper;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('deploy/kucingkucantikdanmanis', function () {
    $process = Process::fromShellCommandline('cd ' . base_path() . '; git reset --hard ;git pull github main;chmod -R 777 storage/; chmod -R 777 public/;php artisan cache:clear; php artisan config:cache; php artisan route:cache; php artisan view:cache');
    $process->run(function ($type, $buffer) {
        echo $buffer;
    });
    // $process = Process::fromShellCommandline('git reset --hard');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
    // $process = Process::fromShellCommandline('git pull');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
    // $process = Process::fromShellCommandline('cd ' . base_path() . '; php artisan cache:clear');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
    // $process = Process::fromShellCommandline('cd ' . base_path() . '; php artisan config:cache');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
    // $process = Process::fromShellCommandline('cd ' . base_path() . '; php artisan route:cache');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
    // $process = Process::fromShellCommandline('cd ' . base_path() . '; php artisan view:cache');
    // $process->run(function ($type, $buffer) {
    //     echo $buffer;
    // });
});
