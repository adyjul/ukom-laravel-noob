<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Of Excellence</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @stack('styles')
</head>

<style>
    .navbar-light .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
    }

</style>

<body>
    <div class="loading overlay" style="display: none">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <header>
        @include('layouts.parts.frontend.navbar')
    </header>

    <div @yield('page') id="content_page">
        @yield('content')
    </div>

    <footer id="footer">
        @include('layouts.parts.frontend.footer')
    </footer>

    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script>
        $('.login_akun').click(function(e){
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda mahasiswa UMM?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Iya',
                denyButtonText: `Tidak`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('auth.login.get', ['type' => 'mahasiswa_umm']) }}'
                } else if (result.isDenied) {
                    window.location.href = '{{ route('auth.login.get', ['type' => 'mahasiswa']) }}'
                }
            })
        })
    </script>
    @include('layouts.alerts.sweetalert')
    @stack('scripts')
</body>

</html>
