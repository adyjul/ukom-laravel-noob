<?php

namespace App\Models\Reference;

use App\Models\MAA\Dosen;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalDosen extends Model
{
    use HasFactory, CanGetTableNameStatically;

    protected $guarded = [];
    protected $appends = ['dosen_name',];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function getDosenNameAttribute()
    {
        return $this->dosen->nama_dan_gelar;
    }
}
