<?php

namespace App\Models\Reference;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProposalKolaborator extends Model
{
    use HasFactory, CanGetTableNameStatically;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
