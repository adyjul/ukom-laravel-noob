<style>
    .card-top {
        height: 5px;
    }

    .link-login {
        font-size: 20px
    }

    .icon-portal {
        font-size: 25px;
    }

</style>

<nav class="navbar shadow navbar-expand-lg navbar-light bg-transparent header">
    <div class="container">
        <a href="{{ route('home.index') }}">
            <img src="{{ asset('frontend/images/Logo CoE.png') }}" class="top-logo">
        </a>
        <button class="navbar-toggler navbar-collapse-right no-border" type="button" data-toggle="collapse"
            data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @if (auth()->check())
        <div class="dropdown mobile-dropdown">
            <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img src="{{ asset('frontend/images/person.svg') }}" class="mobile-account" style="width: 2.2rem;"
                    alt="">
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="imageDropdown">
                {{-- <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        <i class="fa fa-cog mb-2" aria-hidden="true"></i> Setting
                    </a>
                </li> --}}
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ route('mahasiswa.profile.index') }}">
                        <i class="fa fa-user" aria-hidden="true"></i> Profile
                    </a>
                </li>
                <hr>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ route('auth.logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        @elseif (auth()->guard('mahasiswa_umm')->check())
        <div class="dropdown mobile-dropdown">
            <a href="#" id="imageDropdown" data-toggle="dropdown">
                <img src="{{ asset('frontend/images/person.svg') }}" class="mobile-account" style="width: 2.2rem;"
                    alt="">
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="imageDropdown">
                {{-- <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        <i class="fa fa-cog mb-2" aria-hidden="true"></i> Setting
                    </a>
                </li> --}}
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ route('mahasiswa.profile.index') }}">
                        <i class="fa fa-user" aria-hidden="true"></i> Profile
                    </a>
                </li>
                <hr>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ route('auth.logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        @else

            <a class="btn btn-second login-mobile" style="color: white !important;font-weight: bold;" data-toggle="modal"
            data-target="#exampleModal">Login</a>
        @endif

        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav ml-auto text-center">
                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.index') !== false ? 'active' : '' }}"
                        href="{{ route('home.index') }}">
                        <p class="text-white">Beranda</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.download') !== false ? 'active' : '' }}"
                        href="{{ route('home.download') }}">
                        <p class=" text-white">Download</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.pengumuman') !== false ? 'active' : '' }}"
                        href="{{ route('home.pengumuman') }}">
                        <p class=" text-white">Pengumuman</p>
                    </a>
                </li>
                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.proposal') !== false ? 'active' : '' }}"
                            href="{{ route('home.proposal') }}">
                            <p class=" text-white" style="height: auto">Pendaftaran</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.kelas') !== false ? 'active' : '' }}"
                            href="{{ route('home.kelas') }}">
                            <p class=" text-white" style="height: auto">My Class</p>
                        </a>
                    </li>

                @elseif (auth()->guard('mahasiswa_umm')->check())
                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.proposal') !== false ? 'active' : '' }}"
                        href="{{ route('home.proposal') }}">
                        <p class=" text-white" style="height: auto">Pendaftaran</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.kelas') !== false ? 'active' : '' }}"
                        href="{{ route('home.kelas') }}">
                        <p class=" text-white" style="height: auto">My Class</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.kurikulum') !== false ? 'active' : '' }}"
                        href="{{ route('home.kurikulum') }}">
                        <p class=" text-white">Kurikulum</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link scroll-to-section {{ strpos(Route::current()->getName(), 'home.alur') !== false ? 'active' : '' }}"
                        href="{{ route('home.alur') }}">
                        <p class=" text-white">Alur</p>
                    </a>
                </li>

                @if (!auth()->check() && !auth()->guard('mahasiswa_umm')->check())
                    <li class="nav-item mt-2">
                        <button class="btn btn-second login-pc"
                            style="color: white !important;font-weight: bold;text-transform: none" data-toggle="modal"
                            data-target="#exampleModal">Login</button>
                    </li>
                @endif
            </ul>
        </div>
        @if (auth()->check())
            <div class="dropdown login-desktop">
                <a href="#" id="imageDropdown" class="mb-3" data-toggle="dropdown">
                    <img src="{{ asset('frontend/images/person.svg') }}" class="account mr-4" style="width: 150%;"
                        alt="">
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="imageDropdown">
                    {{-- <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="#">
                            <i class="fa fa-cog mb-2" aria-hidden="true"></i> Setting
                        </a>
                    </li> --}}
                    <li role="presentation" class="divider"></li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="{{ route('mahasiswa.profile.index') }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Profile
                        </a>
                    </li>
                    <hr>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="{{ route('auth.logout') }}">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        @elseif (auth()->guard('mahasiswa_umm')->check())
        <div class="dropdown login-desktop">
            <a href="#" id="imageDropdown" class="mb-3" data-toggle="dropdown">
                <img src="{{ asset('frontend/images/person.svg') }}" class="account mr-4" style="width: 150%;"
                    alt="">
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="imageDropdown">
                {{-- <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        <i class="fa fa-cog mb-2" aria-hidden="true"></i> Setting
                    </a>
                </li> --}}
                <li role="presentation" class="divider"></li>
                <li role="presentation">

                    @if (auth()->guard('mahasiswa_umm')->check())
                        <a role="menuitem" tabindex="-1" href="{{ route('mahasiswa.profile_umm.umm') }}">
                            <i class="fa fa-user" aria-hidden="true"></i>Profile
                        </a>
                    @else
                        <a role="menuitem" tabindex="-1" href="{{ route('mahasiswa.profile.index') }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Profile
                        </a>
                    @endif
                </li>
                <hr>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ route('auth.logout') }}">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        @endif
    </div>



</nav>

<div class="modal portal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold" id="exampleModalLabel">Portal Login</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <a class="login_akun" style="cursor: pointer">
                            <div class="card">
                                <div class="card-top bg-primary"></div>
                                <div class="card-body text-center mb-0">
                                    <i class="fas fa-user-alt icon-portal"></i>
                                    <p class="mb-0 mt-2 link-login">Mahasiswa</p>
                                    <hr class="mb-1 mt-1">
                                    <p class="mb-0 mt-0 font-weight-normal">Untuk peserta yang memiliki NIM <br />(Nomor Induk Mahasiswa)</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('auth.login.get', ['type'=>'umum']) }}">
                            <div class="card">
                                <div class="card-top bg-success">
                                </div>
                                <div class="card-body text-center mb-0">
                                    <i class="fas fa-chalkboard-teacher icon-portal"></i>
                                    <p class="mb-0 mt-2 link-login">Umum</p>
                                    <hr class="mb-1 mt-1">
                                    <p class="mb-0 mt-0 font-weight-normal">Untuk peserta yang tidak memiliki NIM <br />(Nomor Induk Mahasiswa)</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('auth.login.get') }}">
                            <div class="card">
                                <div class="card-top bg-success">
                                </div>
                                <div class="card-body text-center mb-0">
                                    <i class="fas fa-chalkboard-teacher icon-portal"></i>
                                    <p class="mb-0 mt-2 link-login">Prodi</p>
                                    <hr class="mb-1 mt-1">
                                    <p class="mb-0 mt-0 font-weight-normal" style="line-height: 50px">Login PIC Prodi <br /></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @php
    dd(auth()->guard('mahasiswa_umm')->user())
@endphp --}}
