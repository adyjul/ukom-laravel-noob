<?php
namespace App\Http\Controllers;

use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function deploy()
    {
        $process = Process::fromShellCommandline('cd ' . base_path() . '; git reset --hard ;git pull origin main;chmod -R 777 storage/; chmod -R 777 public/;php artisan cache:clear; php artisan config:cache; php artisan route:cache; php artisan view:cache');
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
