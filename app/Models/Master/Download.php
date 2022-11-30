<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'path'];
}
