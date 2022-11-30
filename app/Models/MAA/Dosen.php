<?php

namespace App\Models\MAA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $appends = ['nama_dan_gelar'];


    protected $connection = 'neomaa';
    protected $table = "master_dosen";
    protected $primaryKey = 'no_dosen';

    public function getNamaDanGelarAttribute()
    {
        return $this->namaDosen . ' ' . $this->gelarLengkap;
    }
}
