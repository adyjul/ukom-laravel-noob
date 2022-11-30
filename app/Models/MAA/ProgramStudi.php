<?php

namespace App\Models\MAA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;
    protected $connection = 'neomaaref';
    protected $table = "in_programstudi";
    protected $primaryKey = 'kode';

    public function kaprodi()
    {
        return $this->belongsTo(Dosen::class, 'kajur', 'no_dosen');
    }
}
