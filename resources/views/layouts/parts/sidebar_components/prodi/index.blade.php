<li class="nav-main-item">
    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'prodi.dashboard.') !== false ? 'active' : '' }}"
        href="{{ route('admin.dashboard.index') }}">
        <i class="nav-main-link-icon si si-speedometer"></i>
        <span class="nav-main-link-name">Dashboard</span>
    </a>
</li>
@include('layouts.parts.sidebar_components.prodi.dudi')

@include('layouts.parts.sidebar_components.prodi.proposal')

@include('layouts.parts.sidebar_components.prodi.course')
