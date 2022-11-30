<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\MAA\ProgramStudi;
use App\Models\Reference\CourseDosen;
use App\Models\Reference\CourseDudi;
use App\Models\Reference\CourseMahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends BaseModel
{
    protected $guarded = [];

    protected $casts = [
      'registration_date' => 'array',
      'activity_date' => 'array'
    ];

    const VALIDATION_STATUS = [
        '1' => 'Tahap Validasi',
        '2' => 'Ditolak',
        '3' => 'Revisi',
        '4' => 'Diterima'
    ];

    const CATEGORY_COURSE = [
        '1' => 'Rintisan',
        '2' => 'Sudah Berjalan'
    ];

    use HasFactory;

    public function CourseDudi()
    {
        return $this->hasMany(CourseDudi::class);
    }


    public function Dosen()
    {
        return $this->hasMany(CourseDosen::class);
    }


    public function ProgramStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'kode');
    }

    public function getProgramStudiNameAttribute()
    {
        return $this->ProgramStudi->nama_depart;
    }

    public function acceptRegisteredUser()
    {
        return $this->hasMany(CourseMahasiswa::class)->where('validation_status', '2');
    }

    public function RegisteredUser()
    {
        return $this->hasMany(CourseMahasiswa::class);
    }

    public function rejectRegisteredUser()
    {
        return $this->hasMany(CourseMahasiswa::class)->where('validation_status', '1');
    }
}
