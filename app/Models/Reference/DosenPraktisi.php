<?php

namespace App\Models\Reference;

use App\Models\Master\Dudi;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPraktisi extends Model
{
    use HasFactory, CanGetTableNameStatically;

    protected $guarded = [];
    protected $appends = ['dudi_name'];
    protected $hidden = ['dudi'];

    public function dudi()
    {
        return $this->belongsTo(Dudi::class)->withTrashed();
    }

    public function getDudiNameAttribute()
    {
        return $this->dudi->name;
    }
}
