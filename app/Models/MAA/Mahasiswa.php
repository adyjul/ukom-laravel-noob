<?php

namespace App\Models\MAA;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\MAA\Agama;

class Mahasiswa extends Authenticatable
{
    protected $connection = 'neomaa';
    protected $table = "master_siswa";
    protected $primaryKey = 'kode_siswa';

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'ref_agama', 'id');
    }
}
