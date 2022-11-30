<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class Announcement extends BaseModel
{
    protected $fillable = ['title', 'body',];

    public function attachments()
    {
        return $this->hasMany(AnnouncementAttachment::class);
    }
}
