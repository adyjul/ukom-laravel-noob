<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends BaseModel
{
    use HasFactory, HasImage;

    protected $fillable = ['title', 'description', 'image_path', 'button'];

    protected $casts = [
        'button' => 'array',
    ];
}
