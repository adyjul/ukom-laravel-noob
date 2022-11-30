@extends('layouts.master-frontend')

@section('title', 'Mahasiswa | Profile')

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
                <div class="col-md-12">
                    <div class="row container select-card m-auto justify-content-center">
                        <div class="col-md-3 col-sm-6">
                            <div data-name="biodata" class="card-select text-center active">
                                <i class="fas fa-user-cog"></i>
                                <p>Biodata</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div data-name="alamat" class="card-select text-center">
                                <i class="fas fa-home"></i>
                                <p>Alamat</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div data-name="data-sekolah" class="card-select text-center">
                                <i class="fas fa-school"></i>
                                <p>Data Sekolah</p>
                            </div>
                        </div>

                    </div>
                    <hr>
                </div>
                <div class="container-fluid isi">
                    <div class="biodata">
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Nama</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ optional($data->user)->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Email</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ optional($data->user)->email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">NIM</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ isset($data->profile) ? $data->profile->nim : '-' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">No. telepon</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">{{ optional($data->user)->phone }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Tempat Lahir</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ isset($data->birth_place) ? $data->birth_place->text : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Tanggal Lahir</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ isset($data->profile) ? $data->profile->birth_date : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Jenis Kelamin</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @php
                                        $jenis_kelamin_arr = [
                                            'l' => 'Laki-Laki',
                                            'p' => 'Perempuan',
                                        ];
                                    @endphp
                                    @foreach ($jenis_kelamin_arr as $k => $v)
                                        {{ $k == (isset($data->profile) ? $data->profile->sex : '') ? $v : '' }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Agama</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @php
                                        $listAgama = ['Islam', 'Kristen Khatholik', 'Kristen Protestan', 'Hindu', 'Budha', 'Lain-lain'];
                                    @endphp
                                    @foreach ($listAgama as $agama)
                                        {{ ($k == isset($data->profile) ? $data->profile->religion_id : '') ? $agama : '' }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="alamat" style="display: none">
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Provinsi</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @if (isset($data->province))
                                        {{ $data->province->text }}
                                    @else
                                        {{ '-' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Kabupaten</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @if (isset($data->regency))
                                        {{ $data->regency->text }}
                                    @else
                                        {{ '-' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Kecamatan</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @if (isset($data->district))
                                        {{ $data->district->text }}
                                    @else
                                        {{ '-' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Kelurahan</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    @if (isset($data->village))
                                        {{ $data->village->text }}
                                    @else
                                        {{ '-' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="data-sekolah" style="display: none">
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Nama Universitas</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ optional(optional($data->user->mahasiswa)->university)['name'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Fakultas</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ optional(optional($data->user->mahasiswa)->university)['fakultas'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Program Studi</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ optional(optional($data->user->mahasiswa)->university)['prodi'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <p class="key">Alamat Sekolah</p>
                            </div>
                            <div class="col-md-4">
                                <p class="value text-muted">
                                    {{ optional(optional($data->user->mahasiswa)->university)['address'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Ubah Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('mahasiswa.profile.change.password') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password Lama</label>
                                        <input type="password" class="form-control" id="exampleInputEmail1"
                                            name="old_password" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password Baru</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            name="password">
                                        <small id="emailHelp" class="form-text text-muted">(minimal 8 katakter,huruf
                                            besar, dan huruf kecil)</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            name="password_confirmation">
                                        <small id="emailHelp" class="form-text text-muted">(minimal 8 katakter,huruf
                                            besar, dan huruf kecil)</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="" style="padding-bottom: 20px;padding-left: 20px;padding-right: 20px;">
                    <div style="display: flex">
                        <a href="{{ route('mahasiswa.biodata.index') }}" class="btn btn-primary mr-4">Edit
                            Profile</a>
                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">Ubah
                            Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    @if ($errors->any())
        <script>
            $("#staticBackdrop").modal('show')
        </script>
    @endif
    @if (session()->get('swal'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                'icon': "{{ session()->get('icon') }}",
                'title': "{{ session()->get('title') }}",
                'text': "{{ session()->get('text') }}",
            })
        </script>
    @endif
    <script>
        $('.card-select').click(function() {
            $('.card-select').removeClass('active')
            $(this).addClass('active')
            var value = $(this).attr("data-name");
            if (value == 'biodata') {
                $('.biodata').show()
                $('.alamat').hide()
                $('.data-sekolah').hide()
                $('.data-bank').hide()
            } else if (value == "alamat") {
                $('.biodata').hide()
                $('.alamat').show()
                $('.data-sekolah').hide()
                $('.data-bank').hide()
            } else if (value == "data-sekolah") {
                $('.biodata').hide()
                $('.alamat').hide()
                $('.data-sekolah').show()
                $('.data-bank').hide()
            } else if (value == 'data-bank') {
                $('.biodata').hide()
                $('.alamat').hide()
                $('.data-sekolah').hide()
                $('.data-bank').show()
            }
        })
    </script>
@endpush
