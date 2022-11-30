@can('view Validasi-Proposal')
    <li class="nav-main-item">
        <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.proposal.') !== false ? 'active' : '' }}" href="{{ route('admin.proposal.index') }}">
            <i class="nav-main-link-icon fas fa-book"></i>
            <span class="nav-main-link-name">Kelas CoE</span>
        </a>
    </li>
@endcan
