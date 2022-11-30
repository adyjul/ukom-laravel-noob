<?php

namespace App\Models;

use App\Models\MAA\ProgramStudi;
use App\Models\Master\Mahasiswa;
use App\Models\Master\Proposal;
use App\Models\Reference\ProposalKolaborator;
use App\Observers\UserStampObserver;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserStamp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, CanGetTableNameStatically, UserStamp;
    use SoftDeletes;

    const user_type = [
        "1" => 'Admin',
        "2" => 'Prodi',
        "3" => 'Mahasiswa',
        "4" => 'Umum'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'user_type',
        'prodi_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'prodi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['prodi_name'];


    public function role()
    {
        return $this->hasOne(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'kode');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'created_by', 'id');
    }

    public function createdByUser()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
    public function updatedByUser()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
    public function deletedByUser()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }
    public function restoreByUser()
    {
        return $this->belongsTo('App\Models\User', 'restored_by');
    }

    public function getFormattedDateColumnAttribute($column)
    {
        return Carbon::parse($this->$column)->translatedFormat('h:i / d F Y ');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function proposal_kolaborasi()
    {
        return $this->belongsToMany(Proposal::class, ProposalKolaborator::getTableName());
    }

    public function getUsernameAndProdiAttribute()
    {
        return $this->username . " | " . $this->prodi->nama_depart;
    }

    public function getProdiNameAttribute()
    {
        if ($this->prodi_id)
            return $this->prodi->nama_depart;
        else
            return "";
    }
}
