@can('view Prodi_Menu_Proposal')
    <li class="nav-main-item">
        <a class="nav-main-link {{ strpos(Route::current()->getName(), 'prodi.proposal.') !== false ? 'active' : '' }}"
            href="{{ route('prodi.proposal.index') }}">
            <i class="nav-main-link-icon fa fa-scroll"></i>
            <span class="nav-main-link-name">Kelas CoE</span>
        </a>
    </li>
@endcan
