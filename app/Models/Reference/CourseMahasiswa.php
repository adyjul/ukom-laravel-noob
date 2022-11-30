<?php

namespace App\Models\Reference;
use App\Models\Master\Mahasiswa;
use App\Models\MAA\Mahasiswa as MahasiswaUmm;
use App\Models\Master\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMahasiswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    const VALIDATION_STATUS = [
        '0' => 'Tahap Validasi',
        '1' => 'Ditolak',
        '2' => 'Diterima'
    ];

    public function mahasiswa()
    {
        if ($this->belongsTo(Mahasiswa::class)->withTrashed()->exists()) {
            return $this->belongsTo(Mahasiswa::class)->withTrashed();
        } else {
            return $this->belongsTo(MahasiswaUmm::class, 'nim', 'kode_siswa');
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function getValidationStatusTextAttribute()
    {
        return self::VALIDATION_STATUS[$this->validation_status];
    }

    public function getFormattedDateColumnAttribute($column, $format = 'H:i / d F Y ')
    {
        return Carbon::parse($this->$column)->translatedFormat($format);
    }
}

