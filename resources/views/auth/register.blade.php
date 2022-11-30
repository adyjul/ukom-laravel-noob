@extends('layouts.master-auth')

@section('page-title', 'Prodi | Daftar Akun')

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
                            Daftar Akun Prodi
                        </h1>
                    </div>
                    <!-- END Header -->

                    <!-- Sign Up Form -->
                    <form class="js-validation-signup" action="{{ route('auth.register.post.store') }}" method="POST"
                        autocomplete="off">
                        @csrf
                        <div class="py-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="select2 form-control form-control-lg" id="prodi" name="prodi"
                                        style="width: 100%;" required>
                                        <option value="" disabled selected>-- Prodi --</option>
                                        @foreach ($data['prodi'] as $prodi)
                                            <option value="{{ $prodi->kode }}"
                                                {{ old('prodi') == $prodi->kode ? 'selected' : '' }}>
                                                {{ $prodi->nama_depart }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="name" name="name"
                                    placeholder="Nama Penanggung Jawab" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone"
                                    placeholder="Nomor Telepon Penanggung Jawab" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="Email Penanggung Jawab" value="{{ old('email') }}">
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

                            <small>Aturan Password:
                                <ul>
                                    <li>Minimal 8 karakter</li>
                                    <li>Minimal terdapat 1 huruf besar</li>
                                    <li>Minimal terdapat 1 huruf kecil</li>
                                    <li>Minimal terdapat 1 angka</li>
                                </ul>
                            </small>

                        </div>
                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-12 d-flex">
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <div class="g-recaptcha mx-auto" data-sitekey="6Lcuw6chAAAAAJW10Z2nX1LDJJCFybWHH_uswAOq">
                                {{-- <div class="g-recaptcha mx-auto" data-sitekey="6LfrrQkjAAAAANatXfa6DiZUTfY1Vn22yu6txTiy"> --}}
                                </div>
                            </div>
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
                                <span>Sudah punya akun? <a href="{{ route('auth.login.get') }}">Masuk</a></span>
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

@include('layouts.select2.bootstrap4')

@section('scripts')
    <script>
        $(document).ready(() => {
            $('.select2').select2();
        })
    </script>
@endsection
