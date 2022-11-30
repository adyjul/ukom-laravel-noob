<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="index.html">
            <div class="mini-logo">
                <img class="smini-visible tracking-wider" src="{{ asset('frontend/images/Logo CoE Color.png') }}" alt="">
            </div>
            <div class="d-flex justify-content-center" style="width:12rem">
                <img class="smini-hide tracking-wider" src="{{ asset('frontend/images/Logo CoE Color.png') }}" alt=""
                    style="width: 90px">
            </div>
        </a>
        <!-- END Logo -->
        <!-- Extra -->
        <div>

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <hr>
        <!-- Side Navigation -->
        <div class="content-side">
            <!-- main item -->
            <ul class="nav-main">
                {{-- Sidebar Admin --}}
                @if (auth()->user()->user_type == 1)
                    @include('layouts.parts.sidebar_components.admin.index')
                @endif
                {{-- Sidebar Admin END --}}

                {{-- Sidebar Prodi --}}
                @if (auth()->user()->user_type == 2)
                    @include('layouts.parts.sidebar_components.prodi.index')
                @endif
                {{-- Sidebar Prodi END --}}
            </ul>
            <!-- end main item -->

        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
