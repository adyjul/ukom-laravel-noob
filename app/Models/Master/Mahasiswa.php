<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\Region\District;
use App\Models\Region\Province;
use App\Models\Region\Regency;
use App\Models\Region\Village;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'profile' => 'array',
        'address' => 'array',
        'university' => 'array',
    ];
    protected $appends = ['birth_place', 'full_address'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBirthPlaceAttribute()
    {
        return Regency::find($this->profile['birth_place'])['name'];
    }

    public function getFullAddressAttribute()
    {
        $village = Village::find($this->address['village_id'])['name'];
        $district = District::find($this->address['district_id'])['name'];
        $regency = Regency::find($this->address['regency_id'])['name'];
        $province = Province::find($this->address['province_id'])['name'];
        return $village . ', ' . $district . ', ' . $regency . ', ' . $province;
    }
}
