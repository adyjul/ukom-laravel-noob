@extends('layouts.master-auth')
@section('page-title', 'Mahasiswa | Biodata')

@section('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- Sign In Section -->
    <div class="bg-white col-md-12">
        <div class="content content-full ">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12">
                    <!-- Header -->
                    <div class="text-center">
                        <img src="{{ asset('frontend/images/Logo CoE Color.png') }}" alt="" style="width: 10rem;">
                        <hr>
                        <h1 class="h4 mb-4 font-weight-bold">
                            Biodata Peserta
                        </h1>
                    </div>
                    <!-- END Header -->

                    <div class="col-md-12">
                        <!-- Simple Wizard -->
                        <div class="js-wizard-simple block shadow">
                            <!-- Step Tabs -->
                            <ul class="nav nav-tabs nav-tabs-block nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#wizard-simple-step1" data-toggle="tab">Data
                                        Mahasiswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#wizard-simple-step2" data-toggle="tab">Data Alamat</a>
                                </li>
                                @if($data->user->user_type == 3)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wizard-simple-step3" data-toggle="tab">Data
                                            Universitas</a>
                                    </li>
                                @endif
                            </ul>
                            <!-- END Step Tabs -->

                            <!-- Form -->

                            <!-- Steps Content -->
                            <div class="block-content block-content-full tab-content px-md-5" style="min-height: 300px;">
                                <!-- Step 1 -->
                                <div class="tab-pane active" id="wizard-simple-step1" role="tabpanel">
                                    <div class="card-form">
                                        <input type="hidden" id="user-type" value="{{$data->user->user_type}}">
                                        <form method="post" id="form1" enctype="multipart/form-data" autocomplete="off">
                                            <div class="form-group">
                                                <label style="">Nama lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Nama Lengkap" required
                                                    value="{{ optional($data->user)->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="">{{ $data->user->user_type == 3 ? 'NIM': 'NIK' }}<span class="text-danger">*</span></label>
                                                <input type="text" name="nim" class="form-control" placeholder="{{ $data->user->user_type == 3 ? 'NIM': 'NIK' }}"
                                                    required
                                                    value="{{ isset($data->profile) ? $data->profile->nim : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="">Username <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Username" readonly
                                                    value="{{ optional($data->user)->username }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="">Email <span class="text-danger">*</span></label>
                                                <input type="text" name="email" class="form-control" placeholder="Email"
                                                    readonly value="{{ optional($data->user)->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="">Nomor Telpon (WA) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    name="phone" value="{{ optional($data->user)->phone }}">
                                            </div>
                                            @if (isset($data->birth_place))
                                                <div class="form-group">
                                                    <label style="">Tempat Lahir <span
                                                            class="text-danger">*</span></label>
                                                    <select id="tempat_lahir" class="js-example-basic-multiple form-control"
                                                        name="tempat_lahir" style="width: 100%">
                                                        <option value="{{ $data->birth_place->val }}">
                                                            {{ $data->birth_place->text }}</option>
                                                    </select>
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <label style="">Tempat Lahir <span
                                                            class="text-danger">*</span></label>
                                                    <select id="tempat_lahir" class="js-example-basic-multiple form-control"
                                                        name="tempat_lahir" style="width: 100%">
                                                    </select>
                                                </div>
                                            @endif


                                            <div class="form-group">
                                                <label style="">Tanggal Lahir <span class="text-danger">*</span></label>
                                                <div class="input-group date datepicker">
                                                    <input type="text" class="form-control bs-date-picker"
                                                        name="tanggal_lahir" placeholder="dd/mm/yyyy" data-date-end-date="0d"
                                                        value="{{ isset($data->profile) ? $data->profile->birth_date : '' }}">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label style="">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select class="form-control" name="jenis_kelamin">
                                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                    @php
                                                        $jenis_kelamin_arr = [
                                                            'l' => 'Laki-Laki',
                                                            'p' => 'Perempuan',
                                                        ];
                                                    @endphp
                                                    @foreach ($jenis_kelamin_arr as $k => $v)
                                                        <option value="{{ $k }}"
                                                            {{ $k == (isset($data->profile) ? $data->profile->sex : '') ? 'selected' : '' }}>
                                                            {{ $v }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label style="">Agama <span class="text-danger">*</span></label>
                                                @php
                                                    $listAgama = ['Islam', 'Kristen Khatholik', 'Kristen Protestan', 'Hindu', 'Budha', 'Lain-lain'];
                                                @endphp
                                                <select class="form-control" name="agama">
                                                    <option value="" disabled>Pilih Agama</option>
                                                    @foreach ($listAgama as $agama)
                                                        <option value="{{ $agama }}"
                                                            {{ ($k == isset($data->profile) ? $data->profile->religion_id : '') ? 'selected' : '' }}>
                                                            {{ $agama }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <!-- END Step 1 -->

                                <!-- Step 2 -->
                                <div class="tab-pane" id="wizard-simple-step2" role="tabpanel">
                                    <div class="card-form">
                                        <form method="post" id="form2" enctype="multipart/form-data" autocomplete="off">
                                            <div class="input-ind">
                                                @if (isset($data->province))
                                                    <div class="form-group">
                                                        <label for="">Provinsi <span class="text-danger">*</span></label>
                                                        <select id="provinsi" class="js-example-basic-multiple form-control"
                                                            name="provinsi" style="width: 100%">
                                                            <option value="{{ $data->province->val }}">
                                                                {{ $data->province->text }}</option>
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="">Provinsi <span class="text-danger">*</span></label>
                                                        <select id="provinsi" class="js-example-basic-multiple form-control"
                                                            name="provinsi" style="width: 100%">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                @endif
                                                @if (isset($data->regency))
                                                    <div class="form-group">
                                                        <label for="">Kabupaten <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kabupaten"
                                                            class="js-example-basic-multiple form-control" name="kabupaten"
                                                            style="width: 100%">
                                                            <option value="{{ $data->regency->val }}">
                                                                {{ $data->regency->text }}</option>
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="">Kabupaten <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kabupaten"
                                                            class="js-example-basic-multiple form-control" name="kabupaten"
                                                            style="width: 100%">
                                                        </select>
                                                    </div>
                                                @endif
                                                @if (isset($data->district))
                                                    <div class="form-group">
                                                        <label for="">Kecamatan <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kecamatan"
                                                            class="js-example-basic-multiple form-control" name="kecamatan"
                                                            style="width: 100%">
                                                            <option value="{{ $data->district->val }}">
                                                                {{ $data->district->text }}</option>
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="">Kecamatan <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kecamatan"
                                                            class="js-example-basic-multiple form-control" name="kecamatan"
                                                            style="width: 100%">
                                                        </select>
                                                    </div>
                                                @endif
                                                @if (isset($data->village))
                                                    <div class="form-group">
                                                        <label for="">Kelurahan/Desa <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kelurahan"
                                                            class="js-example-basic-multiple form-control" name="kelurahan"
                                                            style="width: 100%">
                                                            <option value="{{ $data->village->val }}">
                                                                {{ $data->village->text }}</option>
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="">Kelurahan/Desa <span
                                                                class="text-danger">*</span></label>
                                                        <select id="kelurahan"
                                                            class="js-example-basic-multiple form-control" name="kelurahan"
                                                            style="width: 100%">
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label style="">Alamat<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="alamat_detail" class="form-control" placeholder="Detail Alamat Asal"
                                                    required>{{ optional(optional($data->user->mahasiswa)->address)['detail'] ?? '' }}</textarea>
                                            </div>
                                            <div class="input-luar" style="display: none">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Step 2 -->

                                <!-- Step 3 -->
                                <div class="tab-pane" id="wizard-simple-step3" role="tabpanel">
                                    <div class="card-form">
                                        <form method="post" id="form3" enctype="multipart/form-data" autocomplete="off">
                                            <div class="form-group">
                                                <label style="">Nama Universitas <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="nama_universitas" class="form-control"
                                                    placeholder="Nama Universitas" required
                                                    value="{{ optional(optional($data->user->mahasiswa)->university)['name'] ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="">Fakultas <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="nama_fakultas" class="form-control"
                                                    placeholder="Fakultas" required
                                                    value="{{ optional(optional($data->user->mahasiswa)->university)['fakultas'] ?? '' }}">
                                                <span class="text-danger">Contoh: Fakultas Teknik, Fakultas Psikologi, Fakultas Hukum, dst.</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="">Program Studi <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="nama_prodi" class="form-control"
                                                    placeholder="Program Studi" required
                                                    value="{{ optional(optional($data->user->mahasiswa)->university)['prodi'] ?? '' }}">
                                                <span class="text-danger">Contoh: Informatika, Teknik Mesin, Ilmu Komunikasi, Hukum, dst.</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="">Alamat Universitas <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="alamat_universitas" class="form-control" placeholder="Alamat Universitas"
                                                    required>{{ optional(optional($data->user->mahasiswa)->university)['address'] ?? '' }}</textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Step 3 -->
                            </div>
                            <!-- END Steps Content -->

                            <!-- Steps Navigation -->
                            <div class="block-content block-content-sm block-content-full bg-body-light rounded-bottom">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-alt-primary" data-wizard="prev">
                                            <i class="fa fa-angle-left mr-1"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-alt-primary" data-wizard="next">
                                            Next <i class="fa fa-angle-right ml-1"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary submit d-none" data-wizard="finish">
                                            <i class="fa fa-check mr-1"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- END Steps Navigation -->

                            <!-- END Form -->
                        </div>
                        <!-- END Simple Wizard -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Sign In Section -->
@endsection

@section('scripts')
    <script src="{{ asset('oneUI/js/plugins/jquery-bootstrap-wizard/bs4/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('oneUI/js/be_forms_wizard.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        $(".bs-date-picker").datepicker({
            calendarWeeks: true,
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        })


        function select(value) {
            $(`#${value}`).select2({
                theme: 'bootstrap4',
                placeholder: `Cari ${value}`,
                allowClear: true,
            })
        }

        //url
        let urlProvinsi = "{{ route('api.region.get.province') }}";
        let urlKabupaten = "{{ route('api.region.get.regency', ['id' => '__id']) }}";
        let urlKecamatan = "{{ route('api.region.get.district', ['id' => '__id']) }}";
        let urlKelurahan = "{{ route('api.region.get.village', ['id' => '__id']) }}";
        let urlKotaLahir = "{{ route('api.region.select2.regency') }}";



        //select
        select('provinsi');
        select('kabupaten');
        select('kecamatan');
        select('kelurahan');

        $('#tempat_lahir').select2({
            theme: 'bootstrap4',
            ajax: {
                url: function(params) {
                    return urlKotaLahir + "/" + params.term
                },
                dataType: "json",
                data: function(params) {
                    return {
                        // search: params.term
                    }
                },
                processResults: function(data, page) {
                    return {
                        results: data.data
                    }
                },
                delay: 250
            },
            placeholder: 'Cari Tempat Lahir',
            closeOnSelect: true,

        });



        fetch(urlProvinsi)
            .then(response => response.json())
            .then(result => {
                result.data.map(hasil => {
                    $('#provinsi').append(
                        `<option value="${hasil.id}">${hasil.name}</option>`)
                })
                $("#kabupaten").removeAttr("disabled");
            })

        $("#provinsi").on("change", function() {
            fetch(urlKabupaten.replace('__id', $(this).val()))
                .then(response => response.json())
                .then(result => {
                    if (result.status) {
                        $('#kabupaten option').remove()
                        $('#kabupaten').append(
                            `<option disabled selected>--Cari Kabupaten--</option>`)
                        result.data.map(hasil => {
                            $('#kabupaten').append(
                                `<option value="${hasil.id}">${hasil.name}</option>`)

                        })
                    } else {
                        window.location.href = result.auth_url
                    }
                    $("#kabupaten").removeAttr("disabled");
                })

        })

        $("#kabupaten").on("change", function() {
            fetch(urlKecamatan.replace('__id', $(this).val()))
                .then(response => response.json())
                .then(result => {
                    if (result.status) {
                        $('#kecamatan option').remove()
                        $('#kecamatan').append(
                            `<option disabled selected>--Cari Kecamatan--</option>`)
                        result.data.map(hasil => {
                            $('#kecamatan').append(
                                `<option value="${hasil.id}">${hasil.name}</option>`)

                        })


                    } else {
                        window.location.href = result.auth_url
                    }
                    $("#kecamatan").removeAttr("disabled");
                })

        })

        $("#kecamatan").on("change", function() {
            fetch(urlKelurahan.replace('__id', $(this).val()))
                .then(response => response.json())
                .then(result => {
                    if (result.status) {
                        $('#kelurahan option').remove()
                        $('#kelurahan').append(
                            `<option disabled selected>--Cari Kelurahan--</option>`)
                        result.data.map(hasil => {
                            $('#kelurahan').append(
                                `<option value="${hasil.id}">${hasil.name}</option>`)
                        })
                    } else {
                        window.location.href = result.auth_url
                    }
                    $("#kelurahan").removeAttr("disabled");
                })
        })

        $(document).on('click', '.submit', function() {
            loader.show();
            let user_type = $('#user-type').val();
            console.log(user_type);
            let urlStore;
            if(user_type == 3){
                urlStore = "{{ route('mahasiswa.biodata.store') }}"

                console.log('mahasiswa');

                var form1 = $('#form1')[0];
                var form2 = $('#form2')[0];
                var form3 = $('#form3')[0];
                var data_form1 = new FormData(form1);
                var data_form2 = new FormData(form2);
                var data_form3 = new FormData(form3);

                for (var pair of data_form2.entries()) {
                    data_form1.append(pair[0], pair[1]);
                }

                for (var pair of data_form3.entries()) {
                    data_form1.append(pair[0], pair[1]);
                }
            }else{
                urlStore = "{{ route('mahasiswa.biodata.store_umum') }}"
                console.log('umum');

                var form1 = $('#form1')[0];
                var form2 = $('#form2')[0];
                var data_form1 = new FormData(form1);
                var data_form2 = new FormData(form2);

                for (var pair of data_form2.entries()) {
                    data_form1.append(pair[0], pair[1]);
                }

            }

            fetch(urlStore, {
                    method: 'post',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: data_form1
                })
                .then(res => res.json())
                .then(result => {
                    if (result.code === 200) {
                        Swal.fire({
                            'icon': 'success',
                            'title': result.message
                        }).then(() => {
                            window.location.href = "{{ route('mahasiswa.profile.index') }}";
                        })

                    } else {
                        throw result.message
                    }
                }).catch(err => {
                    Swal.fire({
                        'icon': 'error',
                        'title': 'Data Gagal Diinput',
                        'text': err
                    })
                }).finally(() => loader.hide())


        })
    </script>

@endsection
