<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\UserStampObserver;
use App\Traits\CanGetTableNameStatically;
use App\Traits\UserStamp;
use Carbon\Carbon;

class BaseModel extends Model
{
    use HasFactory,  CanGetTableNameStatically, UserStamp, SoftDeletes;

    // this can make vulnerability
    // protected $guarded = [];
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }
    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withTrashed();
    }
    public function restoredByUser()
    {
        return $this->belongsTo(User::class, 'restored_by')->withTrashed();
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('H:i / d F Y ');
    }

    public function getFormattedDateColumnAttribute($column, $format = 'H:i / d F Y ')
    {
        return Carbon::parse($this->$column)->translatedFormat($format);
    }
}
