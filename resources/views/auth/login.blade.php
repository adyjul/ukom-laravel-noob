@extends('layouts.master-auth')
@section('page-title', 'Login')


@section('content')
    <!-- Sign In Section -->
    <div class="bg-white col-md-12">
        <div class="content content-full ">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 py-4">
                    <!-- Header -->
                    <div class="text-center">
                        <img src="{{ asset('frontend/images/Logo CoE Color.png') }}" alt="" style="width: 10rem;">
                        <hr>
                        <h1 class="h4 mb-1 font-weight-bold">
                            MASUK
                        </h1>
                        {{-- <h2 class="h6 font-w400 text-muted mb-3">
                                A perfect match for your project
                            </h2> --}}
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-signin" action="{{ route('auth.login.post') }}" method="POST">
                        @csrf
                        <div class="py-3">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg form-control-alt"
                                    id="login-username" name="username" placeholder="Username atau Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg form-control-alt"
                                    id="login-password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="d-md-flex align-items-md-center justify-content-md-between">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="login-remember"
                                            name="remember">
                                        <label class="custom-control-label font-w400" for="login-remember">Remember
                                            Me</label>
                                    </div>
                                    {{-- <div class="py-2">
                                            <a class="font-size-sm font-w500"
                                                href="op_auth_reminder2.html">Forgot Password?</a>
                                        </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-12 d-flex">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div class="g-recaptcha mx-auto" data-sitekey="6Lcuw6chAAAAAJW10Z2nX1LDJJCFybWHH_uswAOq"></div>
                                {{-- <div class="g-recaptcha mx-auto" data-sitekey="6LfrrQkjAAAAANatXfa6DiZUTfY1Vn22yu6txTiy"></div> --}}
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-6 col-xl-5">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                                </button>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0 text-center">
                            <div class="col-md-6 col-xl-5">
                                <a href="{{ route('forget.password.index') }}">Lupa password?</a>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0 text-center">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ $data['register_url'] }}" style="cursor: pointer">Daftar Akun</a>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign In Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Sign In Section -->
@endsection

@section('scripts')
@endsection
