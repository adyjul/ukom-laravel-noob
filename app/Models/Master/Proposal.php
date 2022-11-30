<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\MAA\ProgramStudi;
use App\Models\Reference\DosenPraktisi;
use App\Models\Reference\ProposalDosen;
use App\Models\Reference\ProposalDudi;
use App\Models\Reference\ProposalKolaborator;
use App\Models\Reference\ProposalMahasiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends BaseModel
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['program_studi_name'];

    const VALIDATION_STATUS = [
        '1' => 'Tahap Validasi',
        '2' => 'Ditolak',
        '3' => 'Revisi',
        '4' => 'Diterima'
    ];

    const CHECKLIST = [
        1 => "Proposal",
        2 => "Kategori",
        3 => "RAB",
        4 => "Kurikulum",
        5 => "Data Dosen PT",
        6 => "Data Pengajar DUDI",
        7 => "MOU DUDI",
        // 8 => "Link Dokumentasi (Google Drive)",
        // 9 => "SK Konversi Dekan/Mata Kuliah",
        9 => "Dokumen Informasi Magang",
        // 11 => "Kategori Waktu",
        // 12 => "Jumlah Mahasiswa",
        13 => "Capaian Luaran",
        14 => "Keterangan",
    ];

    protected $casts = [
        // 'dudi' => 'array',
        // 'prodi' => 'array',
        'class_description' => 'array',
        'checklist' => 'array',
        'proposal_files' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryProposal::class, 'category_proposal_id', 'id');
    }

    public function getValidationStatusTextAttribute()
    {
        return self::VALIDATION_STATUS[$this->validation_status];
    }

    public function getProgramStudiNameAttribute()
    {
        return $this->ProgramStudi->nama_depart;
    }

    public function ProgramStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id', 'kode');
    }

    public function DosenPraktisi()
    {
        return $this->hasMany(DosenPraktisi::class);
    }

    public function Dosen()
    {
        return $this->hasMany(ProposalDosen::class);
    }

    public function ProposalDudi()
    {
        return $this->hasMany(ProposalDudi::class);
    }

    public function acceptRegisteredUser()
    {
        return $this->hasMany(ProposalMahasiswa::class)->where('validation_status', '2');
    }

    public function RegisteredUser()
    {
        return $this->hasMany(ProposalMahasiswa::class);
    }

    public function rejectRegisteredUser()
    {
        return $this->hasMany(ProposalMahasiswa::class)->where('validation_status', '1');
    }

    public function kolaborator()
    {
        return $this->belongsToMany(User::class, ProposalKolaborator::getTableName());
    }
}
