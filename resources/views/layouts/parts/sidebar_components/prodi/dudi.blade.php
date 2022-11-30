@can('view Prodi_Menu_Dudi')
    <li class="nav-main-item">
        <a class="nav-main-link {{ strpos(Route::current()->getName(), 'prodi.dudi.') !== false ? 'active' : '' }}"
            href="{{ route('prodi.dudi.index') }}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">Dudi</span>
        </a>
    </li>
@endcan
