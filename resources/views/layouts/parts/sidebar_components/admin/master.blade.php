@canany(['view Master_Pengumuman', 'view Master_Download', 'view Master_Slider'])
    <li class="nav-main-item {{ strpos(Route::current()->getName(), 'admin.master.') !== false ? 'open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
            href="#">
            <i class="nav-main-link-icon fa fa-gem"></i>
            <span class="nav-main-link-name">Master</span>
        </a>
        <ul class="nav-main-submenu">
            @can('view Master_Slider')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.master.slider.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.master.slider.index') }}">
                        <span class="nav-main-link-name">Slider</span>
                    </a>
                </li>
            @endcan
            @can('view Master_Pengumuman')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.master.announcement.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.master.announcement.index') }}">
                        <span class="nav-main-link-name">Pengumuman</span>
                    </a>
                </li>
            @endcan
            @can('view Master_Download')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.master.download.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.master.download.index') }}">
                        <span class="nav-main-link-name">Download</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
