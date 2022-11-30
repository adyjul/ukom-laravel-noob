<?php

namespace App\Models\Reference;

use App\Models\MAA\Dosen;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDosen extends Model
{
    use HasFactory,CanGetTableNameStatically;

    protected $guarded = [];


    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function getDosenNameAttribute()
    {
        return $this->dosen->nama_dan_gelar;
    }
}
