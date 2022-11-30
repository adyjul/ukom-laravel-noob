<?php

namespace App\Utils;

class PermissionHelper
{
    const SPECIAL_PERMISSIONS = [
        // name => description
        'Super-Admin' => 'Bypass all permissions, for Administrators only',
        'Dashboard-Admin' => 'Melihat isi dashboard admin',
        'Dashboard-Prodi' => 'Melihat isi dashboard prodi',
        'Validasi-Proposal' => 'Dapat melakukan validasi proposal prodi',
        'Lihat-Laporan' => 'Dapat melihat semua sub menu laporan',
    ];

    const ACTIONS = [
        'view', 'create', 'update', 'delete', 'restore'
    ];

    const PERMISSIONS = [
        // Admin permission start
        'Admin_Pengaturan_User' => [
            'Pengaturan_User_Perizinan',
            'Pengaturan_User_User',
        ],
        'Master' => [
            'Master_Slider',
            'Master_Pengumuman',
            'Master_Download',
        ],

        'Validasi-Proposal' =>[
            'Validasi-Proposal'
        ],

        'Validasi_Course' =>[
            'Validasi_Course'
        ],
        // Admin permission end



        // Prodi permission start
        'Prodi_Menu_Proposal' => [
            'Prodi_Menu_Proposal',
        ],
        'Prodi_Menu_Dudi' => [
            'Prodi_Menu_Dudi',
        ],
        'Prodi_Menu_Course' => [
            'Prodi_Menu_Course'
        ]
        // Prodi permission end

    ];
}
