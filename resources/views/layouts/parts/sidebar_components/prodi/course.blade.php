@can('view Prodi_Menu_Course')
    <li class="nav-main-item">
        <a class="nav-main-link {{ strpos(Route::current()->getName(), 'prodi.course.') !== false ? 'active' : '' }}"
            href="{{ route('prodi.course.index') }}">
            <i class="nav-main-link-icon fas fa-graduation-cap"></i>
            <span class="nav-main-link-name">Short Course</span>
        </a>
    </li>
@endcan
