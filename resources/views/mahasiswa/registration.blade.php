@extends('layouts.master-auth')

@section('page-title', 'Mahasiswa | Daftar Akun')

{{-- @section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection --}}

@section('content')
    <!-- Sign Up Section -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 py-4">
                    <!-- Header -->
                    <div class="text-center">
                        <img src="{{ asset('frontend/images/Logo CoE Color.png') }}" alt="" style="width: 10rem;">
                        <hr>
                        <h1 class="h4  mb-1">
                            Daftar Akun Mahasiswa
                        </h1>
                    </div>
                    <!-- END Header -->

                    <!-- Sign Up Form -->
                    <form class="js-validation-signup" action="{{ route('mahasiswa.register.store') }}" method="POST"
                        autocomplete="off">
                        @csrf
                        <div class="py-3">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="name" name="name"
                                    placeholder="Nama" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone"
                                    placeholder="Nomor Telepon" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="username" name="username"
                                    placeholder="Username" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="password" name="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirmasi Password">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control form-control-lg" id="user_type"
                                    name="user_type" value="{{$data['user_type']}}">
                            </div>
                            <small>Aturan Password:
                                <ul>
                                    <li>Minimal 8 karakter</li>
                                    <li>Minimal terdapat 1 huruf besar</li>
                                    <li>Minimal terdapat 1 huruf kecil</li>
                                    <li>Minimal terdapat 1 angka</li>
                                </ul>
                            </small>
                        </div>
                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-6 col-xl-5">
                                <button type="submit" class="btn btn-block btn-success">
                                    <i class="fa fa-fw fa-plus mr-1"></i> Daftar
                                </button>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-12 text-center">
                                <hr>
                                <span>Sudah punya akun? <a
                                        href="{{ route('auth.login.get', ['type' => 'mahasiswa']) }}">Masuk</a></span>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Sign Up Section -->
@endsection
