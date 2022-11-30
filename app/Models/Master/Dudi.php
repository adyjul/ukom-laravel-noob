<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dudi extends BaseModel
{
    use HasFactory;

    const HAS_MOU = [
        "0" => 'tidak',
        '1' => 'ya'
    ];

    protected $guarded = [];
}
