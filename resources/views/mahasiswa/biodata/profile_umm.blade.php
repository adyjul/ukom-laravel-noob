@extends('layouts.master-frontend')

@section('title', 'Mahasiswa | Profile')


@php
    $user = auth()->guard('mahasiswa_umm')->user();
@endphp

@section('content')
    <div id="profile" class="content-menu">
        <div class="container-fluid">
            @php
                $breadcrumbs = [
                    'Beranda' => route('home.index'),
                    'Profile' => '',
                ];
            @endphp
            @include('layouts.parts.frontend.breadcrub', ['datas' => $breadcrumbs])
            <div class="card card-custom p-3 border-card mb-5">
                <p class="text-center font-weight-bold judul" style="font-size:30px;margin-bottom:20px;margin-top:10px;">
                    Profile
                </p>
                <hr>
                <div class="container-fluid isi">
                    <div class="biodata">
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Nama</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ $user->nama_siswa }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Email</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">NIM</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ $user->kode_siswa }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">No. telepon</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ $user->telepon_asal }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Tempat Lahir</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ $user->tempat_lahir }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Tanggal Lahir</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ $user->tanggal_lahir }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Jenis Kelamin</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                   {{ $user->ref_jenis_kelamin == 1 ? "Laki-Laki" : "Perempuan" }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Alamat</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ $user->alamat_asal }}
                                </p>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-2">
                                <p class="key">Agama</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">

                                </p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="alamat" style="display: none">
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')

@endpush
