<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnouncementAttachment extends BaseModel
{
    protected $fillable = ['name', 'path', 'announcement_id'];
}
