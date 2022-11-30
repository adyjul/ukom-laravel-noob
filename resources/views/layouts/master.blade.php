<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name') }} | @yield('page_title')</title>

    <meta name="description"
        content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
        content="OneUI - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Fonts and OneUI framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('oneUI') }}/css/oneui.min.css">
    <link rel="stylesheet" id="css-main" href="{{ asset('oneUI') }}/css/custom.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <style>
        .content-title.diterima {
            border-top: 10px solid #30c78d !important
        }

        .content-title.ditolak {
            border-top: 10px solid #e56767 !important
        }

        .content-title.direvisi {
            border-top: 10px solid #e5ae67 !important
        }

        .content-title {
            border-top: 10px solid #5179d6 !important
        }


        .content-title-left.diterima {
            border-left: 4px solid #30c78d !important
        }

        .content-title-left.ditolak {
            border-left: 4px solid #e56767 !important
        }

        .content-title-left.direvisi {
            border-left: 4px solid #e5ae67 !important
        }

        .content-title-left {
            border-left: 4px solid #5179d6 !important
        }


        .nav-tabs-block.diterima {
            background-color: #30c78d !important
        }

        .nav-tabs-block.ditolak {
            background-color: #e56767 !important
        }

        .nav-tabs-block.direvisi {
            background-color: #e5ae67 !important
        }

        .nav-tabs-block {
            background-color: #5179d6 !important
        }

        .cl-danger{
            color: #e56767;
        }

        .cl-primary{
            color: #5179d6;
        }

        .cl-warning{
            color: #e5ae67;
        }

        .cl-success{
            color:#30c78d;
        }

        .nav-tabs-block a {
            color: white !important;
        }

        .nav-tabs-block .nav-item.show .nav-link,
        .nav-tabs-block .nav-link.active {
            color: black !important;
        }

        .nav-tabs-block .nav-link:focus,
        .nav-tabs-block .nav-link:hover {
            color: black !important;
            transition: .3s ease-in-out all;
        }

        .bg-icon {
            font-size: 11rem;
            position: absolute;
            top: 6px;
            z-index: 0;
            opacity: 0.2;
            right: -25px;
        }

        .bg-icon.diterima {
            color: #30c78d !important
        }

        .bg-icon.ditolak {
            color: #e56767 !important
        }

        .bg-icon.direvisi {
            color: #e5ae67 !important
        }

        .bg-icon {
            color: #5179d6 !important
        }

        .badge {
            padding: 7px;
            border-radius: 20px;
            font-size: 13px;
        }
        .pemberitahuan_password {
            font-family:'Times New Roman', Times, serif;
            font-weight: 400;
            color: #900;
            font-size: 10px;
        }

    </style>
    @stack('styles')

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <div class="loading overlay" style="display: none">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="content-header border-bottom">
                <!-- User Avatar -->
                <a class="img-link mr-1" href="javascript:void(0)">
                    <!-- <img class="img-avatar img-avatar32" src="assets/media/avatars/avatar10.jpg" alt=""> -->
                </a>
                <!-- END User Avatar -->

                <!-- User Info -->
                <div class="ml-2">
                    <a class="text-dark font-w600 font-size-sm" href="javascript:void(0)">Adam McCoy</a>
                </div>
                <!-- END User Info -->

                <!-- Close Side Overlay -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="ml-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout"
                    data-action="side_overlay_close">
                    <i class="fa fa-fw fa-times"></i>
                </a>
                <!-- END Close Side Overlay -->
            </div>
            <!-- END Side Header -->

        </aside>
        <!-- END Side Overlay -->

        <!-- Sidebar -->
        @include('layouts.parts.sidebar')
        <!-- END Sidebar -->

        <!-- Header -->
        @include('layouts.parts.header')
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Hero -->
            <div class="bg-body-light">
                <div class="content content-full">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                        <h1 class="flex-sm-fill h3 my-2">
                            @yield('page_title') <small
                                class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">@yield('page_sub_title')</small>
                        </h1>
                        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                            @yield("breadcrumb")
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END Hero -->

            <!-- Page Content -->
            <div class="container-content">
                @yield('content')
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        @stack('modals')

        <!-- Footer -->
        <footer id="page-footer" class="bg-body-light">
            <div class="content py-3">
                <div class="row font-size-sm">
                    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">
                        Develop by <a class="font-w600" href="http://infokom.umm.ac.id/" target="_blank">Infokom
                            UMM</a>
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                        <a class="font-w600" href="" target="_blank">OneUI 4.8</a>
                        &copy; <span data-toggle="year-copy"></span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->
    <script src="{{ asset('oneUI') }}/js/oneui.core.min.js"></script>
    <script src="{{ asset('oneUI') }}/js/oneui.app.min.js"></script>
    {{-- <script src="{{ asset('oneUI') }}/js/custom.js"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>

    @include('layouts.alerts.alert')
    @include('layouts.alerts.sweetalert')
    @include('layouts.alerts.input-invalid')
    @include('layouts.parts.loader')
    @stack('scripts')

    <script>
        $(document).tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    </script>
</body>

</html>
