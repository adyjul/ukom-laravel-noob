@canany(['Validasi_Course'])
    <li class="nav-main-item">
        <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.course.') !== false ? 'active' : '' }}"
            href="{{ route('admin.course.index') }}">
            <i class="nav-main-link-icon fas fa-book"></i>
            <span class="nav-main-link-name">Short Course</span>
        </a>
    </li>
@endcanany
