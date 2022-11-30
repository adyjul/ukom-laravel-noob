@canany(['Lihat-Laporan'])
    <li class="nav-main-item {{ strpos(Route::current()->getName(), 'admin.laporan.') !== false ? 'open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
            href="#">
            <i class="nav-main-link-icon fa fa-gem"></i>
            <span class="nav-main-link-name">Laporan</span>
        </a>
        <ul class="nav-main-submenu">
            @can('Lihat-Laporan')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.laporan.jumlah-proposal-prodi.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.laporan.jumlah-proposal-prodi.index') }}">
                        <span class="nav-main-link-name">Jumlah Proposal Prodi</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
