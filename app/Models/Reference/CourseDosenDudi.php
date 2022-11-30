<?php

namespace App\Models\Reference;

use App\Models\Master\Dudi;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDosenDudi extends Model
{
    use HasFactory,CanGetTableNameStatically;

    protected $guarded = [];

    public function dudi()
    {
        return $this->belongsTo(Dudi::class)->withTrashed();
    }

    public function getDudiNameAttribute()
    {
        return $this->dudi->name;
    }
}
