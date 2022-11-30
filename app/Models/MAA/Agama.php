<?php

namespace App\Models\MAA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;

    protected $connection = 'neomaaref';
    protected $table = "in_agama";
    protected $primaryKey = 'id';
}
